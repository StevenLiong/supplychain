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
            $table->integer('total_hour');
            $table->string('kategori')->default('5');
            $table->string('ukuran_kapasitas');
            $table->foreignId('manhour_id')->nullable()->constrained('man_hours')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('on_cover_standard')->nullable();
            $table->string('sidewall')->nullable();
            $table->string('conservator')->nullable();
            $table->string('cable_box_hv')->nullable();
            $table->string('radiator')->nullable();
            $table->string('accessories_proteksi')->nullable();
            $table->string('angkat_coil')->nullable();
            $table->string('isolasi_coil')->nullable();
            $table->string('isolasi_cca')->nullable();
            $table->string('material_coil_lv_hv')->nullable();
            $table->string('core_coil_assembly')->nullable();
            $table->string('connection')->nullable();
            $table->string('hv_connection')->nullable();
            $table->string('lv_connection')->nullable();
            $table->string('accessories')->nullable();
            $table->string('cable_box')->nullable();
            $table->string('wiring')->nullable();
            $table->string('copper_link')->nullable();
            $table->string('radiator_panel')->nullable();
            $table->string('conservator_finish')->nullable();
            $table->string('qc_testing')->nullable();
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
