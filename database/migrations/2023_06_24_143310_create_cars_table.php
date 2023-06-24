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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('plate')->nullable();
            $table->string('model')->nullable();
            $table->integer('year')->nullable();
            $table->integer('km')->nullable();
            $table->string('color')->nullable();
            $table->decimal('table_price', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('place')->nullable();
            $table->string('origin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
