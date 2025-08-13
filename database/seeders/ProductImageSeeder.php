<?php

namespace Database\Seeders;

use App\Models\{ProductImage, Product};
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::where('is_active', true)->get();

        if ($products->isEmpty()) {
            $this->command->warn('アクティブな商品が見つかりません。ProductSeederを先に実行してください。');
            return;
        }

        foreach ($products as $product) {
            // プライマリ画像（最初の画像）
            ProductImage::factory()
                ->primary()
                ->create(['product_id' => $product->id]);

            // 追加画像（2-5枚）
            $additionalImages = rand(2, 5);
            for ($i = 1; $i <= $additionalImages; $i++) {
                ProductImage::factory()
                    ->sortOrder($i)
                    ->create(['product_id' => $product->id]);
            }

            // 商品のcover_image_idを更新
            $primaryImage = $product->images()->where('is_primary', true)->first();
            if ($primaryImage) {
                $product->update(['cover_image_id' => $primaryImage->id]);
            }
        }

        // 画像なしの商品も作成
        $productsWithoutImages = Product::where('is_active', true)
            ->whereDoesntHave('images')
            ->limit(10)
            ->get();

        foreach ($productsWithoutImages as $product) {
            // 画像なしの商品はそのまま（テスト用）
        }

        $this->command->info('商品画像データを作成しました。');
    }
}
