@extends('layout')
@section('title', 'Kategori Surat - Kelurahan Karangduren')
@section('content')
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-2"><i class="bi bi-tags-fill text-success me-3"></i>Kategori Surat</h1>
                    <p class="text-muted mb-0">Kelola kategori-kategori surat yang tersedia dalam sistem arsip</p>
                </div>
                <a href="{{ route('categories.create') }}" class="btn btn-success btn-lg shadow-sm">
                    <i class="bi bi-plus-circle-fill me-2"></i>Tambah Kategori Baru
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0">
        <div class="card-header bg-light text-dark">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-search me-2"></i>Pencarian & Daftar Kategori</h5>
                <span class="badge">{{ $categories->total() }} kategori ditemukan</span>
            </div>
        </div>
        <div class="card-body">
            <form class="d-flex mb-4" method="get" action="{{ route('categories.index') }}">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0"
                           placeholder="Cari berdasarkan nama kategori atau keterangan..."
                           value="{{ $search ?? '' }}">
                    <button class="btn btn-success d-flex align-items-center" type="submit">
                        <i class="bi bi-search me-2"></i>Cari Kategori
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 fw-semibold"><i class="bi bi-hash me-2 text-primary"></i>ID Kategori</th>
                            <th class="border-0 fw-semibold"><i class="bi bi-tag-fill me-2 text-success"></i>Nama Kategori</th>
                            <th class="border-0 fw-semibold"><i class="bi bi-card-text me-2 text-info"></i>Keterangan</th>
                            <th class="border-0 fw-semibold text-center"><i class="bi bi-gear me-2 text-secondary"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr class="border-bottom border-light">
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary bg-opacity-25 text-primary border border-primary border-opacity-50 px-3 py-2 fw-semibold">
                                        #{{ $cat->id }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="bi bi-tag-fill text-success"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $cat->name }}</div>
                                        <small class="text-muted">{{ $cat->description ?? 'Tidak ada keterangan' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $cat->description ?? '-' }}</div>
                                <small class="text-muted">Kategori untuk mengorganisir surat</small>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1 gap-md-2 flex-wrap">
                                    <a href="{{ route('categories.edit', $cat) }}" class="btn btn-outline-primary btn-sm d-flex align-items-center" title="Edit Kategori">
                                        <i class="bi bi-pencil-square me-1"></i><span class="d-none d-sm-inline">Edit</span>
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm d-flex align-items-center" onclick="confirmDelete({{ $cat->id }})" title="Hapus Kategori">
                                        <i class="bi bi-trash-fill me-1"></i><span class="d-none d-sm-inline">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-tags display-1 text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada kategori surat</h5>
                                    <p class="text-muted mb-4">Mulai tambahkan kategori pertama untuk mengorganisir surat dengan lebih baik.</p>
                                    <a href="{{ route('categories.create') }}" class="btn btn-success">
                                        <i class="bi bi-plus-circle-fill me-2"></i>Tambah Kategori Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $categories->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light border-bottom-0">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="bi bi-trash-fill text-danger display-4 opacity-50"></i>
                </div>
                <h6 class="mb-3">Apakah Anda yakin ingin menghapus kategori ini?</h6>
                <p class="text-muted mb-0">Kategori yang dihapus tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer border-top-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-danger" id="deleteConfirmBtn">
                    <i class="bi bi-trash-fill me-2"></i>Ya, Hapus Kategori
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let deleteId = null;
function confirmDelete(id) {
    deleteId = id;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
document.getElementById('deleteConfirmBtn').onclick = function() {
    if(deleteId) {
        const btn = this;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menghapus...';
        btn.disabled = true;

        fetch(`/categories/${deleteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert('Gagal menghapus kategori. Silakan coba lagi.');
            }
        })
        .catch(error => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    }
}
</script>
@endpush
@endsection
