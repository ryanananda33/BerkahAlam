@extends('admin.layouts.admin')

@section('title', 'Data Customer - BERKAH ALAM')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Daftar Customer Terdaftar</h3>
        <p class="text-secondary mb-0">Lihat data profil customer yang terdaftar dalam sistem pemesanan.</p>
    </div>

    <!-- Customer List Card -->
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table align-middle" id="customersTable">
                <thead>
                    <tr class="text-muted border-bottom">
                        <th>No</th>
                        <th>Nama Customer</th>
                        <th>Email</th>
                        <th>No Telepon</th>
                        <th>Alamat Pengiriman</th>
                        <th>Jumlah Pesanan</th>
                        <th>Terdaftar Sejak</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $index => $customer)
                        <tr class="border-bottom">
                            <td>{{ $index + 1 }}</td>
                            <td><span class="fw-semibold text-dark">{{ $customer->name }}</span></td>
                            <td>{{ $customer->email }}</td>
                            <td>
                                @if($customer->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->phone) }}" target="_blank" class="text-decoration-none">
                                        {{ $customer->phone }} <i class="bi bi-whatsapp text-success ms-1"></i>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td><span class="small text-muted">{{ Str::limit($customer->address, 60) ?: '-' }}</span></td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 py-2">{{ $customer->pesanan_count }} Pesanan</span>
                            </td>
                            <td class="text-muted small">{{ $customer->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#customersTable').DataTable({
                "paging": false,
                "language": {
                    "search": "Cari:",
                    "info": "Menampilkan _TOTAL_ customer"
                }
            });
        });
    </script>
@endsection
