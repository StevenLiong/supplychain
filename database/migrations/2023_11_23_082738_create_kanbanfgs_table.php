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
        Schema::create('kanbanfgs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_fg')->references('kd_finishedgood')->on('finishedgoods');
            $table->string('nama_item');
            $table->integer('max_kanban');
            $table->integer('stock_on_hand')->nullable();
            $table->integer('unit');
            $table->string('status')->nullable();
            $table->integer('realisasi')->nullable();
            $table->string('email_status', 1)->default(0)->comment('0=Belum Kirim, 1=Sudah Dikirim');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kanbanfgs');
    }
};
