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
            $table->enum('status', ['1', '2', '3', '4', '5', '6', '7'])->default('1')->comment('1:注文確認中, 2:注文確定, 3:処理中, 4:発送済み, 5:配達完了, 6:キャンセル済み, 7:返金済み');
            $table->unsignedInteger('total_amount');
            $table->unsignedInteger('tax_amount')->default(0);
            $table->unsignedInteger('shipping_fee')->default(0);
            $table->enum('payment_method', ['1', '2', '3', '4'])->nullable()->comment('1:クレジットカード, 2:銀行振込, 3:代金引換, 4:デジタルウォレット');
            $table->enum('payment_status', ['1', '2', '3', '4', '5'])->default('1')->comment('1:未決済, 2:処理中, 3:決済完了, 4:決済失敗, 5:返金済み');
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
