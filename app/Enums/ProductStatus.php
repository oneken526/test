<?php

namespace App\Enums;

enum ProductStatus: string
{
    case DRAFT = '1';
    case ACTIVE = '2';
    case INACTIVE = '3';
    case OUT_OF_STOCK = '4';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => '下書き',
            self::ACTIVE => '販売中',
            self::INACTIVE => '販売停止',
            self::OUT_OF_STOCK => '在庫切れ',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'secondary',
            self::ACTIVE => 'success',
            self::INACTIVE => 'danger',
            self::OUT_OF_STOCK => 'warning',
        };
    }

    public function isAvailableForPurchase(): bool
    {
        return $this === self::ACTIVE;
    }

    public function isVisible(): bool
    {
        return in_array($this, [self::ACTIVE, self::OUT_OF_STOCK]);
    }

    public function isEditable(): bool
    {
        return in_array($this, [self::DRAFT, self::ACTIVE, self::INACTIVE]);
    }

    public function canBeActivated(): bool
    {
        return in_array($this, [self::DRAFT, self::INACTIVE]);
    }

    public function canBeDeactivated(): bool
    {
        return in_array($this, [self::ACTIVE, self::OUT_OF_STOCK]);
    }

    public static function getSelectOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($status) => [$status->value => $status->label()])
            ->toArray();
    }

    public static function getVisibleOptions(): array
    {
        return collect(self::cases())
            ->filter(fn($status) => $status->isVisible())
            ->mapWithKeys(fn($status) => [$status->value => $status->label()])
            ->toArray();
    }
}
