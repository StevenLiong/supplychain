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
        Schema::create('dry_cast_resins', function (Blueprint $table) {
            $table->id();
            $table->string('kd_manhour', 14)->unique();
            $table->string('nama_product')->default('Dry Cast Resin')->index();
            $table->string('kategori')->default('5');
            $table->string('nomor_so');
            $table->string('id_fg');
            $table->string('ukuran_kapasitas');
            $table->integer('total_hour');
            $table->foreignId('manhour_id')->nullable()->constrained('man_hours')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('coil_lv')->nullable();
            $table->string('coil_hv')->nullable();
            $table->string('potong_leadwire')->nullable();
            $table->string('potong_isolasi')->nullable();
            $table->string('hv_moulding')->nullable();
            $table->string('hv_casting')->nullable();
            $table->string('hv_demoulding')->nullable();
            $table->string('lv_bobbin')->nullable();
            $table->string('lv_moulding')->nullable();
            $table->string('touch_up')->nullable();
            $table->string('type_susun_core')->nullable();
            $table->string('wiring')->nullable();
            $table->string('instal_housing')->nullable();
            $table->string('bongkar_housing')->nullable();
            $table->string('pembuatan_cu_link')->nullable();
            $table->string('others')->nullable();
            $table->string('accesories')->nullable();
            $table->string('potong_isolasi_fiber')->nullable();
            $table->string('qc_testing')->nullable();
            $table->string('totalHour_coil_making')->nullable();
            $table->string('totalHour_MouldCasting')->nullable();
            $table->string('totalHour_CoreCoilAssembly')->nullable();
            $table->string('totalHour_SusunCore')->nullable();
            $table->string('totalHour_Finishing')->nullable();
            $table->string('totalHour_Connection_Final_Assembly')->nullable();
            $table->string('totalHour_QCTest')->nullable();
            $table->string('hour_coil_lv')->nullable();
            $table->string('hour_coil_hv')->nullable();
            $table->string('hour_potong_leadwire')->nullable();
            $table->string('hour_potong_isolasi')->nullable();
            $table->string('hour_hv_moulding')->nullable();
            $table->string('hour_hv_casting')->nullable();
            $table->string('hour_hv_demoulding')->nullable();
            $table->string('hour_lv_bobbin')->nullable();
            $table->string('hour_lv_moulding')->nullable();
            $table->string('hour_touch_up')->nullable();
            $table->string('hour_type_susun_core')->nullable();
            $table->string('hour_wiring')->nullable();
            $table->string('hour_instal_housing')->nullable();
            $table->string('hour_bongkar_housing')->nullable();
            $table->string('hour_pembuatan_cu_link')->nullable();
            $table->string('hour_others')->nullable();
            $table->string('hour_accesories')->nullable();
            $table->string('hour_potong_isolasi_fiber')->nullable();
            $table->string('hour_qc_testing')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dry_cast_resin');
    }
};
