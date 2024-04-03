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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_product')->default('Repair')->index();
            $table->string('kd_manhour', 14)->unique();
            $table->string('nomor_so');
            $table->string('id_fg');
            $table->float('total_hour');
            $table->string('kategori')->default('7');
            $table->string('ukuran_kapasitas');
            // $table->foreignId('manhour_id')->nullable()->constrained('man_hours')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('on_cover_standard')->nullable();
            $table->string('sidewall')->nullable();
            $table->string('conservator_cabelbox')->nullable();
            $table->string('radiator')->nullable();
            $table->string('accessories_proteksi')->nullable();
            $table->string('angkat_coil')->nullable();
            $table->string('coil_lv')->nullable();
            $table->string('coil_lv_plus')->nullable();
            $table->string('coil_hv')->nullable();
            $table->string('coil_hv_plus')->nullable();
            $table->string('core_coil_assembly')->nullable();
            $table->string('connection_final_assembly')->nullable();
            $table->string('hv_connection')->nullable();
            $table->string('lv_connection')->nullable();
            $table->string('accessories')->nullable();
            $table->string('special_assembly')->nullable();
            $table->string('finishing')->nullable();
            $table->string('cable_box')->nullable();
            $table->string('wiring_control_box')->nullable();
            $table->string('copper_link')->nullable();
            $table->string('radiator_panel')->nullable();
            $table->string('conservator_finish')->nullable();
            $table->string('qc_testing')->nullable();
            $table->integer('totalHour_untangking')->nullable();
            $table->integer('totalHour_bongkar')->nullable();
            $table->integer('totalHour_coil_making')->nullable();
            $table->integer('totalHour_CoreAssembly')->nullable();
            $table->integer('totalHour_ConectAssembly')->nullable();
            $table->integer('totalHour_FinalAssembly')->nullable();
            $table->integer('totalHour_SpecialFinalAssembly')->nullable();
            $table->integer('totalHour_Finishing')->nullable();
            $table->integer('totalHour_cabelbox')->nullable();
            $table->integer('totalHour_wiring_controlbox')->nullable();
            $table->integer('totalHour_copper_link')->nullable();
            $table->integer('totalHour_radiator_panel')->nullable();
            $table->integer('totalHour_conservator')->nullable();
            $table->integer('totalHour_QCTest')->nullable();
            $table->integer('hour_on_cover_standard')->nullable();
            $table->integer('hour_sidewall')->nullable();
            $table->integer('hour_conservator_cabelbox')->nullable();
            $table->integer('hour_radiator')->nullable();
            $table->integer('hour_accessories_proteksi')->nullable();
            $table->integer('hour_angkat_coil')->nullable();
            $table->integer('hour_coil_lv')->nullable();
            $table->integer('hour_coil_lv_plus')->nullable();
            $table->integer('hour_coil_hv')->nullable();
            $table->integer('hour_coil_hv_plus')->nullable();
            $table->integer('hour_core_coil_assembly')->nullable();
            $table->integer('hour_connection_final_assembly')->nullable();
            $table->integer('hour_hv_connection')->nullable();
            $table->integer('hour_lv_connection')->nullable();
            $table->integer('hour_accessories')->nullable();
            $table->integer('hour_special_assembly')->nullable();
            $table->integer('hour_finishing')->nullable();
            $table->integer('hour_cable_box')->nullable();
            $table->integer('hour_wiring_control_box')->nullable();
            $table->integer('hour_copper_link')->nullable();
            $table->integer('hour_radiator_panel')->nullable();
            $table->integer('hour_conservator_finish')->nullable();
            $table->integer('hour_qc_testing')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
