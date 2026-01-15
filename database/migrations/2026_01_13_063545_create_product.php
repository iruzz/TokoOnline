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
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Foreign Keys
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
            
            $table->foreignId('featured_group_id')
                  ->nullable()
                  ->constrained('featured_groups')
                  ->onDelete('set null');
            
            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            
            // Inventory
            $table->integer('stock')->default(0);
            $table->string('sku', 50)->unique();
            
            // Product Details
            $table->string('size', 50)->nullable(); // S, M, L, XL, XXL atau JSON
            $table->string('color', 50)->nullable();
            
            // Features
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_new')->default(false);
            $table->enum('badge', ['new', 'hot', 'sale', 'limited'])->nullable();
            
            // Status
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');
            
            $table->timestamps();
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