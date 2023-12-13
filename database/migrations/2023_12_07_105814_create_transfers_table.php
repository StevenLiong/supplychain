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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('no_bon')->default('T0');
            $table->string('id_wo')->references('id_wo')->on('wo');
            $table->string('status', 1)->default(0)->comment('1=TP41, 2=TP42, 3=TP43, 4=TP44, 5=TP45, 6=TP46, 7=TP47');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer');
    }
};
