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
        Schema::create('incomings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kd_material');
            $table->unsignedBigInteger('kd_supplier');
            $table->string('no_po');
            $table->string('no_surat_jalan');
            $table->string('batch_datang');
            $table->integer('qty_kedatangan')->default(1);
            $table->timestamps();

            $table->foreign('kd_material')->references('id')->on('materials')->onDelete('cascade');
            $table->foreign('kd_supplier')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomings');
    }
};
