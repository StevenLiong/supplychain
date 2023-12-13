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
        Schema::create('matriks_skill', function (Blueprint $table) {
            $table->id();
            $table->string('id_mp')->constrained('man_power');
            $table->string('id_production_line')->constrained('production_line');
            $table->string('id_kategori_produk')->constrained('kategori_produk');
            $table->string('id_proses')->constrained('proses');
            $table->string('id_tipe_proses')->constrained('tipe_proses');
            $table->integer('skill');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriks_skill');
    }
};
