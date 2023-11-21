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
        Schema::create('dry_non_resins', function (Blueprint $table) {
            $table->id();
            $table->string('kd_manhour', 14)->unique();
            $table->string('nama_product')->default('Dry Cast Non Resin')->index();
            $table->string('nomor_so');
            $table->integer('total_hour');
            $table->string('kategori')->default('5');
            $table->string('ukuran_kapasitas');
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
            $table->string('routine_test')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dry_non_resin');
    }
};
