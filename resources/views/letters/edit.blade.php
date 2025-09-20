@extends('layout')
@section('title', 'Edit Arsip Surat - Kelurahan Karangduren')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-light text-dark">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-pencil-square me-3 fs-4"></i>
                        <div>
                            <h4 class="mb-0">Edit Arsip Surat</h4>
                            <small class="opacity-75">Perbarui informasi surat yang telah diarsipkan</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('letters.update', $letter) }}" enctype="multipart/form-data" id="letterForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="number" id="number" class="form-control @error('number') is-invalid @enderror"
                                           value="{{ old('number', $letter->number) }}" placeholder="Masukkan nomor surat" required>
                                    <label for="number">
                                        <i class="bi bi-hash me-2"></i>Nomor Surat <span class="text-danger">*</span>
                                    </label>
                                    @error('number')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kategori Surat --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" @if(old('category_id', $letter->category_id)==$cat->id) selected @endif>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="category_id">
                                        <i class="bi bi-tags me-2"></i>Kategori Surat <span class="text-danger">*</span>
                                    </label>
                                    @error('category_id')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-floating">
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $letter->title) }}" placeholder="Masukkan judul surat lengkap" required>
                                <label for="title">
                                    <i class="bi bi-card-text me-2"></i>Judul Surat <span class="text-danger">*</span>
                                </label>
                                @error('title')
                                    <div class="invalid-feedback d-flex align-items-center">
                                        <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="file" class="form-label fw-semibold mb-3">
                                <i class="bi bi-file-earmark-pdf-fill me-2 text-warning"></i>
                                File Surat (PDF) - Opsional
                            </label>

                            <!-- Current file info -->
                            <div class="alert alert-info border-0 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark-pdf-fill me-3 fs-4 text-info"></i>
                                    <div>
                                        <h6 class="mb-1">File Saat Ini</h6>
                                        <p class="mb-0 text-muted">{{ basename($letter->file_path) }}</p>
                                        <small class="text-muted">Kosongkan jika tidak ingin mengganti file</small>
                                    </div>
                                </div>
                            </div>

                            <div class="file-upload-area border-2 border-dashed border-warning rounded-3 p-4 text-center bg-light"
                                 onclick="document.getElementById('file').click()">
                                <div class="mb-3">
                                    <i class="bi bi-cloud-upload-fill text-warning display-4"></i>
                                </div>
                                <h6 class="text-muted mb-2">Klik untuk mengganti file PDF</h6>
                                <p class="text-muted small mb-0">atau drag & drop file PDF baru</p>
                                <div id="fileName" class="mt-3 fw-semibold text-warning" style="display: none;"></div>
                            </div>
                            <input type="file" name="file" id="file" class="d-none @error('file') is-invalid @enderror"
                                   accept="application/pdf">
                            @error('file')
                                <div class="invalid-feedback d-flex align-items-center mt-2">
                                    <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Pastikan file PDF berkualitas baik dan berukuran maksimal 10MB
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                                    <a href="{{ route('letters.show', $letter) }}" class="btn btn-outline-secondary btn-lg">
                                        <i class="bi bi-eye me-2"></i>Lihat Detail Surat
                                    </a>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('letters.index') }}" class="btn btn-outline-secondary btn-lg">
                                            <i class="bi bi-arrow-left me-2"></i>Kembali
                                        </a>
                                        <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                                            <i class="bi bi-check-circle-fill me-2"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const fileNameDiv = document.getElementById('fileName');
    const uploadArea = document.querySelector('.file-upload-area');

    if (file) {
        fileNameDiv.textContent = `📄 ${file.name}`;
        fileNameDiv.style.display = 'block';
        uploadArea.classList.add('bg-warning', 'bg-opacity-10');
        uploadArea.classList.remove('bg-light');
    } else {
        fileNameDiv.style.display = 'none';
        uploadArea.classList.remove('bg-warning', 'bg-opacity-10');
        uploadArea.classList.add('bg-light');
    }
});

// Drag and drop functionality
const uploadArea = document.querySelector('.file-upload-area');
const fileInput = document.getElementById('file');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults (e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    uploadArea.classList.add('bg-warning', 'bg-opacity-10', 'border-warning');
}

function unhighlight(e) {
    uploadArea.classList.remove('bg-warning', 'bg-opacity-10', 'border-warning');
}

uploadArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;

    if (files.length > 0 && files[0].type === 'application/pdf') {
        fileInput.files = files;
        fileInput.dispatchEvent(new Event('change'));
    } else {
        alert('Harap pilih file PDF yang valid.');
    }
}

// Form submission with loading state
document.getElementById('letterForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;

    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
    submitBtn.disabled = true;

    // Re-enable after 10 seconds as fallback
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 10000);
});
</script>
@endpush
@endsection
