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
        Schema::create('standardize_works', function (Blueprint $table) {
            $table->id();
            $table->string('total_hour');
            $table->string('kd_manhour');
            $table->string('id_fg');
            $table->foreignId('id_dry_cast_resin')->nullable()->constrained('dry_cast_resins')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_dry_non_resin')->nullable()->constrained('dry_non_resins')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_oil_standard')->nullable()->constrained('oil_standards')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_oil_custom')->nullable()->constrained('oil_customs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_ct')->nullable()->constrained('cts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_vt')->nullable()->constrained('vts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_repair')->nullable()->constrained('repairs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standardize_works');
    }
};
