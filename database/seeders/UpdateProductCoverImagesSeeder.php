<?php

namespace Database\Seeders;

use App\Models\{Product, ProductImage};
use Illuminate\Database\Seeder;

class UpdateProductCoverImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('商品のカバー画像を更新しています...');

        // cover_image_idがNULLの商品を取得
        $productsWithoutCoverImage = Product::whereNull('cover_image_id')->get();

        $updatedCount = 0;

        foreach ($productsWithoutCoverImage as $product) {
            // その商品に関連するProductImageを取得
            $productImage = ProductImage::where('product_id', $product->id)->first();

            if ($productImage) {
                // ProductImageが存在する場合は、それをカバー画像として設定
                $product->update(['cover_image_id' => $productImage->id]);
                $updatedCount++;
            } else {
                // ProductImageが存在しない場合は、新しいProductImageを作成
                $newProductImage = ProductImage::create([
                    'product_id' => $product->id,
                    'file_name' => 'default_product_image.jpg',
                    'file_path' => 'dummy',
                    'file_size' => 100000,
                    'mime_type' => 'image/jpeg',
                    'alt_text' => $product->name . 'の商品画像',
                    'sort_order' => 0,
                    'thumbnail_path' => 'dummy',
                    'is_primary' => true,
                ]);

                $product->update(['cover_image_id' => $newProductImage->id]);
                $updatedCount++;
            }
        }

        $this->command->info("{$updatedCount}件の商品のカバー画像を更新しました。");

        // 最終確認
        $remainingNullCount = Product::whereNull('cover_image_id')->count();
        $this->command->info("cover_image_idがNULLの商品数: {$remainingNullCount}");
    }
}
