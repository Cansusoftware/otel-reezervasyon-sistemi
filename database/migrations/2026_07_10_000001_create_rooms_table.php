<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Odalar tablosunu oluşturur.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()->comment('Oda numarası (örn: 101)');
            $table->string('type')->comment('Oda tipi: tek, cift, suit');
            $table->string('status')->default('musait')->comment('musait, dolu, bakim');
            $table->decimal('price_per_night', 10, 2);
            $table->unsignedTinyInteger('capacity')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
