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
        'jenis_pengguna',
        'jenis_kelas',
        'jumlah_penumpang',
        'total_harga',
        'status',
    ];

    public static $jenisPenggunaList = [
        'Pejalan Kaki',
        'Golongan I (Sepeda)',
        'Golongan II (Sepeda Motor kurang dari 500 cc)',
        'Golongan III (Sepeda Motor lebih dari 500 cc)',
        'Golongan IVA (Mobil Pribadi / Sedan)',
        'Golongan IVB (Mobil Barang / Pickup, maksimal 5 meter)',
        'Golongan VA (Bus Sedang)',
        'Golongan VB (Truk Barang roda 4–6, panjang 5–7 meter)',
        'Golongan VIA (Bus Besar)',
        'Golongan VIB (Truk Barang Besar, panjang 7–10 meter)',
        'Golongan VII (Truk Tronton, roda lebih dari 6, panjang 10–12 meter)',
        'Golongan VIII (Kendaraan panjang 12–16 meter)',
        'Golongan IX (Kendaraan panjang lebih dari 16 meter)',
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
