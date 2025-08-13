<?php

namespace App\Enums;

enum UserType: string
{
    case USER = 'user';
    case OWNER = 'owner';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match($this) {
            self::USER => '購入者',
            self::OWNER => '店舗運営者',
            self::ADMIN => '管理者',
        };
    }

    public function getGuard(): string
    {
        return match($this) {
            self::USER => 'user',
            self::OWNER => 'owner',
            self::ADMIN => 'admin',
        };
    }

    public function getHomeRoute(): string
    {
        return match($this) {
            self::USER => 'user.dashboard',
            self::OWNER => 'owner.dashboard',
            self::ADMIN => 'admin.dashboard',
        };
    }

    public function getLoginRoute(): string
    {
        return match($this) {
            self::USER => 'login',
            self::OWNER => 'owner.login',
            self::ADMIN => 'admin.login',
        };
    }

    public function getRegisterRoute(): string
    {
        return match($this) {
            self::USER => 'register',
            self::OWNER => 'owner.register',
            self::ADMIN => 'admin.register',
        };
    }

    public function getPrefix(): string
    {
        return match($this) {
            self::USER => 'user',
            self::OWNER => 'owner',
            self::ADMIN => 'admin',
        };
    }

    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    public function isOwner(): bool
    {
        return $this === self::OWNER;
    }

    public function isUser(): bool
    {
        return $this === self::USER;
    }

    public static function getSelectOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($type) => [$type->value => $type->label()])
            ->toArray();
    }
}
