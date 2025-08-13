<?php

namespace Database\Factories;

use App\Models\{OrderItem, Order, Product};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productPrice = fake()->numberBetween(100, 10000);
        $quantity = fake()->numberBetween(1, 5);
        $totalPrice = $productPrice * $quantity;

        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'product_name' => fake()->words(3, true),
            'product_price' => $productPrice,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'product_sku' => fake()->regexify('[A-Z]{3}[0-9]{5}'),
            'product_image_url' => fake()->imageUrl(300, 300, 'product', true),
        ];
    }

    /**
     * 単品注文
     */
    public function single(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 1,
        ]);
    }

    /**
     * 複数注文
     */
    public function multiple(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => fake()->numberBetween(2, 10),
        ]);
    }

    /**
     * 大量注文
     */
    public function bulk(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => fake()->numberBetween(10, 50),
        ]);
    }

    /**
     * 高価格商品
     */
    public function expensive(): static
    {
        return $this->state(fn (array $attributes) => [
            'product_price' => fake()->numberBetween(5000, 50000),
        ]);
    }

    /**
     * 低価格商品
     */
    public function cheap(): static
    {
        return $this->state(fn (array $attributes) => [
            'product_price' => fake()->numberBetween(100, 1000),
        ]);
    }

    /**
     * 高額注文商品
     */
    public function highValue(): static
    {
        return $this->state(fn (array $attributes) => [
            'product_price' => fake()->numberBetween(10000, 100000),
            'quantity' => fake()->numberBetween(1, 3),
        ]);
    }

    /**
     * 低額注文商品
     */
    public function lowValue(): static
    {
        return $this->state(fn (array $attributes) => [
            'product_price' => fake()->numberBetween(100, 500),
            'quantity' => fake()->numberBetween(1, 2),
        ]);
    }

    /**
     * 商品なし（削除済み商品）
     */
    public function withoutProduct(): static
    {
        return $this->state(fn (array $attributes) => [
            'product_id' => null,
        ]);
    }

    /**
     * SKUなし
     */
    public function withoutSku(): static
    {
        return $this->state(fn (array $attributes) => [
            'product_sku' => null,
        ]);
    }

    /**
     * 画像なし
     */
    public function withoutImage(): static
    {
        return $this->state(fn (array $attributes) => [
            'product_image_url' => null,
        ]);
    }

    /**
     * 特定の商品名
     */
    public function productName(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'product_name' => $name,
        ]);
    }

    /**
     * 電子機器
     */
    public function electronics(): static
    {
        return $this->productName(fake()->randomElement([
            'スマートフォン',
            'ノートパソコン',
            'タブレット',
            'ワイヤレスイヤホン',
            'スマートウォッチ',
        ]));
    }

    /**
     * 衣類
     */
    public function clothing(): static
    {
        return $this->productName(fake()->randomElement([
            'Tシャツ',
            'ジーンズ',
            'スニーカー',
            'ジャケット',
            'ワンピース',
        ]));
    }

    /**
     * 本
     */
    public function books(): static
    {
        return $this->productName(fake()->randomElement([
            '小説',
            'ビジネス書',
            '料理本',
            '旅行ガイド',
            '技術書',
        ]));
    }

    /**
     * ホーム用品
     */
    public function home(): static
    {
        return $this->productName(fake()->randomElement([
            'キッチン用品',
            '掃除用品',
            'インテリア',
            '寝具',
            '収納用品',
        ]));
    }

    /**
     * スポーツ用品
     */
    public function sports(): static
    {
        return $this->productName(fake()->randomElement([
            'ランニングシューズ',
            'ヨガマット',
            'ダンベル',
            'テニスラケット',
            '自転車',
        ]));
    }

    /**
     * 美容用品
     */
    public function beauty(): static
    {
        return $this->productName(fake()->randomElement([
            '化粧品',
            'スキンケア',
            '香水',
            'ヘアケア',
            'ネイル用品',
        ]));
    }

    /**
     * 食品
     */
    public function food(): static
    {
        return $this->productName(fake()->randomElement([
            'お菓子',
            '飲料',
            '調味料',
            '冷凍食品',
            '健康食品',
        ]));
    }

    /**
     * おもちゃ
     */
    public function toys(): static
    {
        return $this->productName(fake()->randomElement([
            'ブロック',
            'パズル',
            'ぬいぐるみ',
            'ゲーム',
            '模型',
        ]));
    }
}

