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
        Schema::create('cuttings', function (Blueprint $table) {
            $table->id();
            $table->string('no_bon')->default('E000');
            $table->unsignedBigInteger('bon_f');
            $table->date('tanggal_bon');
            $table->string('status', 1)->default(0)->comment('0=Pending, 1=Completed');
            $table->timestamps();

            $table->foreign('bon_f')->references('id')->on('orders')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutting');
    }
};
