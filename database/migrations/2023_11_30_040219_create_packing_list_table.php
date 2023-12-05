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
        Schema::create('packing_list', function (Blueprint $table) {
            $table->id();
            $table->date('Tanggal_Packing');
            $table->string('NO_DO', 100);
            $table->string('NO_WO', 100);
            $table->string('NSP', 100);
            $table->string('NSK', 100);
            $table->string('packaging', 100);
            $table->string('ukuran_dimensi', 100);
            $table->string('supplier', 100);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packing_list');
    }
};
