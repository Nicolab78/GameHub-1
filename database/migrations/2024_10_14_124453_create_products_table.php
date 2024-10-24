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
            $table->string('product_name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->foreignId('cat_id')->nullable()->constrained('categories', 'id')->onDelete('set null');             $table->dateTime('release_date')->nullable();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Creates an `id` field of type `unsignedBigInteger`
            $table->string('name'); // Add other fields as necessary
            $table->timestamps();
        });

        Schema::create('platforms', function (Blueprint $table) {
            $table->id(); // platform_id INT AUTO_INCREMENT PRIMARY KEY
            $table->string('platform_code', 10)->unique(); // VARCHAR(10) NOT NULL UNIQUE
            $table->text('description')->nullable(); // Description (optional)
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // order_id INT AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('user_id')->constrained('users'); // Foreign key for users
            $table->decimal('total_price', 10, 2); // Total price of the order
            $table->dateTime('order_date')->default(DB::raw('CURRENT_TIMESTAMP')); // Order date
            $table->enum('status', ['Pending', 'Processing', 'Shipped', 'Delivered', 'Canceled'])->default('Pending'); // Order status
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->id(); // order_detail_id INT AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('order_id')->constrained('orders'); // Foreign key for orders
            $table->foreignId('product_id')->constrained('products'); // Foreign key for products
            $table->integer('quantity'); // Quantity ordered
            $table->decimal('price_each', 10, 2); // Price for each product in the order
            $table->timestamps(); // Adds created_at and updated_at columns
        });

        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id(); // review_id INT AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('product_id')->constrained('products'); // Foreign key for products
            $table->foreignId('user_id')->constrained('users'); // Foreign key for users
            $table->integer('rating'); // Product rating
            $table->text('review_text')->nullable(); // Review text (optional)
            $table->timestamps(); // Automatically adds created_at and updated_at columns
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
