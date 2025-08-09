<?php

namespace App\Models;

use App\Traits\Timestampable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory, SoftDeletes, Timestampable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
        'alt_text',
        'sort_order',
        'thumbnail_path',
        'is_primary',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'file_size' => 'integer',
        'sort_order' => 'integer',
        'is_primary' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * デフォルト値
     */
    protected $attributes = [
        'sort_order' => 0,
        'is_primary' => false,
    ];

    /**
     * 商品との関係性
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * この画像をカバー画像として使用している商品
     */
    public function productsAsCover()
    {
        return $this->hasMany(Product::class, 'cover_image_id');
    }

    /**
     * フルURLを取得
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * サムネイルURLを取得
     */
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail_path) {
            return asset('storage/' . $this->thumbnail_path);
        }
        return $this->url; // サムネイルがない場合は元画像を返す
    }

    /**
     * ファイルサイズを人間が読める形式で取得
     */
    public function getHumanFileSizeAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * 画像かどうかチェック
     */
    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * プライマリ画像かどうか
     */
    public function isPrimary(): bool
    {
        return $this->is_primary;
    }

    /**
     * alt属性取得（未設定の場合は商品名を使用）
     */
    public function getAltAttribute(): string
    {
        return $this->alt_text ?: ($this->product->name ?? 'Product Image');
    }

    /**
     * ソート順スコープ
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    /**
     * プライマリ画像のみ
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * 画像のみ
     */
    public function scopeImages($query)
    {
        return $query->where('mime_type', 'like', 'image/%');
    }

    /**
     * 指定サイズ以下
     */
    public function scopeMaxSize($query, int $maxSize)
    {
        return $query->where('file_size', '<=', $maxSize);
    }
}
