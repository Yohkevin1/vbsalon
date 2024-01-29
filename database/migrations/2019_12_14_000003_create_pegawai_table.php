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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->string('no_pegawai', 20)->unique()->primary('no_pegawai');
            $table->string('foto')->default('pegawai.svg');
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->date('tgl_lahir');
            $table->string('alamat');
            $table->string('no_hp', 15);
            $table->unsignedInteger('id_user');
            $table->timestamps();
            $table->softDeletesDatetime('deleted_at');
            $table->foreign('id_user')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
