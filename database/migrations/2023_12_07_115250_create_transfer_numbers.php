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
        Schema::create('transfer_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('no_bon')->default('T');
            $table->timestamps();
        });

        DB::table('transfer_numbers')->insert([
            'no_bon' => 'T1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_numbers');
    }
};
