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
        Schema::create('oil_standards', function (Blueprint $table) {
            $table->id();
            $table->string('kd_manhour', 14)->unique();
            $table->string('nama_product')->default('Oil Standard')->index();
            $table->string('kategori')->default('5');
            $table->string('ukuran_kapasitas');
            $table->string('nomor_so');
            $table->integer('total_hour');
            $table->foreignId('manhour_id')->nullable()->constrained('man_hours')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('coil_lv')->nullable();
            $table->string('coil_hv')->nullable();
            $table->string('leadwire')->nullable();
            $table->string('press_coil')->nullable();
            $table->string('core_coil_assembly')->nullable();
            $table->string('connect')->nullable();
            $table->string('final_assembly')->nullable();
            $table->string('qc_testing')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oil_standards');
    }
};
