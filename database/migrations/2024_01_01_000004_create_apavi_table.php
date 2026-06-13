<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Apavi', function (Blueprint $table) {
            $table->id('Apavi_ID');
            $table->foreignId('Klienta_ID')->references('Klienti_ID')->on('Klienti')->onDelete('cascade');
            $table->string('Zimols', 100)->nullable();
            $table->string('Tips', 100);
            $table->string('ApavuMaterials', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Apavi');
    }
};
