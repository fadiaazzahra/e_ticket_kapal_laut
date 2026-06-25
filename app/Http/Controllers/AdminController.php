<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kapal;
use App\Models\Jadwal;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Models\Rekening;
use App\Models\Qris;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    // 1. Dashboard
    public function dashboard()
    {
        $totalKapal = Kapal::count();
        $totalJadwal = Jadwal::count();
        $totalUser = User::where('role', 'user')->count();
        
        $totalTiketTerjual = Pemesanan::where('status', 'paid')->sum('jumlah_penumpang');
        $totalPendapatan = Pemesanan::where('status', 'paid')->sum('total_harga');

        $recentBookings = Pemesanan::with(['jadwal.kapal', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Chart 1: Ticket Sales by Ship
        $salesByShip = DB::table('pemesanans')
            ->join('jadwals', 'pemesanans.id_jadwal', '=', 'jadwals.id_jadwal')
            ->join('kapals', 'jadwals.id_kapal', '=', 'kapals.id_kapal')
            ->where('pemesanans.status', 'paid')
            ->select('kapals.nama_kapal', DB::raw('SUM(pemesanans.jumlah_penumpang) as total_sold'))
            ->groupBy('kapals.nama_kapal')
            ->get();

        // Chart 2: Daily Revenue (Last 7 Days)
        $dailyRevenue = DB::table('pemesanans')
            ->where('status', 'paid')
            ->where('updated_at', '>=', Carbon::now()->subDays(7))
            ->select(DB::raw('DATE(updated_at) as date'), DB::raw('SUM(total_harga) as revenue'))
            ->groupBy(DB::raw('DATE(updated_at)'))
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'totalKapal',
            'totalJadwal',
            'totalUser',
            'totalTiketTerjual',
            'totalPendapatan',
            'recentBookings',
            'salesByShip',
            'dailyRevenue'
        ));
    }

    // 2. Kelola Kapal (Ships CRUD)
    public function kapals()
    {
        $kapals = Kapal::orderBy('id_kapal', 'desc')->get();
        return view('admin.kapals.index', compact('kapals'));
    }

    public function storeKapal(Request $request)
    {
        $request->validate([
            'nama_kapal' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'kelas' => 'required|array', // submitted as array from checkbox/select
        ]);

        Kapal::create([
            'nama_kapal' => $request->nama_kapal,
            'kapasitas' => $request->kapasitas,
            'kelas' => implode(', ', $request->kelas),
        ]);

        return redirect()->route('admin.kapals')->with('success', 'Kapal berhasil ditambahkan!');
    }

    public function updateKapal(Request $request, $id_kapal)
    {
        $request->validate([
            'nama_kapal' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'kelas' => 'required|array',
        ]);

        $kapal = Kapal::findOrFail($id_kapal);
        $kapal->update([
            'nama_kapal' => $request->nama_kapal,
            'kapasitas' => $request->kapasitas,
            'kelas' => implode(', ', $request->kelas),
        ]);

        return redirect()->route('admin.kapals')->with('success', 'Kapal berhasil diperbarui!');
    }

    public function destroyKapal($id_kapal)
    {
        $kapal = Kapal::findOrFail($id_kapal);
        $kapal->delete();
        return redirect()->route('admin.kapals')->with('success', 'Kapal berhasil dihapus!');
    }

    // 3. Kelola Jadwal (Schedules CRUD)
    public function jadwals()
    {
        $jadwals = Jadwal::with('kapal')->orderBy('tanggal', 'desc')->get();
        $kapals = Kapal::all();
        return view('admin.jadwals.index', compact('jadwals', 'kapals'));
    }

    public function storeJadwal(Request $request)
    {
        $request->validate([
            'id_kapal' => 'required|exists:kapals,id_kapal',
            'asal' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255|different:asal',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_berangkat' => 'required',
            'harga' => 'required|numeric|min:0',
        ], [
            'tujuan.different' => 'Tujuan harus berbeda dari pelabuhan asal.',
            'tanggal.after_or_equal' => 'Tanggal keberangkatan tidak boleh di masa lalu.',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('admin.jadwals')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function updateJadwal(Request $request, $id_jadwal)
    {
        $request->validate([
            'id_kapal' => 'required|exists:kapals,id_kapal',
            'asal' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255|different:asal',
            'tanggal' => 'required|date',
            'jam_berangkat' => 'required',
            'harga' => 'required|numeric|min:0',
        ]);

        $jadwal = Jadwal::findOrFail($id_jadwal);
        $jadwal->update($request->all());

        return redirect()->route('admin.jadwals')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroyJadwal($id_jadwal)
    {
        $jadwal = Jadwal::findOrFail($id_jadwal);
        $jadwal->delete();
        return redirect()->route('admin.jadwals')->with('success', 'Jadwal berhasil dihapus!');
    }

    // 4. Kelola Pemesanan (Bookings & Passengers Data)
    public function pemesanans()
    {
        $pemesanans = Pemesanan::with(['jadwal.kapal', 'user'])->orderBy('created_at', 'desc')->get();
        return view('admin.pemesanans.index', compact('pemesanans'));
    }

    // 5. Kelola Pembayaran (Payment Verification)
    public function pembayarans()
    {
        $pembayarans = Pembayaran::with('pemesanan.jadwal.kapal')->orderBy('created_at', 'desc')->get();
        return view('admin.pembayarans.index', compact('pembayarans'));
    }

    public function confirmPayment(Request $request, $id_pembayaran)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        $pembayaran = Pembayaran::with('pemesanan')->findOrFail($id_pembayaran);

        if ($request->action === 'approve') {
            $pembayaran->update(['status' => 'approved']);
            $pembayaran->pemesanan->update(['status' => 'paid']);
            $message = 'Pembayaran berhasil disetujui, E-Ticket telah aktif.';
        } else {
            $pembayaran->update(['status' => 'rejected']);
            $pembayaran->pemesanan->update(['status' => 'cancelled']);
            $message = 'Pembayaran ditolak, Pemesanan otomatis dibatalkan.';
        }

        return redirect()->route('admin.pembayarans')->with('success', $message);
    }

    // 6. Kelola Pengguna (Users CRUD)
    public function users()
    {
        $users = User::orderBy('role', 'asc')->orderBy('name', 'asc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dibuat!');
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,user',
        ]);

        $user = User::findOrFail($id);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil diperbarui!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus!');
    }

    // 7. Laporan (Reports)
    public function laporan(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $pemesanans = Pemesanan::with(['jadwal.kapal', 'user', 'pembayaran'])
            ->where('status', 'paid')
            ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('updated_at', 'asc')
            ->get();

        $totalRevenue = $pemesanans->sum('total_harga');
        $totalTickets = $pemesanans->sum('jumlah_penumpang');

        return view('admin.laporan', compact('pemesanans', 'startDate', 'endDate', 'totalRevenue', 'totalTickets'));
    }

    public function exportLaporan(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $pemesanans = Pemesanan::with(['jadwal.kapal', 'user'])
            ->where('status', 'paid')
            ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('updated_at', 'asc')
            ->get();

        $filename = "laporan_penjualan_{$startDate}_to_{$endDate}.csv";

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = [
            'Kode Booking', 
            'Tanggal Transaksi', 
            'Nama Pelanggan', 
            'Nama Kapal', 
            'Rute', 
            'Tanggal Keberangkatan', 
            'Kelas', 
            'Jumlah Penumpang', 
            'Total Harga (IDR)'
        ];

        $callback = function() use($pemesanans, $columns) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for proper Excel rendering of characters
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, $columns);

            foreach ($pemesanans as $p) {
                fputcsv($file, [
                    $p->kode_booking,
                    $p->updated_at->format('Y-m-d H:i:s'),
                    $p->nama_lengkap,
                    $p->jadwal->kapal->nama_kapal,
                    $p->jadwal->asal . ' -> ' . $p->jadwal->tujuan,
                    $p->jadwal->tanggal,
                    $p->jenis_kelas,
                    $p->jumlah_penumpang,
                    $p->total_harga
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // 8. Kelola Metode Pembayaran
    public function paymentMethods()
    {
        $banks = Rekening::orderBy('nama_bank', 'asc')->get();
        $qrisList = Qris::orderBy('id', 'desc')->get();
        return view('admin.payment_methods.index', compact('banks', 'qrisList'));
    }

    public function storeBank(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
        ]);

        Rekening::create([
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik' => $request->nama_pemilik,
            'is_aktif' => true, // default active when created
        ]);

        return redirect()->route('admin.payment-methods')->with('success', 'Rekening berhasil ditambahkan!');
    }

    public function updateBank(Request $request, $id)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
        ]);

        $bank = Rekening::findOrFail($id);
        $bank->update([
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik' => $request->nama_pemilik,
        ]);

        return redirect()->route('admin.payment-methods')->with('success', 'Rekening berhasil diperbarui!');
    }

    public function destroyBank($id)
    {
        $bank = Rekening::findOrFail($id);
        $bank->delete();
        return redirect()->route('admin.payment-methods')->with('success', 'Rekening berhasil dihapus!');
    }

    public function toggleBank($id)
    {
        $bank = Rekening::findOrFail($id);
        $bank->update(['is_aktif' => !$bank->is_aktif]);
        return redirect()->route('admin.payment-methods')->with('success', 'Status rekening berhasil diubah!');
    }

    public function storeQris(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'image.required' => 'Gambar QRIS wajib diunggah.',
            'image.max' => 'Ukuran file gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'qris_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/qris'), $filename);

            Qris::create([
                'image_path' => 'uploads/qris/' . $filename,
                'is_aktif' => true, // default active
            ]);
        }

        return redirect()->route('admin.payment-methods')->with('success', 'QRIS baru berhasil ditambahkan!');
    }

    public function updateQris(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'image.required' => 'Gambar QRIS wajib diunggah.',
            'image.max' => 'Ukuran file gambar maksimal 2MB.',
        ]);

        $qris = Qris::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old file if it exists
            if ($qris->image_path && file_exists(public_path($qris->image_path))) {
                @unlink(public_path($qris->image_path));
            }

            $file = $request->file('image');
            $filename = 'qris_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/qris'), $filename);

            $qris->update([
                'image_path' => 'uploads/qris/' . $filename,
            ]);
        }

        return redirect()->route('admin.payment-methods')->with('success', 'Gambar QRIS berhasil diperbarui!');
    }

    public function destroyQris($id)
    {
        $qris = Qris::findOrFail($id);
        
        // Delete file
        if ($qris->image_path && file_exists(public_path($qris->image_path))) {
            @unlink(public_path($qris->image_path));
        }

        $qris->delete();
        return redirect()->route('admin.payment-methods')->with('success', 'QRIS berhasil dihapus!');
    }

    public function toggleQris($id)
    {
        $qris = Qris::findOrFail($id);
        $qris->update(['is_aktif' => !$qris->is_aktif]);
        return redirect()->route('admin.payment-methods')->with('success', 'Status QRIS berhasil diubah!');
    }
}
