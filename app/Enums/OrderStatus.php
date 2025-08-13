<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = '1';
    case CONFIRMED = '2';
    case PREPARING = '3';
    case SHIPPED = '4';
    case DELIVERED = '5';
    case CANCELLED = '6';
    case COMPLETED = '7';

    public function label(): string
    {
        return match($this) {
            self::PENDING => '注文確認中',
            self::CONFIRMED => '注文確定',
            self::PREPARING => '準備中',
            self::SHIPPED => '発送済み',
            self::DELIVERED => '配送完了',
            self::CANCELLED => 'キャンセル',
            self::COMPLETED => '完了',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::CONFIRMED => 'info',
            self::PREPARING => 'primary',
            self::SHIPPED => 'success',
            self::DELIVERED => 'success',
            self::CANCELLED => 'danger',
            self::COMPLETED => 'success',
        };
    }

    public function isActive(): bool
    {
        return !in_array($this, [self::CANCELLED, self::COMPLETED]);
    }

    public function canBeCancelled(): bool
    {
        return in_array($this, [self::PENDING, self::CONFIRMED]);
    }

    public function isShipped(): bool
    {
        return in_array($this, [self::SHIPPED, self::DELIVERED, self::COMPLETED]);
    }

    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }

    public static function getSelectOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($status) => [$status->value => $status->label()])
            ->toArray();
    }

    public static function getActiveOptions(): array
    {
        return collect(self::cases())
            ->filter(fn($status) => $status->isActive())
            ->mapWithKeys(fn($status) => [$status->value => $status->label()])
            ->toArray();
    }
}
