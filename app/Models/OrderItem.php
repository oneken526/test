<?php

namespace App\Models;

use App\Traits\Timestampable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory, Timestampable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'quantity',
        'total_price',
        'product_sku',
        'product_image_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'product_price' => 'integer',
        'quantity' => 'integer',
        'total_price' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * 注文との関係性
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * 商品との関係性
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * 単価をフォーマット
     */
    public function getFormattedPriceAttribute(): string
    {
        return '¥' . number_format($this->product_price);
    }

    /**
     * 合計金額をフォーマット
     */
    public function getFormattedTotalPriceAttribute(): string
    {
        return '¥' . number_format($this->total_price);
    }

    /**
     * 商品が存在するかチェック
     */
    public function hasProduct(): bool
    {
        return !is_null($this->product_id) && $this->product()->exists();
    }

    /**
     * 商品が削除されているかチェック
     */
    public function isProductDeleted(): bool
    {
        return !$this->hasProduct();
    }

    /**
     * 表示用商品名取得（商品が削除されている場合は保存済み名称を使用）
     */
    public function getDisplayProductNameAttribute(): string
    {
        return $this->hasProduct() ? $this->product->name : $this->product_name;
    }

    /**
     * 表示用商品画像URL取得
     */
    public function getDisplayImageUrlAttribute(): string
    {
        if ($this->hasProduct() && $this->product->main_image) {
            return $this->product->main_image->url;
        }
        return $this->product_image_url ?: asset('images/no-image.png');
    }

    /**
     * 小計計算
     */
    public function calculateTotalPrice(): int
    {
        return $this->product_price * $this->quantity;
    }

    /**
     * 小計を更新
     */
    public function updateTotalPrice(): bool
    {
        $this->total_price = $this->calculateTotalPrice();
        return $this->save();
    }

    /**
     * 商品情報を現在の状態で保存
     */
    public function saveProductSnapshot(): void
    {
        if ($this->product) {
            $this->product_name = $this->product->name;
            $this->product_price = $this->product->price;
            $this->product_sku = $this->product->sku;
            
            if ($this->product->main_image) {
                $this->product_image_url = $this->product->main_image->url;
            }
        }
    }

    /**
     * 数量変更
     */
    public function updateQuantity(int $quantity): bool
    {
        $this->quantity = $quantity;
        $this->updateTotalPrice();
        return $this->save();
    }

    /**
     * 注文アイテムの作成時に商品情報を自動保存
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($orderItem) {
            $orderItem->saveProductSnapshot();
            $orderItem->total_price = $orderItem->calculateTotalPrice();
        });

        static::updating(function ($orderItem) {
            if ($orderItem->isDirty(['quantity', 'product_price'])) {
                $orderItem->total_price = $orderItem->calculateTotalPrice();
            }
        });
    }
}
