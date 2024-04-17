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
        Schema::create('ct_vts', function (Blueprint $table) {
            $table->id();
            $table->string('kd_manhour', 14)->unique();
            $table->string('kategori')->default('3');
            $table->string('ukuran_kapasitas');
            $table->string('nama_product')->default('CT/VT')->index();
            $table->string('id_fg');
            $table->string('nomor_so');
            $table->float('total_hour');
            $table->string('balut_core_ct')->nullable();
            $table->string('cca_balutvt')->nullable();
            $table->string('buat_pasang_shelding')->nullable();
            $table->string('gulung_coil_sekunder_ct')->nullable();
            $table->string('buat_coil_primer_ct_manual')->nullable();
            $table->string('buat_coil_primer_ct_mesin')->nullable();
            $table->string('conect_ct_vt')->nullable();
            $table->string('solder')->nullable();
            $table->string('gulung_coil_primer_cutcore')->nullable();
            $table->string('gulung_coil_primer_nocutcor')->nullable();
            $table->string('gulungcoil_vt_mesin')->nullable();
            $table->string('gulungcoil_vt_manual')->nullable();
            $table->string('mould_assembly_ct')->nullable();
            $table->string('prosesmouldassembly_typevt')->nullable();
            $table->string('mould_assembly_rct')->nullable();
            $table->string('oven')->nullable();
            $table->string('pembuatan_material')->nullable();
            $table->string('casting')->nullable();
            $table->string('demoulding')->nullable();
            $table->string('gerinda')->nullable();
            $table->string('cat')->nullable();
            $table->string('accessoris')->nullable();
            $table->string('qc_testing')->nullable();
            $table->float('totalHour_coil_making')->nullable();
            $table->float('totalHour_MouldCasting')->nullable();
            $table->float('totalHour_FinalAssembly')->nullable();
            $table->float('hour_balut_core_ct')->nullable();
            $table->float('hour_cca_balutvt')->nullable();
            $table->float('hour_buat_pasang_shelding')->nullable();
            $table->float('hour_gulung_coil_sekunder_ct')->nullable();
            $table->float('hour_buat_coil_primer_ct_manual')->nullable();
            $table->float('hour_buat_coil_primer_ct_mesin')->nullable();
            $table->float('hour_conect_ct_vt')->nullable();
            $table->float('hour_solder')->nullable();
            $table->float('hour_gulung_coil_primer_cutcore')->nullable();
            $table->float('hour_gulung_coil_primer_nocutcor')->nullable();
            $table->float('hour_gulungcoil_vt_mesin')->nullable();
            $table->float('hour_gulungcoil_vt_manual')->nullable();
            $table->float('hour_mould_assembly_ct')->nullable();
            $table->float('hour_prosesmouldassembly_typevt')->nullable();
            $table->float('hour_mould_assembly_rct')->nullable();
            $table->float('hour_oven')->nullable();
            $table->float('hour_pembuatan_material')->nullable();
            $table->float('hour_casting')->nullable();
            $table->float('hour_demoulding')->nullable();
            $table->float('hour_gerinda')->nullable();
            $table->float('hour_cat')->nullable();
            $table->float('hour_accessoris')->nullable();
            $table->float('hour_qc_testing')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_vts');
    }
};
