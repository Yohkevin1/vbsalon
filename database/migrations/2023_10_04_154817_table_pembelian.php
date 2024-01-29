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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->string('no_pembelian', 20)->unique()->primary('no_pembelian');
            $table->string('no_pegawai', 20);
            $table->unsignedInteger('total_harga');
            $table->text('keterangan')->nullable();
            $table->string('kode_produk', 20)->nullable();
            $table->timestamps();
            $table->softDeletesDatetime('deleted_at');
            $table->foreign('no_pegawai')->references('no_pegawai')->on('pegawai');
            $table->foreign('kode_produk')->references('kode_produk')->on('produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
