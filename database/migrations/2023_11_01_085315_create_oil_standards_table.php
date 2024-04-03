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
            $table->float('total_hour');
            $table->string('kategori')->default('2');
            // $table->foreignId('manhour_id')->nullable()->constrained('man_hours')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('coil_lv')->nullable();
            $table->string('coil_hv')->nullable();
            // $table->string('coil_lv_leadwire')->nullable();
            // $table->string('coil_hv_press_coil')->nullable();
            $table->string('core_coil_assembly')->nullable();
            $table->string('connect')->nullable();
            $table->string('final_assembly')->nullable();
            $table->string('qc_testing')->nullable();
            $table->float('totalHour_coil_making')->nullable();
            $table->float('totalHour_CoreCoilAssembly')->nullable();
            $table->float('totalHour_Conect')->nullable();
            $table->float('totalHour_FinalAssembly')->nullable();
            $table->float('totalHour_QCTest')->nullable();
            $table->float('hour_coil_lv')->nullable();
            $table->float('hour_coil_hv')->nullable();
            // $table->float('hour_coil_lv_leadwire')->nullable();
            // $table->float('hour_coil_hv_press_coil')->nullable();
            $table->float('hour_core_coil_assembly')->nullable();
            $table->float('hour_connect')->nullable();
            $table->float('hour_final_assembly')->nullable();
            $table->float('hour_qc_testing')->nullable();
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
