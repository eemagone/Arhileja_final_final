<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Klienti', function (Blueprint $table) {
            $table->id('Klienti_ID');
            $table->foreignId('user_id')->unique()->references('id')->on('users')->onDelete('cascade');
            $table->string('Vards', 100);
            $table->string('Uzvards', 100);
            $table->string('TelNr', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Klienti');
    }
};
