<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Models\Rekening;
use App\Models\Qris;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $id_jadwal = $request->query('id_jadwal');
        if (!$id_jadwal) {
            return redirect()->route('jadwal')->with('error', 'Silakan pilih jadwal kapal terlebih dahulu.');
        }

        $jadwal = Jadwal::with('kapal')->find($id_jadwal);
        if (!$jadwal) {
            return redirect()->route('jadwal')->with('error', 'Jadwal tidak ditemukan.');
        }

        // Get class options
        $classOptions = array_map('trim', explode(',', $jadwal->kapal->kelas));

        return view('booking.create', compact('jadwal', 'classOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwals,id_jadwal',
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|numeric|digits_between:10,20',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'jenis_pengguna' => 'required|string|max:255',
            'jenis_kelas' => 'required|string',
            'jumlah_penumpang' => 'required|integer|min:1',
        ], [
            'nik.digits_between' => 'NIK harus berkisar antara 10 sampai 20 digit.',
            'jumlah_penumpang.min' => 'Minimal jumlah penumpang adalah 1 orang.',
        ]);

        $jadwal = Jadwal::with('kapal')->findOrFail($request->id_jadwal);

        // Check availability
        $bookedSeats = Pemesanan::where('id_jadwal', $request->id_jadwal)
            ->where('status', '!=', 'cancelled')
            ->sum('jumlah_penumpang');

        $availableSeats = $jadwal->kapal->kapasitas - $bookedSeats;

        if ($request->jumlah_penumpang > $availableSeats) {
            return back()->withErrors([
                'jumlah_penumpang' => "Sisa kursi tidak mencukupi. Hanya tersedia {$availableSeats} kursi tersisa."
            ])->withInput();
        }

        // Calculate Pricing
        $basePrice = $jadwal->harga;
        $multiplier = 1.0;
        if ($request->jenis_kelas === 'Bisnis') {
            $multiplier = 1.5;
        } elseif ($request->jenis_kelas === 'VIP') {
            $multiplier = 2.0;
        }

        $totalPrice = $basePrice * $multiplier * $request->jumlah_penumpang;

        // Generate Booking Code
        $bookingCode = 'BKG-' . strtoupper(Str::random(8));
        while (Pemesanan::where('kode_booking', $bookingCode)->exists()) {
            $bookingCode = 'BKG-' . strtoupper(Str::random(8));
        }

        $pemesanan = Pemesanan::create([
            'kode_booking' => $bookingCode,
            'id_user' => Auth::id(),
            'id_jadwal' => $request->id_jadwal,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'jenis_pengguna' => $request->jenis_pengguna,
            'jenis_kelas' => $request->jenis_kelas,
            'jumlah_penumpang' => $request->jumlah_penumpang,
            'total_harga' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('booking.payment', $pemesanan->id_pemesanan)
            ->with('success', 'Pemesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function payment($id_pemesanan)
    {
        $pemesanan = Pemesanan::with('jadwal.kapal')->findOrFail($id_pemesanan);

        // Security check
        if ($pemesanan->id_user !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        if ($pemesanan->status !== 'pending') {
            return redirect()->route('booking.history')
                ->with('info', 'Pemesanan ini sudah diproses.');
        }

        $activeBanks = Rekening::where('is_aktif', true)->get();
        $activeQris = Qris::where('is_aktif', true)->get();

        return view('booking.payment', compact('pemesanan', 'activeBanks', 'activeQris'));
    }

    public function submitPayment(Request $request, $id_pemesanan)
    {
        $pemesanan = Pemesanan::findOrFail($id_pemesanan);

        if ($pemesanan->id_user !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'metode' => 'required|string',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'bukti_transfer.required' => 'Mohon unggah bukti pembayaran.',
            'bukti_transfer.max' => 'Ukuran file bukti pembayaran maksimal 2MB.',
        ]);

        // Handle file upload
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $filename = 'proof_' . $pemesanan->kode_booking . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store directly in public folder
            $file->move(public_path('uploads/bukti_transfer'), $filename);
            
            // Create payment
            Pembayaran::create([
                'id_pemesanan' => $pemesanan->id_pemesanan,
                'metode' => $request->metode,
                'bukti_transfer' => 'uploads/bukti_transfer/' . $filename,
                'tanggal_bayar' => Carbon::now(),
                'status' => 'pending',
            ]);

            // Note: The booking status remains pending until approved by admin.
            // But we can update if needed, we'll keep it pending as requested, 
            // and the admin will approve it to make both booking and payment status "paid"/"approved".
        }

        return redirect()->route('booking.history')
            ->with('success', 'Bukti pembayaran telah diunggah. Menunggu konfirmasi admin.');
    }

    public function ticket($kode_booking)
    {
        $pemesanan = Pemesanan::with(['jadwal.kapal', 'pembayaran'])
            ->where('kode_booking', $kode_booking)
            ->firstOrFail();

        // Check access: must be owner of booking OR admin
        if (Auth::user()->role !== 'admin' && $pemesanan->id_user !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        if ($pemesanan->status !== 'paid') {
            return redirect()->route('booking.history')
                ->with('error', 'E-Ticket hanya tersedia untuk pemesanan yang sudah Lunas.');
        }

        return view('booking.ticket', compact('pemesanan'));
    }

    public function history(Request $request)
    {
        $query = Pemesanan::with(['jadwal.kapal', 'pembayaran'])
            ->where('id_user', Auth::id());

        // Simple search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_booking', 'like', "%{$search}%")
                  ->orWhereHas('jadwal.kapal', function($qk) use ($search) {
                      $qk->where('nama_kapal', 'like', "%{$search}%");
                  });
            });
        }

        $pemesanans = $query->orderBy('created_at', 'desc')->get();

        return view('booking.history', compact('pemesanans'));
    }
}
