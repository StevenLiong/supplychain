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
            $table->string('ukuran_kapasitas');
            $table->string('nomor_so');
            $table->string('id_fg');
            $table->integer('total_hour');
            $table->string('kategori')->default('2');
            $table->foreignId('manhour_id')->nullable()->constrained('man_hours')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('coil_lv')->nullable();
            $table->string('coil_hv')->nullable();
            $table->string('leadwire')->nullable();
            $table->string('press_coil')->nullable();
            $table->string('core_coil_assembly')->nullable();
            $table->string('connect')->nullable();
            $table->string('final_assembly')->nullable();
            $table->string('qc_testing')->nullable();
            $table->string('totalHour_coil_making')->nullable();
            $table->string('totalHour_CoreCoilAssembly')->nullable();
            $table->string('totalHour_Conect')->nullable();
            $table->string('totalHour_FinalAssembly')->nullable();
            $table->string('totalHour_QCTest')->nullable();
            $table->string('hour_coil_lv')->nullable();
            $table->string('hour_coil_hv')->nullable();
            $table->string('hour_leadwire')->nullable();
            $table->string('hour_press_coil')->nullable();
            $table->string('hour_core_coil_assembly')->nullable();
            $table->string('hour_connect')->nullable();
            $table->string('hour_final_assembly')->nullable();
            $table->string('hour_qc_testing')->nullable();
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
