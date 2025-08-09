<?php

namespace App\Helpers;

class PriceHelper
{
    /**
     * 価格を日本円形式でフォーマット
     */
    public static function format(int $price): string
    {
        return '¥' . number_format($price);
    }

    /**
     * 価格を税込みでフォーマット
     */
    public static function formatWithTax(int $price, float $taxRate = 0.1): string
    {
        $taxIncludedPrice = self::calculateTaxIncluded($price, $taxRate);
        return self::format($taxIncludedPrice);
    }

    /**
     * 税込み価格を計算
     */
    public static function calculateTaxIncluded(int $price, float $taxRate = 0.1): int
    {
        return (int) round($price * (1 + $taxRate));
    }

    /**
     * 税額を計算
     */
    public static function calculateTax(int $price, float $taxRate = 0.1): int
    {
        return (int) round($price * $taxRate);
    }

    /**
     * 価格データをサニタイズ
     */
    public static function sanitize($price): int
    {
        $price = (int) preg_replace('/[^0-9]/', '', $price);
        return max(0, $price);
    }

    /**
     * 価格範囲を検証
     */
    public static function validatePriceRange(int $minPrice, int $maxPrice): bool
    {
        return $minPrice >= 0 && $maxPrice >= $minPrice;
    }

    /**
     * 割引価格を計算
     */
    public static function calculateDiscount(int $originalPrice, int $discountPrice): int
    {
        return max(0, $originalPrice - $discountPrice);
    }

    /**
     * 割引率を計算
     */
    public static function calculateDiscountRate(int $originalPrice, int $discountPrice): float
    {
        if ($originalPrice <= 0) return 0;
        return round((($originalPrice - $discountPrice) / $originalPrice) * 100, 1);
    }
}
