@extends('admin.layouts.admin')

@section('title', 'Hero Banner CMS - BERKAH ALAM')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">CMS Hero & Tentang Kami</h3>
            <p class="text-secondary mb-0">Atur banner utama dan gambar seksi 'Tentang Kami' di halaman depan website.</p>
        </div>
        @if($heroes->isEmpty())
            <button type="button" class="btn btn-stone-admin" data-bs-toggle="modal" data-bs-target="#addHeroModal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Hero Banner
            </button>
        @endif
    </div>

    <!-- Hero Banner List Card -->
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table align-middle" id="heroesTable">
                <thead>
                    <tr class="text-muted border-bottom">
                        <th style="width: 120px;">Gambar</th>
                        <th>Judul Utama</th>
                        <th>Subjudul</th>
                        <th class="text-end" style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($heroes as $hero)
                        <tr class="border-bottom">
                            <td>
                                @if($hero->gambar)
                                    <img src="{{ asset($hero->gambar) }}" class="rounded" style="width: 100px; height: 60px; object-fit: cover;" alt="Hero Image">
                                @endif
                            </td>
                            <td><span class="fw-semibold text-dark">{!! $hero->judul !!}</span></td>
                            <td><span class="text-muted small">{{ $hero->subjudul }}</span></td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-3 me-1" 
                                        data-bs-toggle="modal" data-bs-target="#editHeroModal{{ $hero->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('admin.hero.destroy', $hero->id) }}" method="POST" class="d-inline delete-form">
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
    <!-- Edit Hero Modals (placed outside table container to avoid backdrop freeze issue) -->
    @foreach($heroes as $hero)
        <div class="modal fade" id="editHeroModal{{ $hero->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title fw-bold">Edit Hero Banner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('admin.hero.update', $hero->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body py-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">Judul Utama (Gunakan span untuk warna emas)</label>
                                <input type="text" name="judul" class="form-control py-2" value="{{ $hero->judul }}" required>
                                <span class="form-text text-muted" style="font-size: 0.75rem;">Contoh: BERKAH &lt;span&gt;ALAM&lt;/span&gt;</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">Subjudul</label>
                                <input type="text" name="subjudul" class="form-control py-2" value="{{ $hero->subjudul }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">Ganti Gambar Latar Hero Banner</label>
                                <input type="file" name="gambar" class="form-control py-2" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">Ganti Gambar "Tentang Kami"</label>
                                <input type="file" name="tentang_gambar" class="form-control py-2" accept="image/*">
                                @if($hero->tentang_gambar)
                                    <div class="mt-2">
                                        <span class="d-block small text-muted mb-1">Gambar "Tentang Kami" saat ini:</span>
                                        <img src="{{ asset($hero->tentang_gambar) }}" class="rounded" style="width: 100px; height: 60px; object-fit: cover;">
                                    </div>
                                @endif
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

    <!-- Add Hero Modal -->
    <div class="modal fade" id="addHeroModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Tambah Hero Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.hero.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-semibold">Judul Utama</label>
                            <input type="text" name="judul" class="form-control py-2" placeholder="BERKAH <span>ALAM</span>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-semibold">Subjudul</label>
                            <input type="text" name="subjudul" class="form-control py-2" placeholder="Menghadirkan nisan marmer berkualitas..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-semibold">Gambar Background (Maks 10MB)</label>
                            <input type="file" name="gambar" class="form-control py-2" required accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-semibold">Gambar "Tentang Kami" (Maks 10MB)</label>
                            <input type="file" name="tentang_gambar" class="form-control py-2" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-stone-admin">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        $(document).ready(function() {
            // Confirm delete
            $('.delete-form').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Gambar banner akan terhapus secara permanen!",
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
