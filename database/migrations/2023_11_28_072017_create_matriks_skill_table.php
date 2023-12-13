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
            $table->string('nama_mp');
            $table->string('production_line');
            $table->string('kategori_produk');
            $table->string('proses');
            $table->string('tipe_proses');
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
