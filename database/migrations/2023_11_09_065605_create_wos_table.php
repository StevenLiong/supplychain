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
            // $table->unsignedBigInteger('id_boms');
            $table->string('id_boms');
            $table->string('id_wo')->references('id_wo')->on('mps');
            // $table->string('id_wo');
            $table->string('id_fg');
            //$table->unsignedBigInteger('id_standardize_work');
            $table->string('id_standardize_work');
            $table->integer('qty_trafo');
            $table->integer('kva');
            //$table->unsignedBigInteger('id_so');
            $table->string('id_so')->references('kode_so')->on('sos');
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->timestamps();

            // $table->foreign('id_standardize_work')->references('id')->on('standardize_works')->onDelete('cascade');
            // $table->foreign('id_so')->references('id')->on('sos')->onDelete('cascade');
            // $table->foreign('id_boms')->references('id')->on('boms')->onDelete('cascade');
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