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
        Schema::create('produk', function (Blueprint $table) {
            $table->string('kode_produk', 20)->unique()->primary('kode_produk');
            $table->string('foto')->default('produk.png');
            $table->string('merek', 100);
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('harga');
            $table->enum('status', ['ready', 'return', 'habis']);
            $table->string('kode_supplier', 20)->nullable();
            $table->timestamps();
            $table->softDeletesDatetime('deleted_at');
            $table->foreign('kode_supplier')->references('kode_supplier')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
