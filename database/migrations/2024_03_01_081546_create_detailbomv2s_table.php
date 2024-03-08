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
        Schema::create('detailbomv2s', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('id_boms')->nullable()->constrained('bomv2s');
            $table->string('id_boms')->nullable();
            // $table->foreignId('id_warehouse')->nullable()->constrained('warehouses');
            // $table->foreignId('id_workcenter')->nullable()->constrained('workcenters');
            $table->string('id_warehouse1')->nullable();
            $table->string('nama_workcenter')->nullable();
            $table->string('id_materialbom')->references('kd_barang')->on('materials')->nullable();
            $table->string('nama_materialbom')->nullable(); 
            $table->string('second_material_name')->nullable(); 
            $table->string('uom_material')->nullable();
            $table->integer('comparison')->nullable();
            $table->integer('composite')->nullable();
            $table->string('tolerance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailbomv2s');
    }
};
