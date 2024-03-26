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
        Schema::create('man_hours', function (Blueprint $table) {
            $table->id();
            $table->float('durasi_manhour');
            // $table->foreignId('id_work_center')->constrained('work_centers')->cascadeOnUpdate()->cascadeOnDelete();
            // $table->foreignId('id_proses')->constrained('proses')->cascadeOnUpdate()->cascadeOnDelete();
            // $table->foreignId('id_tipe_proses')->constrained('tipe_proses')->cascadeOnUpdate()->cascadeOnDelete();
            // $table->foreignId('id_kapasitas')->constrained('kapasitas')->cascadeOnUpdate()->cascadeOnDelete();
            // $table->foreignId('id_kategori_produk')->constrained('kategori_produk')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string("nama_workcenter");
            $table->string("nama_proses");
            $table->string("nama_tipeproses");
            $table->string("ukuran_kapasitas");
            $table->string("nama_kategoriproduk");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('man_hour');
    }
};
