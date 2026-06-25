<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kapal extends Model
{
    use HasFactory;

    protected $table = 'kapals';
    protected $primaryKey = 'id_kapal';

    protected $fillable = [
        'nama_kapal',
        'kapasitas',
        'kelas',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_kapal', 'id_kapal');
    }
}
