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
        Schema::create('compatibility_mesins', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ms');
            // $table->foreignId('id_mp')->nullable()->constrained('man_power');
            $table->string('production_line')->constrained('production_line');
            $table->string('nama_workcenter')->constrained('nama_workcenter');
            $table->string('proses')->constrained('proses');
            $table->string('tipe_proses')->constrained('tipe_proses');
            $table->integer('skill');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatibility_mesins');
    }
};
