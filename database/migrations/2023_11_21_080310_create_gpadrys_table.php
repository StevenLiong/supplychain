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
        Schema::create('gpadrys', function (Blueprint $table) {
            $table->id();
            $table->string('id_wo');
            $table->string('project');
            $table->string('production_line');
            $table->string('kva');
            // $table->string('jenis');
            $table->string('qty_trafo');
            $table->date('start')->nullable();
            $table->date('deadline')->nullable();
            $table->string('nama_workcenter')->nullable();
            $table->string('keterangan')->nullable();
            $table->foreignId('id_mps')->nullable()->constrained('mps2s');
            $table->date('deadline_wc1')->nullable();
            $table->date('deadline_wc2')->nullable();
            $table->date('deadline_wc3')->nullable();
            $table->date('deadline_wc4')->nullable();
            $table->date('deadline_wc5')->nullable();
            $table->date('deadline_wc6')->nullable();
            $table->date('deadline_wc7')->nullable();
            $table->date('deadline_wc8')->nullable();
            $table->date('deadline_wc9')->nullable();
            $table->date('deadline_wc10')->nullable();
            $table->date('deadline_wc11')->nullable();
            $table->date('deadline_wc12')->nullable();
            $table->date('deadline_wc13')->nullable();
            $table->date('deadline_wc14')->nullable();
            $table->date('deadline_wc15')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpadrys');
    }
};