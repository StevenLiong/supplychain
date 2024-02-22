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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('no');
            $table->string('item_code')->references('kd_material')->on('materials');
            $table->string('item_name');
            $table->string('tiga_item_name');
            $table->integer('stock_on_hand')->default('0');
            $table->string('supplier');
            $table->string('rop');
            $table->string('max');
            $table->string('rop_safety');
            $table->string('max_safety');
            $table->string('safety_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
