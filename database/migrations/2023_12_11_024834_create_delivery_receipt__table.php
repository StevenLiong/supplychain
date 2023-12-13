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
        Schema::create('delivery_receipt', function (Blueprint $table) {
            $table->id();
            $table->string('no_delivery');
            $table->string('id_wo', 100);
            $table->date('Tanggal_Delivery');
            $table->string('nsp', 100);
            $table->string('nsk', 100);
            $table->string('NO_SO', 100);
            $table->string('NO_DO', 100);
            $table->string('packaging', 100);
            $table->string('ekspedisi', 100);
            $table->string('no_kendaraan', 100);
            // $table->string('alamat', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_receipt');
    }

};
