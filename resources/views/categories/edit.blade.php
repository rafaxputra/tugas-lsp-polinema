@extends('layout')
@section('title', 'Edit Kategori Surat - Kelurahan Karangduren')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-light text-dark">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-pencil-square me-3 fs-4"></i>
                        <div>
                            <h4 class="mb-0">Edit Kategori Surat</h4>
                            <small class="opacity-75">Perbarui informasi kategori yang dipilih</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('categories.update', $category) }}" id="categoryForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <div class="form-floating">
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $category->name) }}" placeholder="Masukkan nama kategori" required>
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
                                Nama kategori akan digunakan untuk mengorganisir surat.
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-floating">
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Jelaskan fungsi kategori ini" rows="4" style="height: 120px;">{{ old('description', $category->description) }}</textarea>
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
                                Berikan penjelasan yang jelas tentang jenis surat dalam kategori ini.
                            </div>
                        </div>

                        <!-- Category Statistics -->
                        <div class="alert alert-info border-0 mb-4">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-bar-chart-line-fill me-3 fs-4 text-info"></i>
                                <div>
                                    <h6 class="mb-1">Statistik Kategori</h6>
                                    <p class="mb-0 text-muted">Kategori ini memiliki <strong>{{ $category->letters()->count() }}</strong> surat yang terarsip.</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-lg">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Kategori
                                    </a>
                                    <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                                        <i class="bi bi-check-circle-fill me-2"></i>Simpan Perubahan
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
