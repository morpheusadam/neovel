<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        

        // جدول مشتریان
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // جدول دسته‌بندی محصولات
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->text('description')->nullable();
            $table->foreignId('parent_category_id')->nullable()->constrained('product_categories');
            $table->timestamps();
        });

        // جدول محصولات
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->foreignId('category_id')->constrained('product_categories');
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('expiration_date')->nullable();
            $table->timestamps();
        });

        // جدول تخفیف‌ها
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('discount_percentage', 5, 2);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('discount_code')->unique();
            $table->timestamps();
        });

        // جدول روش‌های پرداخت
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('method_name')->unique();
            $table->timestamps();
        });

        // جدول سفارشات
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->dateTime('order_date')->default(now());
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'])->default('Pending');
            $table->enum('payment_status', ['Pending', 'Completed', 'Failed'])->default('Pending');
            $table->string('shipping_address')->nullable();
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->timestamps();
        });

        // جدول اقلام سفارش
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        // جدول نظرات
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('customer_id')->constrained('customers');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        // جدول تاریخچه وضعیت سفارش
        Schema::create('order_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->enum('old_status', ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled']);
            $table->enum('new_status', ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled']);
            $table->dateTime('change_date')->default(now());
            $table->timestamps();
        });

        // جدول تاریخچه قیمت محصولات
        Schema::create('product_price_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->decimal('old_price', 10, 2);
            $table->decimal('new_price', 10, 2);
            $table->dateTime('change_date')->default(now());
            $table->timestamps();
        });

        // جدول وضعیت‌های سفارش
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status_name')->unique();
            $table->timestamps();
        });

        // جدول انبارها
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('location')->nullable();
            $table->integer('capacity')->default(0);
            $table->string('manager_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        // جدول موجودی
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->integer('quantity')->default(0);
            $table->integer('restock_threshold')->default(10);
            $table->timestamp('last_restocked')->nullable();
            $table->integer('reorder_point')->default(5);
            $table->timestamps();
        });

        // جدول تراکنش‌های موجودی
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventory');
            $table->enum('transaction_type', ['addition', 'removal']);
            $table->integer('quantity');
            $table->timestamp('transaction_date')->default(now());
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // جدول تأمین‌کنندگان
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });

        // جدول سفارشات موجودی
        Schema::create('inventory_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('quantity');
            $table->timestamp('order_date')->default(now());
            $table->timestamp('expected_delivery_date')->nullable();
            $table->enum('status', ['pending', 'received', 'cancelled', 'partially_received'])->default('pending');
            $table->timestamps();
        });

        // جدول بازرسی‌های موجودی
        Schema::create('inventory_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventory');
            $table->timestamp('audit_date')->default(now());
            $table->integer('quantity_before');
            $table->integer('quantity_after');
            $table->text('discrepancies')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_audits');
        Schema::dropIfExists('inventory_orders');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('inventory_transactions');
        Schema::dropIfExists('inventory');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('order_statuses');
        Schema::dropIfExists('product_price_history');
        Schema::dropIfExists('order_status_history');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('users');
    }
};
