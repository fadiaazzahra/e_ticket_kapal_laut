<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanans';
    protected $primaryKey = 'id_pemesanan';

    protected $fillable = [
        'kode_booking',
        'id_user',
        'id_jadwal',
        'nama_lengkap',
        'nik',
        'no_hp',
        'email',
        'jenis_kelas',
        'jumlah_penumpang',
        'total_harga',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pemesanan', 'id_pemesanan');
    }
}
