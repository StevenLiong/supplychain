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
        Schema::create('leadtime_withfinishingoltcs', function (Blueprint $table) {
            $table->id();
            $table->integer('kva');
            $table->integer('jeda_QCTransfer');
            $table->integer('jeda_QC');
            $table->integer('jeda_finishing');
            $table->integer('jeda_confa');
            $table->integer('jeda_supmatconfa');
            $table->integer('jeda_susuncore');
            $table->integer('jeda_mould');
            $table->integer('jeda_supfixcore');
            $table->integer('jeda_core');
            $table->integer('jeda_hv');
            $table->integer('jeda_lv');
            $table->integer('jeda_supmatmould');
            $table->integer('jeda_supmatinscoil');
            $table->integer('jeda_inspaper');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leadtime_withfinishingoltcs');
    }
};