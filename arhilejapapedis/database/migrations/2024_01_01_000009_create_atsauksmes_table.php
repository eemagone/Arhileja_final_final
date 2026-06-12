<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Atsauksmes', function (Blueprint $table) {
            $table->id('Atsauksmes_ID');
            $table->foreignId('Pasutijuma_ID')->unique()->references('Pasutijumi_ID')->on('Pasutijumi')->onDelete('cascade');
            $table->unsignedTinyInteger('Vertejums');
            $table->text('Komentars')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Atsauksmes');
    }
};
