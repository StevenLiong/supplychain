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
        Schema::create('oil_customs', function (Blueprint $table) {
            $table->id();
            $table->string('kd_manhour', 14)->unique();
            $table->string('nama_product')->default('Oli Custom')->index();
            $table->string('kategori')->default('1');
            $table->string('ukuran_kapasitas');
            $table->string('nomor_so');
            $table->string('id_fg');
            $table->float('total_hour');
            // $table->foreignId('manhour_id')->nullable()->constrained('man_hours')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('coil_lv')->nullable();
            // $table->string('coil_lv_plus')->nullable();
            $table->string('coil_hv')->nullable();
            // $table->string('coil_hv_plus')->nullable();
            $table->string('cca')->nullable();
            $table->string('connection')->nullable();
            $table->string('hv_connection')->nullable();
            $table->string('final')->nullable();
            $table->string('final_assy')->nullable();
            $table->string('special_assembly')->nullable();
            $table->string('finishing')->nullable();
            $table->string('qc_testing')->nullable();
            $table->float('totalHour_coil_making')->nullable();
            $table->float('totalHour_CoreCoilAssembly')->nullable();
            $table->float('totalHour_Conect')->nullable();
            $table->float('totalHour_FinalAssembly')->nullable();
            $table->float('totalHour_SpecialFinalAssembly')->nullable();
            $table->float('totalHour_Finishing')->nullable();
            $table->float('totalHour_QCTest')->nullable();
            $table->float('hour_coil_lv')->nullable();
            // $table->float('hour_coil_lv_plus')->nullable();
            $table->float('hour_coil_hv')->nullable();
            // $table->float('hour_coil_hv_plus')->nullable();
            $table->float('hour_cca')->nullable();
            $table->float('hour_connection')->nullable();
            $table->float('hour_hv_connection')->nullable();
            $table->float('hour_final')->nullable();
            $table->float('hour_final_assy')->nullable();
            $table->float('hour_special_assembly')->nullable();
            $table->float('hour_finishing')->nullable();
            $table->float('hour_qc_testing')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oil_customs');
    }
};
