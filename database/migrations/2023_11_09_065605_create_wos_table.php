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
            $table->string('id_wo');
            $table->string('id_manhour');
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