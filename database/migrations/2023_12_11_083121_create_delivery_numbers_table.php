<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('no_delivery');
            $table->timestamps();
        });

        // Insert record pertama
        DB::table('delivery_numbers')->insert([
            'no_delivery' => 'D1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_numbers');
    }
};
