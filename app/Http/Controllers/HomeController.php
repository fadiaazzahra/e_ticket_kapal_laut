<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;

class HomeController extends Controller
{
    public function index()
    {
        // Get unique origin and destination ports for dropdowns
        $origins = Jadwal::select('asal')->distinct()->pluck('asal');
        $destinations = Jadwal::select('tujuan')->distinct()->pluck('tujuan');

        return view('home', compact('origins', 'destinations'));
    }

    public function jadwal(Request $request)
    {
        $origins = Jadwal::select('asal')->distinct()->pluck('asal');
        $destinations = Jadwal::select('tujuan')->distinct()->pluck('tujuan');

        // Build query
        $query = Jadwal::with('kapal');

        // Apply filters
        if ($request->filled('asal')) {
            $query->where('asal', $request->asal);
        }
        if ($request->filled('tujuan')) {
            $query->where('tujuan', $request->tujuan);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('asal', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%")
                  ->orWhereHas('kapal', function($qk) use ($search) {
                      $qk->where('nama_kapal', 'like', "%{$search}%");
                  });
            });
        }

        $jadwals = $query->orderBy('tanggal', 'asc')
                         ->orderBy('jam_berangkat', 'asc')
                         ->get();

        return view('jadwal', compact('jadwals', 'origins', 'destinations'));
    }
}
