<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * tabla n a m de productos y proveedores, se regista las personas y empresas
     * que venden un producto a la veterinaria
     */
    public function up(): void
    {
        Schema::create('product_supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('supplier_id');
            $table->string('supplier_sku', 100)->nullable();
            $table->unsignedInteger('purchase_price');
            $table->unsignedSmallInteger('lead_time_days');
            $table->boolean('is_preferred')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_supplier');
    }
};
