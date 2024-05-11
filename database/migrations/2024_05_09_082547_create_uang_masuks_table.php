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
        Schema::create('uang_masuk', function (Blueprint $table) {
            $table->id('id_uangmasuk');
            $table->enum('sumber', ['penduduk', 'pemerintah'])->default('penduduk');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->integer('jumlah');
            $table->string('bukti_transfer');
            $table->string('keterangan');
            $table->enum('validasi', ['diterima', 'menunggu persetujuan', 'ditolak'])->default('menunggu persetujuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uang_masuk');
    }
};
