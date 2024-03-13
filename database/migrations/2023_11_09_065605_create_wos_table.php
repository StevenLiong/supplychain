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
        // Schema::create('wos', function (Blueprint $table) {
        //     $table->id();
        //     // $table->unsignedBigInteger('id_boms');
        //     $table->string('id_boms');
        //     $table->string('id_wo')->references('id_wo')->on('mps');
        //     // $table->string('id_wo');
        //     $table->string('id_fg');
        //     //$table->unsignedBigInteger('id_standardize_work');
        //     $table->string('id_standardize_work');
        //     $table->integer('qty_trafo');
        //     $table->integer('kva');
        //     //$table->unsignedBigInteger('id_so');
        //     $table->string('id_so')->references('kode_so')->on('sos');
        //     $table->date('start_date')->nullable();
        //     $table->date('finish_date')->nullable();
        //     $table->timestamps();
        // });

        Schema::create('wos', function (Blueprint $table) {
            $table->id();
            $table->string('id_boms')->references('id_bom')->on('boms')->nullable();
            $table->string('id_wo')->nullable();
            $table->string('id_fg')->nullable();
            $table->string('keterangan')->nullable();
            // $table->unsignedBigInteger('id_standardize_work');
            $table->foreignId('id_standardize_work')->nullable()->constrained('standardize_works');
            $table->integer('qty_trafo')->nullable();
            $table->integer('kva')->nullable();
            $table->string('id_so')->references('kode_so')->on('sos')->nullable();
            $table->string('start_date')->nullable();
            $table->string('finish_date')->nullable();
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
