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
        Schema::create('kapasitas_produksis', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->integer('pl2');
            $table->integer('pl3');
            $table->integer('drytype');

            $table->decimal('oee_drytype', 5, 2)->nullable();
            $table->decimal('oee_pl2', 5, 2)->nullable();
            $table->decimal('oee_pl3', 5, 2)->nullable();
            
            $table->integer('output_drytype')->nullable();
            $table->integer('output_pl2')->nullable();
            $table->integer('output_pl3')->nullable();

            $table->integer('shift_kerja_drytype')->nullable();
            $table->integer('shift_kerja_pl2')->nullable();
            $table->integer('shift_kerja_pl3')->nullable();

            $table->integer('jam_kerja_drytype')->nullable();
            $table->integer('jam_kerja_pl2')->nullable();
            $table->integer('jam_kerja_pl3')->nullable();

            $table->decimal('aktual_oee_drytype',5,2)->nullable();
            $table->decimal('aktual_oee_pl2',5,2)->nullable();
            $table->decimal('aktual_oee_pl3',5,2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kapasitas_produksis');
    }
};