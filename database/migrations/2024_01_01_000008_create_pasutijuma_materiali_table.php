<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('PasutijumaMateriali', function (Blueprint $table) {
            $table->id('PasutijumaMateriali_ID');
            $table->foreignId('Pasutijuma_ID')->references('Pasutijumi_ID')->on('Pasutijumi')->onDelete('cascade');
            $table->foreignId('Materiali_ID')->references('Materiali_ID')->on('Materiali')->onDelete('cascade');
            $table->integer('Daudzums')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('PasutijumaMateriali');
    }
};
