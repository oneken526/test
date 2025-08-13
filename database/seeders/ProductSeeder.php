<?php

namespace Database\Seeders;

use App\Models\{Product, Owner};
use App\Constants\ProductConsts;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owners = Owner::where('is_active', true)->get();

        if ($owners->isEmpty()) {
            $this->command->warn('アクティブなオーナーが見つかりません。OwnerSeederを先に実行してください。');
            return;
        }

        // 各オーナーに対して商品を作成
        foreach ($owners as $owner) {
            // アクティブな商品
            Product::factory(15)
                ->active()
                ->create(['owner_id' => $owner->id]);

            // 注目商品
            Product::factory(3)
                ->featured()
                ->create(['owner_id' => $owner->id]);

            // 在庫切れ商品
            Product::factory(2)
                ->outOfStock()
                ->create(['owner_id' => $owner->id]);

            // 在庫少商品
            Product::factory(3)
                ->lowStock()
                ->create(['owner_id' => $owner->id]);

            // 非アクティブな商品
            Product::factory(5)
                ->inactive()
                ->create(['owner_id' => $owner->id]);

            // カテゴリ別商品
            Product::factory(5)
                ->electronics()
                ->active()
                ->create(['owner_id' => $owner->id]);

            Product::factory(5)
                ->clothing()
                ->active()
                ->create(['owner_id' => $owner->id]);

            Product::factory(5)
                ->books()
                ->active()
                ->create(['owner_id' => $owner->id]);

            Product::factory(5)
                ->furniture()
                ->active()
                ->create(['owner_id' => $owner->id]);

            Product::factory(5)
                ->sports()
                ->active()
                ->create(['owner_id' => $owner->id]);

            Product::factory(5)
                ->beauty()
                ->active()
                ->create(['owner_id' => $owner->id]);

            Product::factory(5)
                ->food()
                ->active()
                ->create(['owner_id' => $owner->id]);

            Product::factory(5)
                ->toys()
                ->active()
                ->create(['owner_id' => $owner->id]);

            // 価格帯別商品
            Product::factory(10)
                ->cheap()
                ->active()
                ->create(['owner_id' => $owner->id]);

            Product::factory(5)
                ->expensive()
                ->active()
                ->create(['owner_id' => $owner->id]);

            // 説明なしの商品
            Product::factory(3)
                ->withoutDescription()
                ->active()
                ->create(['owner_id' => $owner->id]);

            // カテゴリなしの商品
            Product::factory(3)
                ->withoutCategory()
                ->active()
                ->create(['owner_id' => $owner->id]);

            // SKUなしの商品
            Product::factory(3)
                ->withoutSku()
                ->active()
                ->create(['owner_id' => $owner->id]);

            // 重量なしの商品
            Product::factory(3)
                ->withoutWeight()
                ->active()
                ->create(['owner_id' => $owner->id]);

            // サイズなしの商品
            Product::factory(3)
                ->withoutDimensions()
                ->active()
                ->create(['owner_id' => $owner->id]);
        }

        $this->command->info('商品データを作成しました。');
    }
}
