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
        Schema::create('cts', function (Blueprint $table) {
            $table->id();
            $table->string('kd_manhour', 14)->unique();
            $table->string('kategori')->default('3');
            $table->string('ukuran_kapasitas');
            $table->string('nama_product')->default('CT')->index();
            $table->string('id_fg');
            $table->string('nomor_so');
            $table->float('total_hour');
            // $table->foreignId('manhour_id')->nullable()->constrained('man_hours')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('balut_core_ct')->nullable();
            $table->string('cca_balut_ct')->nullable();
            $table->string('buat_pasang_shelding')->nullable();
            $table->string('gulung_coil_sekunder_ct')->nullable();
            $table->string('buat_coil_primer_ct_manual')->nullable();
            $table->string('buat_coil_primer_ct_mesin')->nullable();
            $table->string('conect_ct_vt')->nullable();
            $table->string('solder')->nullable();
            $table->string('gulung_coil_primer_cutcore')->nullable();
            $table->string('gulung_coil_primer_nocutcor')->nullable();
            $table->string('mould_assembly_ct')->nullable();
            $table->string('mould_assembly_rct')->nullable();
            $table->string('oven')->nullable();
            $table->string('pembuatan_material')->nullable();
            $table->string('casting')->nullable();
            $table->string('demolding')->nullable();
            $table->string('gerinda')->nullable();
            $table->string('cat')->nullable();
            $table->string('accessoris')->nullable();
            $table->string('qc_testing')->nullable();
            $table->integer('totalHour_Coil_making')->nullable();
            $table->integer('totalHour_mould_casting')->nullable();
            $table->integer('totalHour_final_assembly')->nullable();
            $table->integer('hour_balut_core_ct')->nullable();
            $table->integer('hour_cca_balut_ct')->nullable();
            $table->integer('hour_buat_pasang_shelding')->nullable();
            $table->integer('hour_gulung_coil_sekunder_ct')->nullable();
            $table->integer('hour_buat_coil_primer_ct_manual')->nullable();
            $table->integer('hour_buat_coil_primer_ct_mesin')->nullable();
            $table->integer('hour_conect_ct_vt')->nullable();
            $table->integer('hour_solder')->nullable();
            $table->integer('hour_gulung_coil_primer_cutcore')->nullable();
            $table->integer('hour_gulung_coil_primer_nocutcor')->nullable();
            $table->integer('hour_mould_assembly_ct')->nullable();
            $table->integer('hour_mould_assembly_rct')->nullable();
            $table->integer('hour_oven')->nullable();
            $table->integer('hour_pembuatan_material')->nullable();
            $table->integer('hour_casting')->nullable();
            $table->integer('hour_demolding')->nullable();
            $table->integer('hour_gerinda')->nullable();
            $table->integer('hour_cat')->nullable();
            $table->integer('hour_accessoris')->nullable();
            $table->integer('hour_qc_testing')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cts');
    }
};
