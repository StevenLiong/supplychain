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
        Schema::create('detailboms', function (Blueprint $table) {
            $table->id();
            $table->string('id_boms')->references('id_bom')->on('boms');
            $table->string('nama_workcenter');
            $table->string('id_materialbom')->references('kd_barang')->on('materials');
            $table->string('db_status', 1)->default(0)->comment('0=Pending, 1=Completed');
            $table->string('keterangan')->nullable();
            $table->string('email_status', 1)->default(0)->comment('0=Belum Kirim, 1=Sudah Dikirim');
            $table->string('nama_materialbom'); 
            $table->string('uom_material');
            $table->integer('qty_trafo');
            $table->integer('qty_material');
            $table->string('tolerance');
            $table->integer('usage_material'); 
            $table->boolean('submitted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailboms');
    }
};