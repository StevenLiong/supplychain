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
        Schema::create('wos', function (Blueprint $table) {
            $table->id();
            $table->string('id_boms')->references('id_bom')->on('boms');
            $table->string('id_wo')->references('id_wo')->on('mps');
            $table->string('kd_manhour')->references('kd_manhour')->on('dry_cast_resins');
            $table->integer('qty_trafo')->references('qty_trafo')->on('detailboms');
            $table->string('id_so')->references('id_so')->on('sos');
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wos');
    }
};