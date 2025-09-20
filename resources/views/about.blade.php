@extends('layout')
@section('title', 'Tentang - Kelurahan Karangduren')
@section('content')
<div class="container-fluid section-spacing">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center content-spacing">
                    <div class="mb-4">
                        <p class="text-muted mb-4 fs-5">
                            <strong>Aplikasi ini dibuat oleh:</strong>
                        </p>
                        <img src="{{ asset('img/foto.jpg') }}" alt="Foto Pengembang" class="img-fluid rounded-circle border shadow-sm"
                             style="width: 160px; height: 160px; object-fit: cover; border-width: 3px !important; border-color: rgba(49, 130, 206, 0.2) !important;"
                             onerror="this.src='https://via.placeholder.com/160x160?text=Pandya+Rafa'">
                    </div>
                    <h3 class="text-primary mb-3 fw-bold" style="font-size: 1.75rem;">Pandya Rafa Haibah Putra</h3>
                    <div class="mb-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-4 py-2 fs-6">
                            <i class="bi bi-mortarboard-fill me-2"></i>NIM: 2331730061
                        </span>
                    </div>
                    <div class="mb-3">
                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-4 py-2 fs-6">
                            <i class="bi bi-building-fill me-2"></i>D3 Manajemen Informatika PSDKU Kediri
                        </span>
                    </div>
                    <div class="mb-4">
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-4 py-2 fs-6">
                            <i class="bi bi-calendar-event-fill me-2"></i>{{ date('d F Y', strtotime('2025-09-16')) }}
                        </span>
                    </div>
                    <div class="mt-4 pt-3 border-top border-light">
                        <p class="text-muted mb-0 small">
                            <i class="bi bi-code-slash me-1"></i>Dikembangkan dengan ❤️ menggunakan Laravel & Bootstrap
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
