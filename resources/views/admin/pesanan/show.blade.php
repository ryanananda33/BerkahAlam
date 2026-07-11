@extends('admin.layouts.admin')

@section('title', 'Detail Pesanan #BA-' . $order->id . ' - BERKAH ALAM')

@section('content')
    <!-- Back and Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.pesanan.index') }}" class="btn btn-sm btn-outline-secondary py-2 px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Pesanan
        </a>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-outline-secondary py-2 px-3" data-bs-toggle="modal" data-bs-target="#editOrderModal{{ $order->id }}">
                <i class="bi bi-pencil me-1"></i> Edit Pesanan
            </button>
            <a href="{{ route('admin.pesanan.export-pdf', $order->id) }}" class="btn btn-sm btn-stone-admin py-2 px-3">
                <i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF / Invoice
            </a>
            <form action="{{ route('admin.pesanan.destroy', $order->id) }}" method="POST" class="d-inline delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger py-2 px-3">
                    <i class="bi bi-trash me-1"></i> Hapus Pesanan
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <!-- Order Details and Customer Info -->
        <div class="col-lg-7">
            <!-- Products Ordered -->
            <div class="admin-card mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-box me-2 text-stone-accent"></i>Produk yang Dipesan</h5>
                
                @foreach($order->detailPesanan as $detail)
                    <div class="d-flex align-items-start border-bottom pb-3 mb-3">
                        @if($detail->produk->gambar)
                            <img src="{{ asset($detail->produk->gambar) }}" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center text-muted" style="width: 80px; height: 80px;">
                                <i class="bi bi-box"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1">{{ $detail->produk->nama }}</h6>
                            <span class="text-muted small d-block">Harga Satuan: Rp {{ number_format($detail->harga, 0, ',', '.') }}</span>
                            <span class="text-muted small d-block">Jumlah: {{ $detail->qty }} Pcs</span>
                            
                            @if($detail->catatan_ukiran)
                                <div class="bg-light p-3 rounded mt-2 small" style="border-left: 3px solid var(--accent-color);">
                                    <strong><i class="bi bi-pencil-fill me-1"></i> Teks Ukiran:</strong>
                                    <pre class="mb-0 mt-1" style="font-family: inherit; white-space: pre-wrap;">{{ $detail->catatan_ukiran }}</pre>
                                </div>
                            @endif
                        </div>
                        <div class="text-end">
                            <span class="fw-bold text-dark fs-5">Rp {{ number_format($detail->harga * $detail->qty, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-between align-items-center pt-2">
                    <span class="fw-semibold">Total Tagihan:</span>
                    <span class="fw-bold text-stone-accent fs-4">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Customer Shipping Info -->
            <div class="admin-card">
                <h5 class="fw-bold mb-3"><i class="bi bi-person me-2 text-stone-accent"></i>Informasi Customer</h5>
                <table class="table table-borderless align-middle mb-0" style="font-size: 0.95rem;">
                    <tr>
                        <td class="text-muted fw-semibold" style="width: 150px; padding: 6px 0;">Nama Lengkap</td>
                        <td style="padding: 6px 0;">{{ $order->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="padding: 6px 0;">Email</td>
                        <td style="padding: 6px 0;">{{ $order->user->email }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="padding: 6px 0;">No. WhatsApp</td>
                        <td style="padding: 6px 0;">
                            @if($order->user->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->user->phone) }}" target="_blank" class="text-decoration-none">
                                    {{ $order->user->phone }} <i class="bi bi-whatsapp text-success ms-1"></i>
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold" style="padding: 6px 0;">Alamat Pengiriman</td>
                        <td style="padding: 6px 0; line-height: 1.5;">{{ $order->alamat ?: ($order->user->address ?: '-') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Payment and Status Actions -->
        <div class="col-lg-5">
            <!-- Payment Proof Card -->
            <div class="admin-card mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-credit-card me-2 text-stone-accent"></i>Bukti Pembayaran</h5>
                
                @if($order->pembayaran)
                    <div class="mb-3">
                        <span class="text-muted small d-block mb-1">Tanggal Diunggah:</span>
                        <span class="fw-medium text-dark">{{ $order->pembayaran->tanggal_bayar }}</span>
                    </div>

                    <div class="mb-4">
                        <span class="text-muted small d-block mb-2">Foto Slip Transfer:</span>
                        <a href="{{ asset($order->pembayaran->bukti_pembayaran) }}" target="_blank" title="Klik untuk perbesar">
                            <img src="{{ asset($order->pembayaran->bukti_pembayaran) }}" class="img-fluid rounded border shadow-sm" style="max-height: 250px; object-fit: contain; width: 100%;">
                        </a>
                    </div>

                    @if($order->pembayaran->status === 'pending')
                        <div class="d-flex gap-2">
                            <form action="{{ route('admin.pesanan.verify', $order->id) }}" method="POST" class="flex-fill">
                                @csrf
                                <input type="hidden" name="action" value="verify">
                                <button type="submit" class="btn btn-success w-100 py-2">
                                    <i class="bi bi-check-lg"></i> Setujui Pembayaran
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.pesanan.verify', $order->id) }}" method="POST" class="flex-fill">
                                @csrf
                                <input type="hidden" name="action" value="reject">
                                <button type="submit" class="btn btn-danger w-100 py-2">
                                    <i class="bi bi-x-lg"></i> Tolak
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="p-3 bg-light rounded text-center">
                            @if($order->pembayaran->status === 'diverifikasi')
                                <span class="text-success fw-bold"><i class="bi bi-patch-check-fill me-1"></i> Pembayaran Diverifikasi (Sah)</span>
                            @else
                                <span class="text-danger fw-bold"><i class="bi bi-x-circle-fill me-1"></i> Pembayaran Ditolak</span>
                            @endif
                        </div>
                    @endif
                @else
                    <div class="alert alert-warning py-3 text-center mb-0" role="alert">
                        <i class="bi bi-exclamation-triangle fs-3 d-block mb-2"></i> Belum ada pembayaran masuk dari customer.
                    </div>
                @endif
            </div>

            <!-- Manage Order Status Card -->
            <div class="admin-card">
                <h5 class="fw-bold mb-3"><i class="bi bi-arrow-repeat me-2 text-stone-accent"></i>Status Pengerjaan</h5>
                
                <form action="{{ route('admin.pesanan.status', $order->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Ubah Status Pesanan</label>
                        <select name="status" class="form-select py-2">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diverifikasi" {{ $order->status === 'diverifikasi' ? 'selected' : '' }}>Diverifikasi (Pembayaran Diterima)</option>
                            <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>Diproses (Pemahatan)</option>
                            <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai (Kirim / Diambil)</option>
                            <option value="ditolak" {{ $order->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-stone-dark w-100 py-2">
                        Perbarui Status Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>

@section('modals')
    <!-- Edit Order Modal -->
    <div class="modal fade" id="editOrderModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form method="POST" action="{{ route('admin.pesanan.update', $order->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title fw-bold">Edit Pesanan #BA-{{ $order->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label text-muted small fw-semibold">Alamat Pengiriman</label>
                                <textarea name="alamat" class="form-control py-2 text-dark" rows="2" required>{{ $order->alamat ?: ($order->user->address ?: '') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-semibold">Total Tagihan (Rp)</label>
                                <input type="number" name="total" class="form-control py-2" value="{{ (int)$order->total }}" required min="0">
                            </div>
                            
                            <div class="col-12 mt-4">
                                <h6 class="fw-bold mb-2 text-dark">Item Produk & Teks Ukiran</h6>
                                @foreach($order->detailPesanan as $detail)
                                    <div class="p-3 bg-light rounded-3 mb-2 border">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-6">
                                                <span class="fw-semibold text-dark">{{ $detail->produk->nama }}</span>
                                                <input type="hidden" name="details[{{ $loop->index }}][id]" value="{{ $detail->id }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-muted small fw-semibold mb-1">Jumlah (Qty)</label>
                                                <input type="number" name="details[{{ $loop->index }}][qty]" class="form-control py-1 px-2 mb-2" value="{{ $detail->qty }}" required min="1" style="max-width: 100px;">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label text-muted small fw-semibold mb-1">Teks Catatan Ukiran</label>
                                                <textarea name="details[{{ $loop->index }}][catatan_ukiran]" class="form-control py-1 px-2" rows="2">{{ $detail->catatan_ukiran }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-stone-admin">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Confirm delete
            $('.delete-form').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Pesanan ini beserta data pembayaran akan terhapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#5F5F5F',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endsection
