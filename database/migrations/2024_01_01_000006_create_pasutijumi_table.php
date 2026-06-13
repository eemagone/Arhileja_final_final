<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Pasutijumi', function (Blueprint $table) {
            $table->id('Pasutijumi_ID');
            $table->foreignId('Apavu_ID')->references('Apavi_ID')->on('Apavi')->onDelete('cascade');
            $table->foreignId('Meistara_ID')->nullable()->references('Meistari_ID')->on('Meistari')->onDelete('set null');
            $table->date('Pienemsanas_Datums');
            $table->date('Termins')->nullable();
            $table->string('RemontaVeids', 255)->nullable();
            $table->string('Statuss', 50);
            $table->decimal('Cena', 10, 2)->default(0.00);
            $table->date('Garantijas_Termins')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Pasutijumi');
    }
};
