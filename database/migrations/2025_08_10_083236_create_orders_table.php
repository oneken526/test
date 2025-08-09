<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->enum('status', ['pending', 'confirmed', 'preparing', 'shipped', 'delivered', 'cancelled', 'completed'])->default('pending');
            $table->unsignedInteger('total_amount');
            $table->unsignedInteger('tax_amount')->default(0);
            $table->unsignedInteger('shipping_fee')->default(0);
            $table->enum('payment_method', ['credit_card', 'bank_transfer', 'cash_on_delivery', 'digital_wallet'])->nullable();
            $table->enum('payment_status', ['pending', 'processing', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('shipping_name');
            $table->string('shipping_postal_code');
            $table->text('shipping_address');
            $table->string('shipping_phone')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('ordered_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // インデックス
            $table->index(['user_id', 'status']);
            $table->index(['owner_id', 'status']);
            $table->index('order_number');
            $table->index('payment_status');
            $table->index('created_at');
            $table->index('ordered_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
