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
        Schema::create('detail_jasa', function (Blueprint $table) {
            $table->unsignedInteger('id_jasa');
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('subtotal');
            $table->string('no_penjualan', 20);
            $table->foreign('id_jasa')->references('id_jasa')->on('jasa');
            $table->foreign('no_penjualan')->references('no_penjualan')->on('penjualan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_jasa');
    }
};
