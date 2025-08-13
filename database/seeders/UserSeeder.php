<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テスト用ユーザー
        User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'guard' => 'user',
        ]);

        // 管理者ユーザー
        User::factory()->create([
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'guard' => 'user',
        ]);

        // 一般ユーザー（ランダム）
        User::factory(20)->create([
            'guard' => 'user',
        ]);

        // メール未認証ユーザー
        User::factory(5)->unverified()->create([
            'guard' => 'user',
        ]);
    }
}
