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
        Schema::create('po', function (Blueprint $table) {
            $table->id();
            $table->string('id_po');
            $table->date('tanggal_po');
            $table->string('status_po');
            $table->string('jenispembelian');
            $table->string('tanggal_kirim');
            $table->string('keterangan');
            $table->string('jenispembayaran');
            $table->string('term');
            $table->string('id_delivery');
            $table->string('kd_supplier');
            $table->string('id_mr');
        });
    }

    /**
     * Reverse the migrati ons.
     */
    public function down(): void
    {
        Schema::dropIfExists('po');
    }
};
