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
        Schema::create('hitung_kapasitas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama_pl');
            $table->decimal('oee', 5, 2)->nullable();
            $table->integer('output')->nullable();
            $table->integer('shift_kerja')->nullable();
            $table->integer('jam_kerja')->nullable();
            $table->decimal('aktual_oee',5,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hitung_kapasitas');
    }
};
