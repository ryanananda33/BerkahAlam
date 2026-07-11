@extends('admin.layouts.admin')

@section('title', 'Kelola Produk - BERKAH ALAM')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Kelola Produk Batu Alam</h3>
            <p class="text-secondary mb-0">Atur katalog produk, harga, stok, dan deskripsi.</p>
        </div>
        <button type="button" class="btn btn-stone-admin" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah Produk
        </button>
    </div>

    <!-- Product List Card -->
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table align-middle" id="productsTable">
                <thead>
                    <tr class="text-muted border-bottom">
                        <th style="width: 80px;">Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th class="text-end" style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="border-bottom">
                            <td>
                                @if($product->gambar)
                                    <img src="{{ asset($product->gambar) }}" class="rounded-3" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $product->nama }}">
                                @else
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px;">
                                        <i class="bi bi-box"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold text-dark d-block">{{ $product->nama }}</span>
                                <span class="text-muted small">{{ Str::limit($product->deskripsi, 60) }}</span>
                            </td>
                            <td><span class="badge bg-light text-dark border px-3 py-2">{{ $product->kategori->nama }}</span></td>
                            <td><span class="fw-bold text-dark">Rp {{ number_format($product->harga, 0, ',', '.') }}</span></td>
                            <td>
                                @if($product->stok > 0)
                                    <span class="badge bg-success-subtle text-success px-3 py-2">{{ $product->stok }} Pcs</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2">Habis</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-3 me-1" 
                                        data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-3">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Edit Product Modals (placed outside table container to avoid backdrop freeze issue) -->
    @foreach($products as $product)
        <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title fw-bold">Edit Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('admin.produk.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body py-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">Nama Produk</label>
                                    <input type="text" name="nama" class="form-control py-2" value="{{ $product->nama }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">Kategori</label>
                                    <select name="kategori_id" class="form-select py-2" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $product->kategori_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">Harga (Rupiah)</label>
                                    <input type="number" name="harga" class="form-control py-2" value="{{ (int) $product->harga }}" required min="0">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">Stok</label>
                                    <input type="number" name="stok" class="form-control py-2" value="{{ $product->stok }}" required min="0">
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted small fw-semibold">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control py-2" rows="3">{{ $product->deskripsi }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted small fw-semibold">Ganti Gambar Produk (Maks 10MB)</label>
                                    <input type="file" name="gambar" class="form-control py-2" accept="image/*">
                                    @if($product->gambar)
                                        <div class="mt-2">
                                            <span class="d-block small text-muted mb-1">Gambar saat ini:</span>
                                            <img src="{{ asset($product->gambar) }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top">
                            <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-stone-admin">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Nama Produk</label>
                                <input type="text" name="nama" class="form-control py-2" placeholder="Contoh: Nisan Granit Hitam 30x40" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Kategori</label>
                                <select name="kategori_id" class="form-select py-2" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Harga (Rupiah)</label>
                                <input type="number" name="harga" class="form-control py-2" placeholder="Contoh: 1500000" required min="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Stok</label>
                                <input type="number" name="stok" class="form-control py-2" placeholder="Contoh: 10" required min="0">
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small fw-semibold">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control py-2" rows="3" placeholder="Masukkan spesifikasi produk, kelebihan bahan, jenis cat emas, dll..."></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small fw-semibold">Gambar Produk (Maks 10MB)</label>
                                <input type="file" name="gambar" class="form-control py-2" required accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-stone-admin">Tambah Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#productsTable').DataTable({
                "paging": false,
                "language": {
                    "search": "Cari:",
                    "info": "Menampilkan _TOTAL_ produk"
                }
            });

            // Confirm delete
            $('.delete-form').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Produk yang dihapus tidak dapat dipulihkan!",
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
