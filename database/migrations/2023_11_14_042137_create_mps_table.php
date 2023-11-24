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
        Schema::create('mps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_wo')->constrained('wo2s');;;
            $table->string('project');
            $table->string('production_line');
            $table->string('kva');
            $table->string('jenis');
            $table->string('qty_trafo');
            $table->integer('lead_time');
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