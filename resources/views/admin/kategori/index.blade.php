@extends('admin.layouts.admin')

@section('title', 'Kelola Kategori - BERKAH ALAM')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Kelola Kategori Produk</h3>
            <p class="text-secondary mb-0">Atur kategori untuk mengelompokkan produk batu alam.</p>
        </div>
        <button type="button" class="btn btn-stone-admin" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </button>
    </div>

    <!-- Category List Card -->
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table align-middle" id="categoriesTable">
                <thead>
                    <tr class="text-muted border-bottom">
                        <th style="width: 80px;">No</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Produk Terkait</th>
                        <th class="text-end" style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $index => $category)
                        <tr class="border-bottom">
                            <td>{{ $index + 1 }}</td>
                            <td><span class="fw-semibold text-dark">{{ $category->nama }}</span></td>
                            <td>
                                <span class="badge bg-light text-dark px-3 py-2 border">{{ $category->produk_count }} Produk</span>
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-3 me-1" 
                                        data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('admin.kategori.destroy', $category->id) }}" method="POST" class="d-inline delete-form">
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
    <!-- Edit Category Modals (placed outside table container to avoid backdrop freeze issue) -->
    @foreach($categories as $category)
        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title fw-bold">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('admin.kategori.update', $category->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body py-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">Nama Kategori</label>
                                <input type="text" name="nama" class="form-control py-2" value="{{ $category->nama }}" required>
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

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.kategori.store') }}">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-semibold">Nama Kategori</label>
                            <input type="text" name="nama" class="form-control py-2" placeholder="Contoh: Nisan Kristen, Prasasti Granit" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-stone-admin">Tambah Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#categoriesTable').DataTable({
                "paging": false,
                "language": {
                    "search": "Cari:",
                    "info": "Menampilkan _TOTAL_ kategori"
                }
            });

            // Confirm delete
            $('.delete-form').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Kategori yang dihapus tidak dapat dipulihkan!",
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
