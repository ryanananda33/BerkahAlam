@extends('admin.layouts.admin')

@section('title', 'Kelola Pesanan - BERKAH ALAM')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Kelola Pesanan & Pembayaran</h3>
        <p class="text-secondary mb-0">Verifikasi transfer pembayaran dari customer dan update status pengerjaan.</p>
    </div>

    <!-- Orders List Card -->
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table align-middle" id="ordersTable">
                <thead>
                    <tr class="text-muted border-bottom">
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Total Tagihan</th>
                        <th>Status Pesanan</th>
                        <th>Status Pembayaran</th>
                        <th class="text-end" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-bottom">
                            <td><span class="fw-semibold">#BA-{{ $order->id }}</span></td>
                            <td class="text-muted small">{{ $order->tanggal }}</td>
                            <td>
                                <span class="fw-bold text-dark d-block">{{ $order->user->name }}</span>
                                <span class="text-muted small">{{ $order->user->phone ?: 'No HP kosong' }}</span>
                            </td>
                            <td><span class="fw-bold text-dark">Rp {{ number_format($order->total, 0, ',', '.') }}</span></td>
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
                                    <span class="text-muted small"><i class="bi bi-exclamation-triangle me-1"></i> Belum Mengunggah</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1 align-items-center">
                                    <a href="{{ route('admin.pesanan.export-pdf', $order->id) }}" class="btn btn-sm btn-outline-danger py-2 px-2" title="Ekspor PDF">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-secondary py-2 px-3" data-bs-toggle="modal" data-bs-target="#editOrderModal{{ $order->id }}">
                                        Edit
                                    </button>
                                    <a href="{{ route('admin.pesanan.show', $order->id) }}" class="btn btn-sm btn-stone-dark py-2 px-3">
                                        Kelola <i class="bi bi-chevron-right ms-1"></i>
                                    </a>
                                    <form action="{{ route('admin.pesanan.destroy', $order->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-2 px-3">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@section('modals')
    <!-- Edit Order Modals (placed in modals section at root of body to avoid backdrop and click bugs) -->
    @foreach($orders as $order)
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
    @endforeach
@endsection
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#ordersTable').DataTable({
                "paging": false,
                "order": [[0, "desc"]],
                "language": {
                    "search": "Cari:",
                    "info": "Menampilkan _TOTAL_ pesanan"
                }
            });

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
