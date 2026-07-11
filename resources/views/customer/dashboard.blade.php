@extends('layouts.app')

@section('title', 'Dashboard Customer - BERKAH ALAM')

@section('content')
<div class="container py-5" style="margin-top: 20px;">
    <!-- Welcome Header -->
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h1 class="fw-bold mb-1">Halo, {{ Auth::user()->name }}!</h1>
            <p class="text-secondary mb-0">Selamat datang di dashboard pemesanan Berkah Alam. Pantau pesanan Anda di sini.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('customer.profile') }}" class="btn btn-stone-outline py-2 px-4">
                <i class="bi bi-person me-2"></i>Edit Profil
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="premium-card p-4 text-center">
                <div class="text-stone-accent mb-2"><i class="bi bi-cart fs-1"></i></div>
                <h3 class="fw-bold mb-1">{{ $stats['total_orders'] }}</h3>
                <p class="text-muted small mb-0">Total Pesanan</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="premium-card p-4 text-center">
                <div class="text-warning mb-2"><i class="bi bi-hourglass-split fs-1"></i></div>
                <h3 class="fw-bold mb-1">{{ $stats['pending'] }}</h3>
                <p class="text-muted small mb-0">Menunggu Pembayaran</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="premium-card p-4 text-center">
                <div class="text-primary mb-2"><i class="bi bi-gear fs-1"></i></div>
                <h3 class="fw-bold mb-1">{{ $stats['processed'] }}</h3>
                <p class="text-muted small mb-0">Sedang Diproses</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="premium-card p-4 text-center">
                <div class="text-success mb-2"><i class="bi bi-check-circle fs-1"></i></div>
                <h3 class="fw-bold mb-1">{{ $stats['completed'] }}</h3>
                <p class="text-muted small mb-0">Pesanan Selesai</p>
            </div>
        </div>
    </div>

    <!-- Order History -->
    <div class="premium-card p-5">
        <h4 class="fw-bold mb-4"><i class="bi bi-clock-history me-2"></i>Riwayat Pemesanan</h4>

        @if($orders->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-cart-x fs-1 text-muted mb-3 d-block"></i>
                <p class="text-secondary mb-3">Anda belum melakukan pemesanan produk batu alam.</p>
                <a href="{{ route('home') }}#produk" class="btn btn-stone-accent">Lihat Koleksi Produk</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-muted border-bottom" style="font-size: 0.9rem;">
                            <th>Order ID</th>
                            <th>Tanggal</th>
                            <th>Detail Produk</th>
                            <th>Total Biaya</th>
                            <th>Status Pesanan</th>
                            <th>Bukti Pembayaran</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="border-bottom">
                                <td><span class="fw-semibold">#BA-{{ $order->id }}</span></td>
                                <td class="text-muted small">{{ $order->tanggal }}</td>
                                <td>
                                    @foreach($order->detailPesanan as $detail)
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bi bi-gem text-stone-accent me-2"></i>
                                            <span>{{ $detail->produk->nama }} (x{{ $detail->qty }})</span>
                                        </div>
                                        @if($detail->catatan_ukiran)
                                            <div class="bg-light p-2 rounded mt-1 small" style="font-size: 0.8rem; border-left: 2px solid var(--accent-color);">
                                                <strong>Ukiran:</strong> {{ $detail->catatan_ukiran }}
                                            </div>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <span class="fw-bold text-stone-accent">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    @if($order->status === 'pending')
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending</span>
                                    @elseif($order->status === 'diverifikasi')
                                        <span class="badge bg-info text-white px-3 py-2 rounded-pill">Diverifikasi</span>
                                    @elseif($order->status === 'diproses')
                                        <span class="badge bg-primary text-white px-3 py-2 rounded-pill">Diproses</span>
                                    @elseif($order->status === 'selesai')
                                        <span class="badge bg-success text-white px-3 py-2 rounded-pill">Selesai</span>
                                    @elseif($order->status === 'ditolak')
                                        <span class="badge bg-danger text-white px-3 py-2 rounded-pill">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->pembayaran)
                                        @if($order->pembayaran->status === 'pending')
                                            <span class="text-warning small"><i class="bi bi-clock me-1"></i> Menunggu Verifikasi</span>
                                        @elseif($order->pembayaran->status === 'diverifikasi')
                                            <span class="text-success small"><i class="bi bi-patch-check-fill me-1"></i> Pembayaran Sah</span>
                                        @elseif($order->pembayaran->status === 'ditolak')
                                            <span class="text-danger small"><i class="bi bi-x-circle-fill me-1"></i> Ditolak</span>
                                        @endif
                                    @else
                                        <span class="text-muted small"><i class="bi bi-exclamation-triangle me-1"></i> Belum Bayar</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-stone-outline btn-sm py-2 px-3" data-bs-toggle="modal" data-bs-target="#editOrderCustomerModal{{ $order->id }}">
                                            <i class="bi bi-pencil me-1"></i> Edit
                                        </button>
                                        @if($order->status === 'pending' && (!$order->pembayaran || $order->pembayaran->status === 'ditolak'))
                                            <a href="{{ route('customer.pembayaran', $order->id) }}" class="btn btn-stone-accent btn-sm py-2 px-3">
                                                <i class="bi bi-upload me-1"></i> Bayar
                                            </a>
                                        @else
                                            <button class="btn btn-stone-outline btn-sm py-2 px-3" disabled>
                                                <i class="bi bi-check-lg"></i> OK
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Edit Order Customer Modals (placed outside cards/tables to avoid clipping bugs) -->
    @foreach($orders as $order)
        <div class="modal fade" id="editOrderCustomerModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="modal-header border-bottom border-light">
                        <h5 class="modal-title fw-bold text-dark">Edit Pesanan #BA-{{ $order->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('customer.pesanan.update', $order->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body py-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label text-muted small fw-semibold">Alamat Pengiriman</label>
                                    <textarea name="alamat" class="form-control py-2 text-dark" rows="3" required style="background-color: rgba(0, 0, 0, 0.03) !important; border: 1px solid rgba(0,0,0,0.1) !important;">{{ $order->alamat ?: ($order->user->address ?: '') }}</textarea>
                                </div>
                                
                                <div class="col-12 mt-4">
                                    <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-box-seam me-2 text-stone-accent"></i>Item & Teks Ukiran</h6>
                                    @foreach($order->detailPesanan as $detail)
                                        <div class="p-3 rounded-3 mb-2 border" style="background: rgba(0, 0, 0, 0.02);">
                                            <div class="row g-3 align-items-center">
                                                <div class="col-md-6">
                                                    <span class="fw-semibold text-dark">{{ $detail->produk->nama }}</span>
                                                    <span class="d-block text-muted small">Harga Satuan: Rp {{ number_format($detail->harga, 0, ',', '.') }}</span>
                                                    <input type="hidden" name="details[{{ $loop->index }}][id]" value="{{ $detail->id }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-muted small fw-semibold mb-1">Jumlah Pemesanan (Qty)</label>
                                                    <input type="number" name="details[{{ $loop->index }}][qty]" class="form-control py-1 px-2 text-dark" value="{{ $detail->qty }}" required min="1" style="max-width: 100px; background-color: rgba(0, 0, 0, 0.03) !important; border: 1px solid rgba(0,0,0,0.1) !important;">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label text-muted small fw-semibold mb-1">Teks Catatan Ukiran (Nisan / Prasasti)</label>
                                                    <textarea name="details[{{ $loop->index }}][catatan_ukiran]" class="form-control py-1 px-2 text-dark" rows="2" style="background-color: rgba(0, 0, 0, 0.03) !important; border: 1px solid rgba(0,0,0,0.1) !important;">{{ $detail->catatan_ukiran }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top border-light">
                            <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-stone-accent px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
