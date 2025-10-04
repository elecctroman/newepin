<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->enum('type', ['epin', 'account', 'license']);
            $table->decimal('price', 12, 2);
            $table->string('supplier')->default('manual');
            $table->string('api_product_id')->nullable();
            $table->unsignedInteger('stock_count')->default(0);
            $table->boolean('auto_deliver')->default(false);
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
