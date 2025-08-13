<?php

namespace Database\Seeders;

use App\Models\Owner;
use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テスト用オーナー
        Owner::factory()->create([
            'name' => 'テストオーナー',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'),
            'shop_name' => 'テストショップ',
            'shop_description' => 'テスト用のショップです。様々な商品を取り揃えています。',
            'phone' => '03-1234-5678',
            'address' => '東京都渋谷区テスト1-1-1',
            'is_active' => true,
        ]);

        // アクティブなオーナー
        Owner::factory(10)->active()->create();

        // 非アクティブなオーナー
        Owner::factory(3)->inactive()->create();

        // 店舗名なしのオーナー
        Owner::factory(2)->withoutShopName()->create();

        // 店舗説明なしのオーナー
        Owner::factory(2)->withoutShopDescription()->create();

        // 電話番号なしのオーナー
        Owner::factory(2)->withoutPhone()->create();

        // 住所なしのオーナー
        Owner::factory(2)->withoutAddress()->create();

        // メール未認証のオーナー
        Owner::factory(3)->unverified()->create();
    }
}
