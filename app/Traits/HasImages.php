<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasImages
{
    /**
     * 画像との関係性
     */
    public function images(): HasMany
    {
        return $this->hasMany(\App\Models\ProductImage::class);
    }

    /**
     * カバー画像との関係性
     */
    public function coverImage(): BelongsTo
    {
        return $this->belongsTo(\App\Models\ProductImage::class, 'cover_image_id');
    }

    /**
     * メイン画像を取得
     */
    public function getMainImageAttribute()
    {
        return $this->coverImage ?: $this->images->first();
    }

    /**
     * 画像が存在するかチェック
     */
    public function hasImages(): bool
    {
        return $this->images()->exists();
    }

    /**
     * カバー画像が設定されているかチェック
     */
    public function hasCoverImage(): bool
    {
        return !is_null($this->cover_image_id);
    }

    /**
     * 画像の総数を取得
     */
    public function getImageCountAttribute(): int
    {
        return $this->images()->count();
    }
}
