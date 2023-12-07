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
        Schema::create('detailcuttings', function (Blueprint $table) {
            $table->id();
            $table->string('id_bon_e')->reference('no_bon')->on('cuttings');
            $table->string('bon_f')->references('no_bon')->on('orders');
            $table->string('nama_workcenter');
            $table->string('kd_material');
            $table->string('nama_material');
            $table->string('satuan');
            $table->integer('usage_material')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailcuttings');
    }
};
