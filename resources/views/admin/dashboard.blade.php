@extends('admin.layouts.admin')

@section('title', 'Admin Dashboard - BERKAH ALAM')

@section('content')
    <!-- Dashboard Stats Header -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-sm-6">
            <div class="admin-card text-center py-4 mb-0">
                <span class="text-muted small fw-semibold d-block mb-1">TOTAL PENDAPATAN</span>
                <h3 class="fw-bold text-stone-accent mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>  
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="admin-card text-center py-4 mb-0">
                <span class="text-muted small fw-semibold d-block mb-1">JUMLAH PESANAN</span>
                <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="admin-card text-center py-4 mb-0">
                <span class="text-muted small fw-semibold d-block mb-1">JUMLAH PRODUK</span>
                <h3 class="fw-bold mb-0">{{ $totalProducts }}</h3>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="admin-card text-center py-4 mb-0">
                <span class="text-muted small fw-semibold d-block mb-1">CUSTOMER TERDAFTAR</span>
                <h3 class="fw-bold mb-0">{{ $totalCustomers }}</h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Status Distribution -->
        <div class="col-lg-4">
            <div class="admin-card h-100 mb-0">
                <h5 class="fw-bold mb-4">Status Pemesanan</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="bi bi-hourglass-split text-warning me-2"></i> Pending (Belum Bayar)</span>
                        <span class="badge bg-warning text-dark rounded-pill px-3">{{ $statusCounts['pending'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="bi bi-shield-check text-info me-2"></i> Diverifikasi (Lunas)</span>
                        <span class="badge bg-info text-white rounded-pill px-3">{{ $statusCounts['diverifikasi'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="bi bi-gear-fill text-primary me-2"></i> Diproses (Dipahat)</span>
                        <span class="badge bg-primary text-white rounded-pill px-3">{{ $statusCounts['diproses'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="bi bi-check-circle-fill text-success me-2"></i> Selesai (Kirim/Diambil)</span>
                        <span class="badge bg-success text-white rounded-pill px-3">{{ $statusCounts['selesai'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="bi bi-x-circle-fill text-danger me-2"></i> Ditolak</span>
                        <span class="badge bg-danger text-white rounded-pill px-3">{{ $statusCounts['ditolak'] }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="col-lg-8">
            <div class="admin-card h-100 mb-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Transaksi Terbaru</h5>
                    <a href="{{ route('admin.pesanan.index') }}" class="btn btn-sm btn-outline-secondary py-1 px-3">Lihat Semua</a>
                </div>

                @if($recentOrders->isEmpty())
                    <p class="text-muted text-center py-5 mb-0">Belum ada transaksi pemesanan masuk.</p>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr class="text-muted">
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td><span class="fw-semibold">#BA-{{ $order->id }}</span></td>
                                        <td>{{ $order->user->name }}</td>
                                        <td><span class="fw-semibold text-dark">Rp {{ number_format($order->total, 0, ',', '.') }}</span></td>
                                        <td>
                                            @if($order->status === 'pending')
                                                <span class="badge bg-warning text-dark px-2 py-1">Pending</span>
                                            @elseif($order->status === 'diverifikasi')
                                                <span class="badge bg-info px-2 py-1">Diverifikasi</span>
                                            @elseif($order->status === 'diproses')
                                                <span class="badge bg-primary px-2 py-1">Diproses</span>
                                            @elseif($order->status === 'selesai')
                                                <span class="badge bg-success px-2 py-1">Selesai</span>
                                            @elseif($order->status === 'ditolak')
                                                <span class="badge bg-danger px-2 py-1">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.pesanan.show', $order->id) }}" class="btn btn-sm btn-stone-dark py-1 px-3">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
