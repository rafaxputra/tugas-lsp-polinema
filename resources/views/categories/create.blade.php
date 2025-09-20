@extends('layout')
@section('title', 'Tambah Kategori Surat - Kelurahan Karangduren')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-light text-dark">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-plus-circle-fill me-3 fs-4"></i>
                        <div>
                            <h4 class="mb-0">Tambah Kategori Baru</h4>
                            <small class="opacity-75">Buat kategori baru untuk mengorganisir surat</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('categories.store') }}" id="categoryForm">
                        @csrf

                        <div class="mb-4">
                            <div class="form-floating">
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="Masukkan nama kategori" required>
                                <label for="name">
                                    <i class="bi bi-tag-fill me-2"></i>Nama Kategori <span class="text-danger">*</span>
                                </label>
                                @error('name')
                                    <div class="invalid-feedback d-flex align-items-center">
                                        <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Contoh: Surat Masuk, Surat Keluar, Surat Undangan, dll.
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-floating">
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Jelaskan fungsi kategori ini (opsional)" rows="4" style="height: 120px;">{{ old('description') }}</textarea>
                                <label for="description">
                                    <i class="bi bi-card-text me-2"></i>Keterangan Kategori
                                </label>
                                @error('description')
                                    <div class="invalid-feedback d-flex align-items-center">
                                        <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Berikan penjelasan singkat tentang jenis surat yang akan dikategorikan di sini.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-lg">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Kategori
                                    </a>
                                    <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                        <i class="bi bi-check-circle-fill me-2"></i>Buat Kategori
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
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;

    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Membuat kategori...';
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
