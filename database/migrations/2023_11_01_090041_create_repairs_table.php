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
            $table->string('kategori')->default('6');
            $table->string('ukuran_kapasitas');
            $table->string('untanking')->nullable();
            $table->string('bongkar_conservator')->nullable();
            $table->string('bongkar_cable_box')->nullable();
            $table->string('bongkar_radiator_panel')->nullable();
            $table->string('bongkar_accesories')->nullable();
            $table->string('bongkar_core')->nullable();
            $table->string('coil_lv')->nullable();
            $table->string('coil_hv')->nullable();
            $table->string('cca')->nullable();
            $table->string('connect')->nullable();
            $table->string('hv_connect')->nullable();
            $table->string('lv_connect')->nullable();
            $table->string('final_assembly')->nullable();
            $table->string('accessories')->nullable();
            $table->string('wiring')->nullable();
            $table->string('copper_link')->nullable();
            $table->string('cable_box')->nullable();
            $table->string('radiator_panel')->nullable();
            $table->string('conservator')->nullable();
            $table->string('qc')->nullable();
            $table->float('totalHour_bongkar')->nullable();
            $table->float('totalHour_coil_making')->nullable();
            $table->float('totalHour_CCA')->nullable();
            $table->float('totalHour_Conect')->nullable();
            $table->float('totalHour_FinalAssembly')->nullable();
            $table->float('totalHour_Finishing')->nullable();
            $table->float('totalHour_QCTest')->nullable();
            $table->float('hour_untanking')->nullable();
            $table->float('hour_bongkar_conservator')->nullable();
            $table->float('hour_bongkar_cable_box')->nullable();
            $table->float('hour_bongkar_radiator_panel')->nullable();
            $table->float('hour_bongkar_accesories')->nullable();
            $table->float('hour_bongkar_core')->nullable();
            $table->float('hour_coil_lv')->nullable();
            $table->float('hour_coil_hv')->nullable();
            $table->float('hour_cca')->nullable();
            $table->float('hour_connect')->nullable();
            $table->float('hour_hv_connect')->nullable();
            $table->float('hour_lv_connect')->nullable();
            $table->float('hour_final_assembly')->nullable();
            $table->float('hour_accessories')->nullable();
            $table->float('hour_wiring')->nullable();
            $table->float('hour_copper_link')->nullable();
            $table->float('hour_cable_box')->nullable();
            $table->float('hour_radiator_panel')->nullable();
            $table->float('hour_conservator')->nullable();
            $table->float('hour_qc')->nullable();

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
