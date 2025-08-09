<?php

namespace App\Traits;

use Carbon\Carbon;

trait Timestampable
{
    /**
     * 作成日時を日本語フォーマットで取得
     */
    public function getCreatedAtJapaneseAttribute(): string
    {
        return $this->created_at->format('Y年n月j日 G:i');
    }

    /**
     * 更新日時を日本語フォーマットで取得
     */
    public function getUpdatedAtJapaneseAttribute(): string
    {
        return $this->updated_at->format('Y年n月j日 G:i');
    }

    /**
     * 作成日時を相対時間で取得
     */
    public function getCreatedAtDiffAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * 更新日時を相対時間で取得
     */
    public function getUpdatedAtDiffAttribute(): string
    {
        return $this->updated_at->diffForHumans();
    }

    /**
     * 指定期間内に作成されたレコードを取得
     */
    public function scopeCreatedWithin($query, int $days = 7)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days));
    }

    /**
     * 指定期間内に更新されたレコードを取得
     */
    public function scopeUpdatedWithin($query, int $days = 7)
    {
        return $query->where('updated_at', '>=', Carbon::now()->subDays($days));
    }

    /**
     * 今日作成されたレコードを取得
     */
    public function scopeCreatedToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    /**
     * 今日更新されたレコードを取得
     */
    public function scopeUpdatedToday($query)
    {
        return $query->whereDate('updated_at', Carbon::today());
    }
}
