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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->string('no_penjualan', 20)->unique()->primary('no_penjualan');
            $table->string('telp_pelanggan', 20)->nullable();
            $table->unsignedInteger('total_harga');
            $table->unsignedInteger('bayar');
            $table->string('no_pegawai', 20);
            $table->timestamps();
            $table->softDeletesDatetime('deleted_at');
            $table->foreign('no_pegawai')->references('no_pegawai')->on('pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
