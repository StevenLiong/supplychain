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
            $table->id('id_po');
            $table->date('tanggal');
            $table->string('status');
            $table->string('id_jenispembelian');
            $table->string('id_pembayaran');
            $table->string('id_mr');
            $table->string('id_alamat');
            $table->string('id_purchaser');
            $table->string('id_suplier');
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
