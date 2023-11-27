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
        Schema::create('alamat', function (Blueprint $table) {
            $table->id('id_alamat');
            $table->string('alamat');
        });
    }

    /**
     * Reverse the migrati ons.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat');
    }
};
