<?php

namespace App\Models;

use App\Traits\{HasStatus, Timestampable};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes, HasStatus, Timestampable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'owner_id',
        'order_number',
        'status',
        'total_amount',
        'tax_amount',
        'shipping_fee',
        'payment_method',
        'payment_status',
        'shipping_name',
        'shipping_postal_code',
        'shipping_address',
        'shipping_phone',
        'notes',
        'ordered_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'integer',
        'tax_amount' => 'integer',
        'shipping_fee' => 'integer',
        'ordered_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * デフォルト値
     */
    protected $attributes = [
        'status' => '1',
        'payment_status' => '1',
        'shipping_fee' => 0,
        'tax_amount' => 0,
    ];

    /**
     * ユーザー（購入者）との関係性
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * オーナー（店舗）との関係性
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * 注文アイテムとの関係性
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * 注文番号を生成
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $timestamp = now()->format('YmdHis');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

        return $prefix . $timestamp . $random;
    }

    /**
     * 小計金額を取得
     */
    public function getSubtotalAttribute(): int
    {
        return $this->orderItems->sum('total_price');
    }

    /**
     * 商品の総数量を取得
     */
    public function getTotalQuantityAttribute(): int
    {
        return $this->orderItems->sum('quantity');
    }

    /**
     * 注文がキャンセル可能かチェック
     */
    public function isCancellable(): bool
    {
        return in_array($this->status, ['1', '2', '3']);
    }

    /**
     * 注文が配送済みかチェック
     */
    public function isShipped(): bool
    {
        return !is_null($this->shipped_at);
    }

    /**
     * 注文が配達済みかチェック
     */
    public function isDelivered(): bool
    {
        return !is_null($this->delivered_at);
    }

    /**
     * 注文がキャンセル済みかチェック
     */
    public function isCancelled(): bool
    {
        return !is_null($this->cancelled_at);
    }

    /**
     * 支払いが完了しているかチェック
     */
    public function isPaid(): bool
    {
        return $this->payment_status === '3';
    }

    /**
     * 注文ステータスを日本語で取得
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            '1' => '注文確認中',
            '2' => '注文確定',
            '3' => '準備中',
            '4' => '発送済み',
            '5' => '配達完了',
            '6' => 'キャンセル',
            '7' => '完了',
            default => '不明',
        };
    }

    /**
     * 支払いステータスを日本語で取得
     */
    public function getPaymentStatusLabelAttribute(): string
    {
        return match($this->payment_status) {
            '1' => '支払い待ち',
            '2' => '処理中',
            '3' => '支払い完了',
            '4' => '支払い失敗',
            '5' => '返金済み',
            default => '不明',
        };
    }

    /**
     * 配送先住所を1行で取得
     */
    public function getFullShippingAddressAttribute(): string
    {
        return "〒{$this->shipping_postal_code} {$this->shipping_address}";
    }

    /**
     * 指定期間の注文スコープ
     */
    public function scopeDateRange($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        return $query;
    }

    /**
     * 指定ステータスの注文スコープ
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * 完了した注文のみ
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', '7');
    }

    /**
     * 支払い完了済みの注文のみ
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', '3');
    }
}
