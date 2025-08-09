<?php

namespace App\Models;

use App\Traits\{HasImages, HasStatus, Timestampable};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasImages, HasStatus, Timestampable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'description',
        'price',
        'stock_quantity',
        'category',
        'is_active',
        'cover_image_id',
        'is_featured',
        'weight',
        'dimensions',
        'sku',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'integer',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'weight' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * デフォルト値
     */
    protected $attributes = [
        'is_active' => true,
        'stock_quantity' => 0,
        'is_featured' => false,
    ];

    /**
     * オーナーとの関係性
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * 商品画像との関係性
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * カバー画像との関係性
     */
    public function coverImage(): BelongsTo
    {
        return $this->belongsTo(ProductImage::class, 'cover_image_id');
    }

    /**
     * 注文アイテムとの関係性
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * 在庫があるかチェック
     */
    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    /**
     * 購入可能かチェック
     */
    public function isPurchasable(): bool
    {
        return $this->isActive() && $this->isInStock();
    }

    /**
     * 注目商品かチェック
     */
    public function isFeatured(): bool
    {
        return $this->is_featured;
    }

    /**
     * 価格をフォーマット（ヘルパー使用予定）
     */
    public function getFormattedPriceAttribute(): string
    {
        return '¥' . number_format($this->price);
    }

    /**
     * 在庫状況を文字列で取得
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->stock_quantity <= 0) {
            return '在庫切れ';
        } elseif ($this->stock_quantity <= 10) {
            return '残りわずか';
        }
        return '在庫あり';
    }

    /**
     * 売上数量を取得
     */
    public function getSoldQuantityAttribute(): int
    {
        return $this->orderItems()
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed');
            })
            ->sum('quantity');
    }

    /**
     * 売上金額を取得
     */
    public function getTotalSalesAttribute(): int
    {
        return $this->orderItems()
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed');
            })
            ->sum('total_price');
    }

    /**
     * カテゴリ別スコープ
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * 価格範囲スコープ
     */
    public function scopePriceRange($query, int $minPrice = null, int $maxPrice = null)
    {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }

    /**
     * 在庫ありのみ
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    /**
     * 注目商品のみ
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * 検索スコープ
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%");
        });
    }
}
