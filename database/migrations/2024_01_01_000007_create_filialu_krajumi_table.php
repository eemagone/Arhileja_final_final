<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('FilialuKrajumi', function (Blueprint $table) {
            $table->id('Krajuma_ID');
            $table->foreignId('Filiales_ID')->references('Filiales_ID')->on('Filiales')->onDelete('cascade');
            $table->foreignId('Materiali_ID')->references('Materiali_ID')->on('Materiali')->onDelete('cascade');
            $table->integer('Apjoms')->default(0);

            $table->unique(['Filiales_ID', 'Materiali_ID'], 'uq_filiale_material');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('FilialuKrajumi');
    }
};
