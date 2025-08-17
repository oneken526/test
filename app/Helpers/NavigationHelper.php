<?php

namespace App\Helpers;

class NavigationHelper
{
    /**
     * 現在のルートが指定されたルートと一致するかチェック
     */
    public static function isActive(string $routeName): bool
    {
        return request()->routeIs($routeName);
    }

    /**
     * 現在のルートが指定されたルートパターンに一致するかチェック
     */
    public static function isActivePattern(string $pattern): bool
    {
        return request()->routeIs($pattern);
    }

    /**
     * ダッシュボードがアクティブかチェック
     */
    public static function isDashboardActive(): bool
    {
        return self::isActive('owner.dashboard');
    }

    /**
     * 商品管理がアクティブかチェック
     */
    public static function isProductsActive(): bool
    {
        return self::isActivePattern('owner.products.*');
    }

    /**
     * 注文管理がアクティブかチェック
     */
    public static function isOrdersActive(): bool
    {
        return self::isActivePattern('owner.orders.*');
    }

    /**
     * プロフィールがアクティブかチェック
     */
    public static function isProfileActive(): bool
    {
        return self::isActivePattern('owner.profile.*');
    }
}
