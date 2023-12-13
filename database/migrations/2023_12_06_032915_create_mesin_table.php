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
        Schema::create('mesin', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset');
            $table->string('nama_mesin');
            $table->string('merk_mesin');
            $table->foreignId('id_production_line')->nullable()->constrained('production_line')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_work_centers')->nullable()->constrained('work_centers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('kva_min');
            $table->string('kva_max');
            $table->string('output');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesin');
    }
};
