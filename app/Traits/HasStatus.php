<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasStatus
{
    /**
     * アクティブなレコードのみ取得
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * 非アクティブなレコードのみ取得
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('is_active', false);
    }

    /**
     * 指定ステータスのレコードを取得
     */
    public function scopeWithStatus(Builder $query, string $status): Builder
    {
        return $query->where('is_active', $status === 'active');
    }

    /**
     * ステータスがアクティブかチェック
     */
    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    /**
     * ステータスが非アクティブかチェック
     */
    public function isInactive(): bool
    {
        return $this->is_active === false;
    }

    /**
     * ステータスを変更
     */
    public function setStatus(bool $status): bool
    {
        $this->is_active = $status;
        return $this->save();
    }

    /**
     * アクティブに変更
     */
    public function activate(): bool
    {
        return $this->setStatus(true);
    }

    /**
     * 非アクティブに変更
     */
    public function deactivate(): bool
    {
        return $this->setStatus(false);
    }
}
