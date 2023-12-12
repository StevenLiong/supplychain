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
        Schema::create('bpnbs', function (Blueprint $table) {
            $table->id();
            $table->string('no_bon')->default('T0');
            $table->string('id_po');
            $table->string('surat_jalan');
            $table->date('tgl_suratjalan');
            $table->date('tgl_bpnb');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpnbs');
    }
};
