@extends('layout')
@section('title', 'Detail Arsip Surat - Kelurahan Karangduren')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Header Section -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-light text-dark">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-text-fill me-3 fs-4"></i>
                        <div>
                            <h4 class="mb-0">Detail Arsip Surat</h4>
                            <small class="opacity-75">{{ $letter->number }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Detail Information -->
                <div class="col-lg-4">
                    <div class="card shadow-lg border-0 h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-primary">
                                <i class="bi bi-info-circle-fill me-2"></i>Informasi Surat
                            </h5>
                        </div>
                        <div class="card-body p-3">
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-hash text-primary me-3 fs-5"></i>
                                    <div>
                                        <label class="form-label fw-semibold mb-0 text-muted small">Nomor Surat</label>
                                        <p class="mb-0 fw-bold fs-6">{{ $letter->number }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-tags text-success me-3 fs-5"></i>
                                    <div>
                                        <label class="form-label fw-semibold mb-0 text-muted small">Kategori</label>
                                        <p class="mb-0">
                                            <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 px-3 py-2">
                                                <i class="bi bi-tag-fill me-1"></i>{{ $letter->category->name ?? 'Tidak Berkategori' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-card-text text-info me-3 fs-5"></i>
                                    <div class="flex-grow-1">
                                        <label class="form-label fw-semibold mb-0 text-muted small">Judul Surat</label>
                                        <p class="mb-0 fw-semibold">{{ $letter->title }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-clock-history text-warning me-3 fs-5"></i>
                                    <div>
                                        <label class="form-label fw-semibold mb-0 text-muted small">Waktu Pengarsipan</label>
                                        <p class="mb-0">
                                            <span class="fw-semibold">{{ $letter->archived_at->format('d M Y') }}</span><br>
                                            <small class="text-muted">{{ $letter->archived_at->format('H:i:s') }}</small>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-0">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-file-earmark-pdf text-danger me-3 fs-5"></i>
                                    <div class="flex-grow-1">
                                        <label class="form-label fw-semibold mb-0 text-muted small">File</label>
                                        <p class="mb-0">
                                            <span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-50">
                                                <i class="bi bi-file-earmark-pdf-fill me-1"></i>{{ basename($letter->file_path) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PDF Preview -->
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 h-100">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="bi bi-eye-fill me-2"></i>Preview Surat
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm" onclick="toggleFullscreen()">
                                    <i class="bi bi-arrows-fullscreen"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="pdf-container bg-light" style="height: 500px; overflow: hidden;">
                                <iframe id="pdfViewer" src="{{ asset('storage/' . $letter->file_path) }}"
                                        width="100%" height="100%" style="border: none;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card shadow-lg border-0 mt-4">
                <div class="card-body">
                    <!-- Desktop Layout -->
                    <div class="d-none d-md-block">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('letters.index') }}" class="btn btn-outline-secondary btn-lg w-100">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Surat
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('letters.edit', $letter) }}" class="btn btn-warning btn-lg flex-fill">
                                        <i class="bi bi-pencil-square me-2"></i>Edit Surat
                                    </a>
                                    <a href="{{ route('letters.download', $letter) }}" class="btn btn-success btn-lg flex-fill">
                                        <i class="bi bi-download me-2"></i>Unduh PDF
                                    </a>
                                    <button class="btn btn-danger btn-lg" onclick="confirmDelete()">
                                        <i class="bi bi-trash-fill me-2"></i>Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Layout -->
                    <div class="d-md-none">
                        <div class="d-grid gap-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="{{ route('letters.edit', $letter) }}" class="btn btn-warning btn-lg w-100">
                                        <i class="bi bi-pencil-square me-2"></i>Edit
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('letters.download', $letter) }}" class="btn btn-success btn-lg w-100">
                                        <i class="bi bi-download me-2"></i>Unduh
                                    </a>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="{{ route('letters.index') }}" class="btn btn-outline-secondary btn-lg w-100">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali
                                    </a>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-danger btn-lg w-100" onclick="confirmDelete()">
                                        <i class="bi bi-trash-fill me-2"></i>Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light border-bottom-0">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus Surat
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="bi bi-trash-fill text-danger display-4 opacity-50"></i>
                </div>
                <h6 class="mb-3">Apakah Anda yakin ingin menghapus surat ini?</h6>
                <p class="text-muted mb-0">Surat <strong>"{{ $letter->title }}"</strong> akan dihapus secara permanen.</p>
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
let deleteId = {{ $letter->id }};

function confirmDelete() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

document.getElementById('deleteConfirmBtn').onclick = function() {
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
            location.href = '{{ route("letters.index") }}';
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

function toggleFullscreen() {
    const container = document.querySelector('.pdf-container');
    if (!document.fullscreenElement) {
        container.requestFullscreen().catch(err => {
            alert('Tidak dapat masuk mode fullscreen');
        });
    } else {
        document.exitFullscreen();
    }
}
</script>
@endpush
@endsection
