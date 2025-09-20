@extends('layout')
@section('title', 'Arsip Surat - Kelurahan Karangduren')
@section('content')
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-2"><i class="bi bi-archive-fill text-primary me-3"></i>Arsip Surat</h1>
                    <p class="text-muted mb-0">Kelola dan cari surat-surat resmi yang telah diarsipkan di sistem</p>
                </div>
                <a href="{{ route('letters.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-plus-circle-fill me-2"></i>Arsipkan Surat Baru
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
                <h5 class="mb-0"><i class="bi bi-search me-2"></i>Pencarian & Daftar Surat</h5>
                <span class="badge">{{ $letters->total() }} surat ditemukan</span>
            </div>
        </div>
        <div class="card-body">
            <form class="d-flex mb-4" method="get" action="{{ route('letters.index') }}">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0"
                           placeholder="Cari berdasarkan nomor surat, judul, atau kategori..."
                           value="{{ $search ?? '' }}">
                    <button class="btn btn-primary d-flex align-items-center" type="submit">
                        <i class="bi bi-search me-2"></i>Cari Surat
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 fw-semibold"><i class="bi bi-hash me-2 text-primary"></i>Nomor Surat</th>
                            <th class="border-0 fw-semibold"><i class="bi bi-tags me-2 text-success"></i>Kategori</th>
                            <th class="border-0 fw-semibold"><i class="bi bi-card-text me-2 text-info"></i>Judul Surat</th>
                            <th class="border-0 fw-semibold"><i class="bi bi-clock-history me-2 text-warning"></i>Waktu Pengarsipan</th>
                            <th class="border-0 fw-semibold text-center"><i class="bi bi-gear me-2 text-secondary"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($letters as $letter)
                        <tr class="border-bottom border-light">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="bi bi-file-earmark-text text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $letter->number }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 px-3 py-2">
                                    <i class="bi bi-tag-fill me-1"></i>{{ $letter->category->name ?? 'Tidak Berkategori' }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $letter->title }}</div>
                                <small class="text-muted">{{ Str::limit($letter->description ?? '', 50) }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar-event text-warning me-2"></i>
                                    <div>
                                        <div class="fw-semibold">{{ $letter->archived_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $letter->archived_at->format('H:i') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1 gap-md-2 flex-wrap">
                                    <a href="{{ route('letters.show', $letter) }}" class="btn btn-outline-info btn-sm d-flex align-items-center" title="Lihat Detail">
                                        <i class="bi bi-eye-fill me-1"></i><span class="d-none d-sm-inline">Lihat</span>
                                    </a>
                                    <a href="{{ route('letters.download', $letter) }}" class="btn btn-outline-success btn-sm d-flex align-items-center" title="Unduh PDF">
                                        <i class="bi bi-download me-1"></i><span class="d-none d-sm-inline">Unduh</span>
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm d-flex align-items-center" onclick="confirmDelete({{ $letter->id }})" title="Hapus Surat">
                                        <i class="bi bi-trash-fill me-1"></i><span class="d-none d-sm-inline">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada surat diarsipkan</h5>
                                    <p class="text-muted mb-4">Mulai arsipkan surat pertama Anda untuk mengelola dokumen dengan lebih baik.</p>
                                    <a href="{{ route('letters.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle-fill me-2"></i>Arsipkan Surat Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($letters->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $letters->links() }}
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
                <h6 class="mb-3">Apakah Anda yakin ingin menghapus surat ini?</h6>
                <p class="text-muted mb-0">Tindakan ini akan menghapus surat secara permanen dan tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer border-top-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-danger" id="deleteConfirmBtn">
                    <i class="bi bi-trash-fill me-2"></i>Ya, Hapus Surat
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let deleteId = null;

    window.confirmDelete = function(id) {
        deleteId = id;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    };

    document.getElementById('deleteConfirmBtn').addEventListener('click', function() {
        if(deleteId) {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menghapus...';
            btn.disabled = true;

            fetch(`/letters/${deleteId}`, {
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
                    alert('Gagal menghapus surat. Silakan coba lagi.');
                }
            })
            .catch(error => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }
    });
});
</script>
@endpush
@endsection
