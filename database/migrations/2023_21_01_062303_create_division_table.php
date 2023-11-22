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
        Schema::create('division', function (Blueprint $table) {
            $table->id();
            $table->string('id_division');
            $table->string('name_division');
        });
    }

    /**
     * Reverse the migrati ons.
     */
    public function down(): void
    {
        Schema::dropIfExists('division');
    }
};
