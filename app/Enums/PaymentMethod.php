<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CREDIT_CARD = '1';
    case BANK_TRANSFER = '2';
    case COD = '3'; // Cash on Delivery
    case DIGITAL_WALLET = '4';

    public function label(): string
    {
        return match($this) {
            self::CREDIT_CARD => 'クレジットカード',
            self::BANK_TRANSFER => '銀行振込',
            self::COD => '代金引換',
            self::DIGITAL_WALLET => 'デジタルウォレット',
        };
    }

    public function fee(): int
    {
        return match($this) {
            self::CREDIT_CARD => 0,
            self::BANK_TRANSFER => 330,
            self::COD => 440,
            self::DIGITAL_WALLET => 0,
        };
    }

    public function isImmediate(): bool
    {
        return in_array($this, [self::CREDIT_CARD, self::DIGITAL_WALLET]);
    }

    public function requiresConfirmation(): bool
    {
        return in_array($this, [self::BANK_TRANSFER, self::COD]);
    }

    public function getDescription(): string
    {
        return match($this) {
            self::CREDIT_CARD => 'VISA、MasterCard、JCB等の主要クレジットカードがご利用いただけます',
            self::BANK_TRANSFER => '銀行振込でのお支払い（手数料330円）',
            self::COD => '商品到着時に代金をお支払い（手数料440円）',
            self::DIGITAL_WALLET => 'PayPay、LINE Pay等のデジタルウォレット',
        };
    }

    public function getIcon(): string
    {
        return match($this) {
            self::CREDIT_CARD => 'credit-card',
            self::BANK_TRANSFER => 'bank',
            self::COD => 'cash',
            self::DIGITAL_WALLET => 'wallet',
        };
    }

    public static function getSelectOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($method) => [$method->value => $method->label()])
            ->toArray();
    }

    public static function getImmediateOptions(): array
    {
        return collect(self::cases())
            ->filter(fn($method) => $method->isImmediate())
            ->mapWithKeys(fn($method) => [$method->value => $method->label()])
            ->toArray();
    }
}
