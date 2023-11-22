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
        Schema::create('mrs', function (Blueprint $table) {
            $table->id();
            $table->string('id_mr');
            $table->integer('qty_mr')->nullable();
            $table->string('keterangan')->nullable();
            $table->date('tanggal_mr')->nullable();
            $table->string('id_ppic')->nullable();
            $table->string('id_division')->nullable();
            $table->string('status_mr')->nullable();
        });
    }

    /**
     * Reverse the migrati ons.
     */
    public function down(): void
    {
        Schema::dropIfExists('mrs');
    }
};
