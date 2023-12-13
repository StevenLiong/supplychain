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
        Schema::create('finishedgoods', function (Blueprint $table) {
            $table->id();
            $table->string('no_transfer')->reference('no_bon')->on('transfers');
            $table->string('id_wo');
            $table->string('kd_finishedgood');
            $table->integer('kva'); 
            $table->integer('qty');
            $table->string('nsk');
            $table->string('nsp');
            $table->string('gudang')->reference('nama_gudang')->on('gudangs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fgoods');
    }
};