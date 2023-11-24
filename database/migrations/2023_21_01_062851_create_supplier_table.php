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
        Schema::create('supplier', function (Blueprint $table) {
            $table->string('id_supplier');
            $table->string('name_supplier');
            $table->string('alamat');
        });
    }

    /**
     * Reverse the migrati ons.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier');
    }
};
