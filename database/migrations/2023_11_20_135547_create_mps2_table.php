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
        Schema::create('mps2s', function (Blueprint $table) {
            $table->id();
            $table->string('id_wo');
            $table->string('id_so');
            $table->string('line');
            $table->string('project');
            $table->string('qty_trafo');
            $table->date('deadline');
            $table->integer('kva');
            $table->string('kd_manhour');
            $table->foreignId('id_standardize_work')->nullable()->constrained('standardize_works');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mps2s');
    }
};