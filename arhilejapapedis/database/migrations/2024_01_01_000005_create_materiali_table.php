<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Materiali', function (Blueprint $table) {
            $table->id('Materiali_ID');
            $table->string('Nosaukums', 100);
            $table->string('Mervieniba', 50);
            $table->decimal('Cena', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Materiali');
    }
};
