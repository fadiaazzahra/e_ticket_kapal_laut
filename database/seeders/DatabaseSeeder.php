<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kapal;
use App\Models\Jadwal;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@kapal.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'user@kapal.com',
            'password' => bcrypt('user123'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@kapal.com',
            'password' => bcrypt('user123'),
            'role' => 'user',
        ]);

        // 2. Seed Kapals (Ships)
        $kapal1 = Kapal::create([
            'nama_kapal' => 'KM Kelud',
            'kapasitas' => 1500,
            'kelas' => 'Ekonomi, Bisnis, VIP',
        ]);

        $kapal2 = Kapal::create([
            'nama_kapal' => 'KM Lawit',
            'kapasitas' => 800,
            'kelas' => 'Ekonomi, Bisnis',
        ]);

        $kapal3 = Kapal::create([
            'nama_kapal' => 'KM Sinabung',
            'kapasitas' => 2000,
            'kelas' => 'Ekonomi, Bisnis, VIP',
        ]);

        $kapal4 = Kapal::create([
            'nama_kapal' => 'KM Bukit Siguntang',
            'kapasitas' => 1200,
            'kelas' => 'Ekonomi, Bisnis, VIP',
        ]);

        // 3. Seed Jadwals (Schedules)
        $ports = ['Tanjung Priok (Jakarta)', 'Tanjung Perak (Surabaya)', 'Belawan (Medan)', 'Soekarno-Hatta (Makassar)', 'Dumas (Benoa Bali)'];

        // Schedule 1: KM Kelud - Jakarta to Medan
        Jadwal::create([
            'id_kapal' => $kapal1->id_kapal,
            'asal' => 'Tanjung Priok (Jakarta)',
            'tujuan' => 'Belawan (Medan)',
            'tanggal' => Carbon::now()->addDays(2)->format('Y-m-d'),
            'jam_berangkat' => '08:00:00',
            'harga' => 450000.00,
        ]);

        // Schedule 2: KM Kelud - Medan to Jakarta
        Jadwal::create([
            'id_kapal' => $kapal1->id_kapal,
            'asal' => 'Belawan (Medan)',
            'tujuan' => 'Tanjung Priok (Jakarta)',
            'tanggal' => Carbon::now()->addDays(4)->format('Y-m-d'),
            'jam_berangkat' => '14:00:00',
            'harga' => 450000.00,
        ]);

        // Schedule 3: KM Lawit - Jakarta to Surabaya
        Jadwal::create([
            'id_kapal' => $kapal2->id_kapal,
            'asal' => 'Tanjung Priok (Jakarta)',
            'tujuan' => 'Tanjung Perak (Surabaya)',
            'tanggal' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'jam_berangkat' => '10:30:00',
            'harga' => 240000.00,
        ]);

        // Schedule 4: KM Sinabung - Surabaya to Makassar
        Jadwal::create([
            'id_kapal' => $kapal3->id_kapal,
            'asal' => 'Tanjung Perak (Surabaya)',
            'tujuan' => 'Soekarno-Hatta (Makassar)',
            'tanggal' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'jam_berangkat' => '20:00:00',
            'harga' => 380000.00,
        ]);

        // Schedule 5: KM Bukit Siguntang - Makassar to Balikpapan/Surabaya
        Jadwal::create([
            'id_kapal' => $kapal4->id_kapal,
            'asal' => 'Soekarno-Hatta (Makassar)',
            'tujuan' => 'Tanjung Perak (Surabaya)',
            'tanggal' => Carbon::now()->addDays(2)->format('Y-m-d'),
            'jam_berangkat' => '17:00:00',
            'harga' => 390000.00,
        ]);

        // Schedule 6: KM Sinabung - Bali to Surabaya
        Jadwal::create([
            'id_kapal' => $kapal3->id_kapal,
            'asal' => 'Dumas (Benoa Bali)',
            'tujuan' => 'Tanjung Perak (Surabaya)',
            'tanggal' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'jam_berangkat' => '09:00:00',
            'harga' => 200000.00,
        ]);

        // Schedule 7: KM Kelud - Jakarta to Surabaya (added for more options)
        Jadwal::create([
            'id_kapal' => $kapal1->id_kapal,
            'asal' => 'Tanjung Priok (Jakarta)',
            'tujuan' => 'Tanjung Perak (Surabaya)',
            'tanggal' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'jam_berangkat' => '13:00:00',
            'harga' => 250000.00,
        ]);
    }
}
