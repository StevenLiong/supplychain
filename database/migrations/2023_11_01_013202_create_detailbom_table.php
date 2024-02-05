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
            $table->string('id_boms')->references('id_bom')->on('boms')->nullable();
            $table->string('nama_workcenter')->nullable();
            $table->string('id_materialbom')->references('kd_barang')->on('materials')->nullable();
            $table->string('db_status', 1)->default(0)->comment('0=Pending, 1=Completed')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('email_status', 1)->default(0)->comment('0=Belum Kirim, 1=Sudah Dikirim');
            $table->string('nama_materialbom')->nullable(); 
            $table->string('uom_material')->nullable();
            $table->integer('qty_trafo')->nullable();
            $table->integer('qty_material')->nullable();
            $table->string('tolerance')->nullable();
            $table->integer('usage_material')->nullable(); 
            $table->boolean('submitted')->default(false)->nullable();
            $table->timestamp('last_kirim_email')->nullable();
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