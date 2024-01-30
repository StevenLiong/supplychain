<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
        // Schema::create('mps', function (Blueprint $table) {
        //     $table->id();
        //     // $table->foreignId('id_wo')->constrained('wo2s');;;
        //     $table->string('id_wo')->references('id_wo')->on('wos');
        //     $table->string('project');
        //     $table->string('kd_manhour');
        //     $table->string('production_line');
        //     $table->string('kva');
        //     $table->string('jenis');
        //     $table->string('qty_trafo');
        //     $table->integer('lead_time');
        //     $table->string('nama_workcenter')->nullable();
        //     $table->date('deadline')->nullable();
        //     $table->timestamps();
        // });
    // }

    public function up(): void
    {
        Schema::create('mps', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('id_wo')->constrained( 'wos');
            $table->foreignId('id_wo')->nullable()->constrained('wos');
            $table->string('kd_manhour');
            $table->string('project');
            $table->string('production_line');
            $table->string('kva');
            $table->string('jenis');
            $table->string('qty_trafo');
            $table->integer('lead_time');
            $table->string('nama_workcenter')->nullable();
            $table->date('deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mps');
    }
};