<?php

namespace Database\Factories;

use App\Models\{Order, User, Owner};
use App\Enums\{OrderStatus, PaymentMethod, PaymentStatus};
use App\Constants\OrderConsts;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalAmount = fake()->numberBetween(1000, 50000);
        $taxAmount = (int) ($totalAmount * 0.1); // 10%税
        $shippingFee = $totalAmount >= OrderConsts::FREE_SHIPPING_THRESHOLD ? 0 : OrderConsts::DEFAULT_SHIPPING_FEE;

        return [
            'user_id' => User::factory(),
            'owner_id' => Owner::factory(),
            'order_number' => 'ORD' . fake()->unique()->numberBetween(100000000, 999999999),
            'status' => OrderStatus::PENDING->value,
            'total_amount' => $totalAmount,
            'tax_amount' => $taxAmount,
            'shipping_fee' => $shippingFee,
            'payment_method' => fake()->randomElement(PaymentMethod::cases())->value,
            'payment_status' => PaymentStatus::PENDING->value,
            'shipping_name' => fake()->name(),
            'shipping_postal_code' => fake()->regexify('\d{3}-\d{4}'),
            'shipping_address' => fake()->address(),
            'shipping_phone' => fake()->phoneNumber(),
            'notes' => fake()->optional()->sentence(),
            'ordered_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'shipped_at' => null,
            'delivered_at' => null,
            'cancelled_at' => null,
        ];
    }

    /**
     * 確定済み注文
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::CONFIRMED->value,
            'payment_status' => PaymentStatus::COMPLETED->value,
        ]);
    }

    /**
     * 準備中注文
     */
    public function preparing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::PREPARING->value,
            'payment_status' => PaymentStatus::COMPLETED->value,
        ]);
    }

    /**
     * 発送済み注文
     */
    public function shipped(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::SHIPPED->value,
            'payment_status' => PaymentStatus::COMPLETED->value,
            'shipped_at' => fake()->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * 配送完了注文
     */
    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::DELIVERED->value,
            'payment_status' => PaymentStatus::COMPLETED->value,
            'shipped_at' => fake()->dateTimeBetween('-2 weeks', '-1 week'),
            'delivered_at' => fake()->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * 完了注文
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::COMPLETED->value,
            'payment_status' => PaymentStatus::COMPLETED->value,
            'shipped_at' => fake()->dateTimeBetween('-2 weeks', '-1 week'),
            'delivered_at' => fake()->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * キャンセル注文
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::CANCELLED->value,
            'payment_status' => PaymentStatus::REFUNDED->value,
            'cancelled_at' => fake()->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * 決済完了注文
     */
    public function paymentCompleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => PaymentStatus::COMPLETED->value,
        ]);
    }

    /**
     * 決済失敗注文
     */
    public function paymentFailed(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => PaymentStatus::FAILED->value,
        ]);
    }

    /**
     * 返金済み注文
     */
    public function refunded(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => PaymentStatus::REFUNDED->value,
        ]);
    }

    /**
     * クレジットカード決済
     */
    public function creditCard(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_method' => PaymentMethod::CREDIT_CARD->value,
        ]);
    }

    /**
     * 銀行振込
     */
    public function bankTransfer(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_method' => PaymentMethod::BANK_TRANSFER->value,
        ]);
    }

    /**
     * 代金引換
     */
    public function cod(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_method' => PaymentMethod::COD->value,
        ]);
    }

    /**
     * デジタルウォレット
     */
    public function digitalWallet(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_method' => PaymentMethod::DIGITAL_WALLET->value,
        ]);
    }

    /**
     * 高額注文
     */
    public function expensive(): static
    {
        return $this->state(fn (array $attributes) => [
            'total_amount' => fake()->numberBetween(10000, 100000),
        ]);
    }

    /**
     * 低額注文
     */
    public function cheap(): static
    {
        return $this->state(fn (array $attributes) => [
            'total_amount' => fake()->numberBetween(1000, 5000),
        ]);
    }

    /**
     * 送料無料注文
     */
    public function freeShipping(): static
    {
        return $this->state(fn (array $attributes) => [
            'total_amount' => fake()->numberBetween(OrderConsts::FREE_SHIPPING_THRESHOLD, 100000),
            'shipping_fee' => 0,
        ]);
    }

    /**
     * 送料あり注文
     */
    public function withShipping(): static
    {
        return $this->state(fn (array $attributes) => [
            'total_amount' => fake()->numberBetween(1000, OrderConsts::FREE_SHIPPING_THRESHOLD - 1),
            'shipping_fee' => OrderConsts::DEFAULT_SHIPPING_FEE,
        ]);
    }

    /**
     * メモなし注文
     */
    public function withoutNotes(): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => null,
        ]);
    }

    /**
     * 電話番号なし注文
     */
    public function withoutPhone(): static
    {
        return $this->state(fn (array $attributes) => [
            'shipping_phone' => null,
        ]);
    }

    /**
     * 過去の注文
     */
    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'ordered_at' => fake()->dateTimeBetween('-6 months', '-1 month'),
        ]);
    }

    /**
     * 最近の注文
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'ordered_at' => fake()->dateTimeBetween('-1 week', 'now'),
        ]);
    }
}
