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
            $table->string('kategori')->default('5');
            $table->string('ukuran_kapasitas');
            $table->string('nama_product')->default('CT')->index();
            $table->string('nomor_so');
            $table->integer('total_hour');
            $table->foreignId('manhour_id')->nullable()->constrained('man_hours')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('coil_ct')->nullable();
            $table->string('mould_casting')->nullable();
            $table->string('final_assembly')->nullable();
            $table->string('potong_isolasi')->nullable();
            $table->string('qc_testing')->nullable();
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
