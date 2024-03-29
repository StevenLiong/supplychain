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
        Schema::create('resultrekomendasi', function (Blueprint $table) {
            $table->id();
            $table->datetime('end');
            $table->float('hours');
            $table->string('wo_id');
            $table->string('nama_mp');
            $table->string('nama_workcenter');
            $table->string('nama_proses');
            $table->string('mesin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultrekomendasi');
    }
};
