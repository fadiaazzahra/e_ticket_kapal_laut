<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_kapal',
        'asal',
        'tujuan',
        'tanggal',
        'jam_berangkat',
        'harga',
    ];

    public function kapal()
    {
        return $this->belongsTo(Kapal::class, 'id_kapal', 'id_kapal');
    }

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'id_jadwal', 'id_jadwal');
    }
}
