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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('id_kapal')->constrained('kapals', 'id_kapal')->onDelete('cascade');
            $table->string('asal');
            $table->string('tujuan');
            $table->date('tanggal');
            $table->time('jam_berangkat');
            $table->decimal('harga', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
