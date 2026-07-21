<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * proveedores
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('business_name', 150);
            //rut de empresa
            $table->string('tax_id', 12)->unique();
            $table->string('email', 150)->unique();
            $table->char('phone', 9)->unique();
            //teléfono fijo
            $table->char('landline', 9)->nullable()->unique();
            $table->string('address', 255);
            $table->string('website',100)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('commune_id')
                    ->constrained()
                    ->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
