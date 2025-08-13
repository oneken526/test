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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('price');
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->tinyInteger('category')->nullable()->comment('1:おもちゃ, 2:スポーツ, 3:家具, 4:書籍, 5:美容, 6:衣類, 7:電子機器, 8:食品');
            $table->enum('status', ['1', '2', '3', '4'])->default('1')->comment('1:下書き, 2:販売中, 3:販売停止, 4:在庫切れ');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('cover_image_id')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('dimensions')->nullable();
            $table->string('sku')->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();

            // インデックス
            $table->index(['owner_id', 'is_active']);
            $table->index('category');
            $table->index('price');
            $table->index('is_featured');
            $table->index('created_at');
            $table->fullText(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
