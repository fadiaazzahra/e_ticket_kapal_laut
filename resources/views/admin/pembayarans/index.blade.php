@extends('layouts.admin')

@section('title', 'Kelola Pembayaran')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-0 text-dark">Konfirmasi & Kelola Pembayaran</h4>
        <p class="text-muted small mb-0">Verifikasi bukti transfer pembayaran dari penumpang, setujui tiket boarding, atau tolak transaksi palsu.</p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="admin-card">
            @if($pembayarans->isEmpty())
                <div class="text-center py-4 text-muted">
                    Belum ada riwayat pembayaran yang diunggah oleh penumpang.
                </div>
            @else
                <div class="table-responsive table-responsive-custom">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th>Kode Booking</th>
                                <th>Penumpang</th>
                                <th>Metode Pembayaran</th>
                                <th>Tanggal Unggah</th>
                                <th>Bukti Transfer</th>
                                <th>Status Pembayaran</th>
                                <th class="text-center">Aksi Konfirmasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembayarans as $p)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $p->pemesanan->kode_booking }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $p->pemesanan->nama_lengkap }}</div>
                                        <div class="small text-success fw-bold">Rp {{ number_format($p->pemesanan->total_harga, 0, ',', '.') }}</div>
                                    </td>
                                    <td>{{ $p->metode }}</td>
                                    <td>
                                        <div>{{ $p->tanggal_bayar }}</div>
                                    </td>
                                    <td>
                                        @if($p->bukti_transfer)
                                            <!-- Proof thumbnail triggers a Modal -->
                                            <button type="button" class="btn btn-sm btn-link p-0" data-bs-toggle="modal" data-bs-target="#proofModal-{{ $p->id_pembayaran }}">
                                                <img src="{{ asset($p->bukti_transfer) }}" alt="Bukti Transfer" class="img-thumbnail" style="max-height: 50px; cursor: pointer;">
                                            </button>
                                        @else
                                            <span class="text-danger small">Belum Unggah</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->status === 'pending')
                                            <span class="badge badge-custom badge-pending"><i class="fa-solid fa-spinner fa-spin me-1"></i>Menunggu Verifikasi</span>
                                        @elseif($p->status === 'approved')
                                            <span class="badge badge-custom badge-paid"><i class="fa-solid fa-circle-check me-1"></i>Disetujui</span>
                                        @elseif($p->status === 'rejected')
                                            <span class="badge badge-custom badge-cancelled"><i class="fa-solid fa-circle-xmark me-1"></i>Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($p->status === 'pending')
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Approve Form -->
                                                <form action="{{ route('admin.pembayarans.confirm', $p->id_pembayaran) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="approve">
                                                    <button type="submit" class="btn btn-sm btn-success py-1 px-3 fw-bold">
                                                        <i class="fa-solid fa-check me-1"></i> Setuju
                                                    </button>
                                                </form>

                                                <!-- Reject Form -->
                                                <form action="{{ route('admin.pembayarans.confirm', $p->id_pembayaran) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="submit" class="btn btn-sm btn-danger py-1 px-3 fw-bold" onclick="return confirm('Apakah Anda yakin ingin menolak pembayaran ini? Status pemesanan akan dibatalkan.')">
                                                        <i class="fa-solid fa-xmark me-1"></i> Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted small"><i class="fa-solid fa-lock me-1"></i>Sudah Diproses</span>
                                        @endif
                                    </td>
                                </tr>

                                <!-- PROOF IMAGE DETAIL MODAL -->
                                @if($p->bukti_transfer)
                                    <div class="modal fade" id="proofModal-{{ $p->id_pembayaran }}" tabindex="-1" aria-labelledby="proofLabel-{{ $p->id_pembayaran }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content glass-panel border-0 text-dark">
                                                <div class="modal-header border-bottom-0">
                                                    <h5 class="modal-title" id="proofLabel-{{ $p->id_pembayaran }}"><i class="fa-solid fa-image me-2 text-primary"></i>Bukti Pembayaran: {{ $p->pemesanan->kode_booking }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center bg-white p-3 rounded">
                                                    <img src="{{ asset($p->bukti_transfer) }}" alt="Bukti Transfer Detail" class="img-fluid rounded border shadow-sm">
                                                </div>
                                                <div class="modal-footer border-top-0 justify-content-between">
                                                    <div class="text-muted small">Total Tagihan: <strong>Rp {{ number_format($p->pemesanan->total_harga, 0, ',', '.') }}</strong></div>
                                                    <button type="button" class="btn btn-custom btn-custom-outline py-1 px-3" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
