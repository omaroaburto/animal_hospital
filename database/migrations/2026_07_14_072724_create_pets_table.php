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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->foreignId('client_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('breed_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('gender',9);
            $table->boolean('microchip')->default(false);
            $table->string('microchip_number', 15)->nullable()->unique();
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            $table->string('color')->nullable();
            $table->boolean('sterilized')->default(false);
            $table->string('photo_url')->nullable();
            $table->string('photo_id')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('pets');
    }
};
