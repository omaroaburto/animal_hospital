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
        Schema::create('product_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('purchase_detail_id');
            $table->string('batch_number', 100);
            $table->date('expiration_date')->nullable();
            $table->unsignedInteger('quantity_received');
            $table->unsignedInteger('quantity_available');
            $table->unsignedInteger('unit_cost');
            $table->date('received_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_batches');
    }
};
