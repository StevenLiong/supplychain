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
        Schema::create('bpnb_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('no_bon')->default('B00');
            $table->timestamps();
        });

        DB::table('bpnb_numbers')->insert([
            'no_bon' => 'B0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpnbnumbers');
    }
};
