<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Productos
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('sku', 50)->unique();
            $table->string('barcode', 100)->unique()->nullable();
            $table->string('name', 150);
            $table->text('description')->nullable();
            //precio de compra
            $table->unsignedInteger('purchase_price');
            //precio de venta
            $table->unsignedInteger('sale_price');
            $table->unsignedInteger('minimum_stock');
            $table->unsignedInteger('maximum_stock');
            //kilos, litros, etc
            $table->string('unit',30);
            $table->boolean('requires_batch')->default(false);
            $table->boolean('requires_expiration')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
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
