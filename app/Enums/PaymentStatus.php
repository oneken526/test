<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = '1';
    case PROCESSING = '2';
    case COMPLETED = '3';
    case FAILED = '4';
    case REFUNDED = '5';

    public function label(): string
    {
        return match($this) {
            self::PENDING => '未決済',
            self::PROCESSING => '処理中',
            self::COMPLETED => '決済完了',
            self::FAILED => '決済失敗',
            self::REFUNDED => '返金済み',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::PROCESSING => 'info',
            self::COMPLETED => 'success',
            self::FAILED => 'danger',
            self::REFUNDED => 'secondary',
        };
    }

    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }

    public function isPending(): bool
    {
        return in_array($this, [self::PENDING, self::PROCESSING]);
    }

    public function isFailed(): bool
    {
        return in_array($this, [self::FAILED, self::REFUNDED]);
    }

    public function canBeRefunded(): bool
    {
        return $this === self::COMPLETED;
    }

    public function canBeRetried(): bool
    {
        return $this === self::FAILED;
    }

    public static function getSelectOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($status) => [$status->value => $status->label()])
            ->toArray();
    }
}
