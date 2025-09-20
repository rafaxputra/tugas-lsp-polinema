@extends('layout')
@section('title', 'Arsipkan Surat Baru - Kelurahan Karangduren')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-light text-dark">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-plus-circle-fill me-3 fs-4"></i>
                        <div>
                            <h4 class="mb-0">Arsipkan Surat Baru</h4>
                            <small class="opacity-75">Tambahkan surat resmi ke dalam sistem arsip</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('letters.store') }}" enctype="multipart/form-data" id="letterForm">
                        @csrf

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="number" id="number" class="form-control @error('number') is-invalid @enderror"
                                           value="{{ old('number') }}" placeholder="Masukkan nomor surat" required>
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
                                            <option value="{{ $cat->id }}" @if(old('category_id')==$cat->id) selected @endif>
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
                                       value="{{ old('title') }}" placeholder="Masukkan judul surat lengkap" required>
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
                                <i class="bi bi-file-earmark-pdf-fill me-2 text-danger"></i>
                                File Surat (PDF) <span class="text-danger">*</span>
                            </label>
                            <div class="file-upload-area border-2 border-dashed border-primary rounded-3 p-4 text-center bg-light"
                                 onclick="document.getElementById('file').click()">
                                <div class="mb-3">
                                    <i class="bi bi-cloud-upload-fill text-primary display-4"></i>
                                </div>
                                <h6 class="text-muted mb-2">Klik untuk memilih file PDF</h6>
                                <p class="text-muted small mb-0">atau drag & drop file PDF hasil scan surat resmi</p>
                                <div id="fileName" class="mt-3 fw-semibold text-primary" style="display: none;"></div>
                            </div>
                            <input type="file" name="file" id="file" class="d-none @error('file') is-invalid @enderror"
                                   accept="application/pdf" required>
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
                                    <a href="{{ route('letters.index') }}" class="btn btn-outline-secondary btn-lg">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Surat
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                        <i class="bi bi-check-circle-fill me-2"></i>Arsipkan Surat
                                    </button>
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
        uploadArea.classList.add('bg-success', 'bg-opacity-10');
        uploadArea.classList.remove('bg-light');
    } else {
        fileNameDiv.style.display = 'none';
        uploadArea.classList.remove('bg-success', 'bg-opacity-10');
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
    uploadArea.classList.add('bg-primary', 'bg-opacity-10', 'border-primary');
}

function unhighlight(e) {
    uploadArea.classList.remove('bg-primary', 'bg-opacity-10', 'border-primary');
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

    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengarsipkan...';
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
