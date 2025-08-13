<?php

namespace Database\Seeders;

use App\Models\{OrderItem, Order, Product};
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        $products = Product::where('is_active', true)->get();

        if ($orders->isEmpty() || $products->isEmpty()) {
            $this->command->warn('注文またはアクティブな商品が見つかりません。OrderSeederとProductSeederを先に実行してください。');
            return;
        }

        foreach ($orders as $order) {
            // 各注文に1-5個の商品を追加
            $itemCount = rand(1, 5);

            for ($i = 0; $i < $itemCount; $i++) {
                $product = $products->random();

                OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'product_sku' => $product->sku,
                    'product_image_url' => $product->coverImage ? $product->coverImage->file_path : null,
                ]);
            }

            // 注文の合計金額を再計算
            $totalAmount = $order->orderItems()->sum('total_price');
            $taxAmount = (int) ($totalAmount * 0.1); // 10%税

            $order->update([
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
            ]);
        }

        // カテゴリ別の注文商品も作成
        $categoryOrders = Order::inRandomOrder()->limit(20)->get();

        foreach ($categoryOrders as $order) {
            // 電子機器
            OrderItem::factory()
                ->electronics()
                ->create(['order_id' => $order->id]);

            // 衣類
            OrderItem::factory()
                ->clothing()
                ->create(['order_id' => $order->id]);

            // 本
            OrderItem::factory()
                ->books()
                ->create(['order_id' => $order->id]);

            // ホーム用品
            OrderItem::factory()
                ->home()
                ->create(['order_id' => $order->id]);

            // スポーツ用品
            OrderItem::factory()
                ->sports()
                ->create(['order_id' => $order->id]);

            // 美容用品
            OrderItem::factory()
                ->beauty()
                ->create(['order_id' => $order->id]);

            // 食品
            OrderItem::factory()
                ->food()
                ->create(['order_id' => $order->id]);

            // おもちゃ
            OrderItem::factory()
                ->toys()
                ->create(['order_id' => $order->id]);
        }

        // 価格帯別の注文商品
        $priceOrders = Order::inRandomOrder()->limit(15)->get();

        foreach ($priceOrders as $order) {
            // 高価格商品
            OrderItem::factory()
                ->expensive()
                ->create(['order_id' => $order->id]);

            // 低価格商品
            OrderItem::factory()
                ->cheap()
                ->create(['order_id' => $order->id]);

            // 高額注文商品
            OrderItem::factory()
                ->highValue()
                ->create(['order_id' => $order->id]);

            // 低額注文商品
            OrderItem::factory()
                ->lowValue()
                ->create(['order_id' => $order->id]);
        }

        // 数量別の注文商品
        $quantityOrders = Order::inRandomOrder()->limit(10)->get();

        foreach ($quantityOrders as $order) {
            // 単品注文
            OrderItem::factory()
                ->single()
                ->create(['order_id' => $order->id]);

            // 複数注文
            OrderItem::factory()
                ->multiple()
                ->create(['order_id' => $order->id]);

            // 大量注文
            OrderItem::factory()
                ->bulk()
                ->create(['order_id' => $order->id]);
        }

        // 削除済み商品の注文商品
        $deletedProductOrders = Order::inRandomOrder()->limit(5)->get();

        foreach ($deletedProductOrders as $order) {
            OrderItem::factory()
                ->withoutProduct()
                ->create(['order_id' => $order->id]);
        }

        // SKUなしの注文商品
        $noSkuOrders = Order::inRandomOrder()->limit(5)->get();

        foreach ($noSkuOrders as $order) {
            OrderItem::factory()
                ->withoutSku()
                ->create(['order_id' => $order->id]);
        }

        // 画像なしの注文商品
        $noImageOrders = Order::inRandomOrder()->limit(5)->get();

        foreach ($noImageOrders as $order) {
            OrderItem::factory()
                ->withoutImage()
                ->create(['order_id' => $order->id]);
        }

        $this->command->info('注文商品データを作成しました。');
    }
}
