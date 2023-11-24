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
        Schema::create('purchaser', function (Blueprint $table) {
            $table->id('id_purchaser');
            $table->string('name_purchaser');
            $table->string('email')->unique();
            $table->integer('nohp');
            $table->integer('nip');
            // $table->string('id_user');
        });
    }

    /**
     * Reverse the migrati ons.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchaser');
    }
};
