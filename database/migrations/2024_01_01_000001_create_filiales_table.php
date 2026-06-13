<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Filiales', function (Blueprint $table) {
            $table->id('Filiales_ID');
            $table->string('Nosaukums', 100);
            $table->string('Adrese', 255);
            $table->string('Pilseta', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Filiales');
    }
};
