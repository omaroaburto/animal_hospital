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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('document_type');
            $table->string('document_number', 30);
            $table->text('notes')->nullable();
            $table->string('secondary_phone', 20)->nullable();
            $table->string('street', 150);
            $table->string('number', 20);
            $table->string('apartment', 20)->nullable();
            $table->foreignId('commune_id')
                ->constrained()
                ->onDelete('restrict');
            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
