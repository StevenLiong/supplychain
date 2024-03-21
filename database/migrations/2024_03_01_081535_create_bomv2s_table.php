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
        Schema::create('bomv2s', function (Blueprint $table) {
            $table->id();
            $table->string('id_bom');
            $table->string('deskripsi')->nullable();
            $table->integer('qty_bom')->nullable();
            $table->string('bom_status')->nullable();
            $table->string('uom_bom')->nullable();
            $table->string('id_so')->references('kode_so')->on('sos');
            $table->string('id_fg')->nullable();
            $table->string('status_bom', 2)->default(0)->comment('0=Process, 1=Pending, 2=Completed, 3=Approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bomv2s');
    }
};
