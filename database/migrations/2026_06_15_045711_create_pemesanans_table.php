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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id('id_pemesanan');
            $table->string('kode_booking')->unique();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_jadwal')->constrained('jadwals', 'id_jadwal')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nik');
            $table->string('no_hp');
            $table->string('email');
            $table->enum('jenis_kelas', ['Ekonomi', 'Bisnis', 'VIP'])->default('Ekonomi');
            $table->integer('jumlah_penumpang');
            $table->decimal('total_harga', 10, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
