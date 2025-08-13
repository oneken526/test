<?php

namespace Database\Factories;

use App\Models\{ProductImage, Product};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileName = fake()->imageUrl(640, 480, 'product', true);
        $filePath = 'dummy';

        return [
            'product_id' => Product::factory(),
            'file_name' => basename($fileName),
            'file_path' => $filePath,
            'file_size' => fake()->numberBetween(100000, 2000000), // 100KB - 2MB
            'mime_type' => fake()->randomElement(['image/jpeg', 'image/png', 'image/webp']),
            'alt_text' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(0, 10),
            'thumbnail_path' => 'dummy',
            'is_primary' => false,
        ];
    }

    /**
     * プライマリ画像
     */
    public function primary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => true,
            'sort_order' => 0,
        ]);
    }

    /**
     * サムネイル画像
     */
    public function thumbnail(): static
    {
        return $this->state(fn (array $attributes) => [
            'thumbnail_path' => 'thumbnails/' . $attributes['file_path'],
        ]);
    }

    /**
     * 大きなファイルサイズ
     */
    public function large(): static
    {
        return $this->state(fn (array $attributes) => [
            'file_size' => fake()->numberBetween(2000000, 5000000), // 2MB - 5MB
        ]);
    }

    /**
     * 小さなファイルサイズ
     */
    public function small(): static
    {
        return $this->state(fn (array $attributes) => [
            'file_size' => fake()->numberBetween(50000, 200000), // 50KB - 200KB
        ]);
    }

    /**
     * JPEG形式
     */
    public function jpeg(): static
    {
        return $this->state(fn (array $attributes) => [
            'mime_type' => 'image/jpeg',
            'file_name' => fake()->regexify('[a-z]{10}\.jpg'),
        ]);
    }

    /**
     * PNG形式
     */
    public function png(): static
    {
        return $this->state(fn (array $attributes) => [
            'mime_type' => 'image/png',
            'file_name' => fake()->regexify('[a-z]{10}\.png'),
        ]);
    }

    /**
     * WebP形式
     */
    public function webp(): static
    {
        return $this->state(fn (array $attributes) => [
            'mime_type' => 'image/webp',
            'file_name' => fake()->regexify('[a-z]{10}\.webp'),
        ]);
    }

    /**
     * 特定のソート順
     */
    public function sortOrder(int $order): static
    {
        return $this->state(fn (array $attributes) => [
            'sort_order' => $order,
        ]);
    }

    /**
     * 最初の画像
     */
    public function first(): static
    {
        return $this->sortOrder(0);
    }

    /**
     * 最後の画像
     */
    public function last(): static
    {
        return $this->sortOrder(10);
    }

    /**
     * 代替テキストなし
     */
    public function withoutAltText(): static
    {
        return $this->state(fn (array $attributes) => [
            'alt_text' => null,
        ]);
    }

    /**
     * サムネイルなし
     */
    public function withoutThumbnail(): static
    {
        return $this->state(fn (array $attributes) => [
            'thumbnail_path' => null,
        ]);
    }
}

