<?php

namespace App\Models;

use App\Traits\{HasStatus, Timestampable};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Owner extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasStatus, Timestampable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'shop_name',
        'shop_description',
        'phone',
        'address',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * デフォルト値
     */
    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * 商品との関係性
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * 注文との関係性（店舗の注文）
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * アクティブな商品のみ取得
     */
    public function activeProducts(): HasMany
    {
        return $this->products()->where('is_active', true);
    }

    /**
     * 商品の総数を取得
     */
    public function getProductCountAttribute(): int
    {
        return $this->products()->count();
    }

    /**
     * アクティブな商品の総数を取得
     */
    public function getActiveProductCountAttribute(): int
    {
        return $this->activeProducts()->count();
    }

    /**
     * 店舗の総売上を取得
     */
    public function getTotalSalesAttribute(): int
    {
        return $this->orders()
            ->where('status', 'completed')
            ->sum('total_amount');
    }

    /**
     * 店舗名を取得（未設定の場合はオーナー名を返す）
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->shop_name ?: $this->name;
    }
}
