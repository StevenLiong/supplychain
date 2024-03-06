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
            $table->integer('line');
            $table->string('project');
            $table->string('qty_trafo');
            $table->date('deadline');
            $table->integer('kva');
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