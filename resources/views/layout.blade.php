<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Arsip Surat - Kelurahan Karangduren')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #1a202c;
            line-height: 1.6;
            position: relative;
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(49, 130, 206, 0.03) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(56, 161, 105, 0.03) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }
        .sidebar {
            min-width: 260px;
            max-width: 280px;
            width: 260px;
            background: #ffffff;
            min-height: 100vh;
            box-shadow: 4px 0 20px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.03);
            backdrop-filter: blur(10px);
            z-index: 1050;
            border-right: 1px solid rgba(0,0,0,0.06);
            position: fixed;
            left: 0;
            top: 0;
            transition: transform 0.3s ease;
        }
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
        .sidebar.show {
            z-index: 1060;
        }
        .sidebar .nav-link.active {
            font-weight: 600;
            color: #3182ce;
            background: #e6f3ff;
            border-radius: 12px;
            border-left: 4px solid #3182ce;
            margin: 4px 8px;
            box-shadow: 0 2px 8px rgba(49, 130, 206, 0.15);
        }
        .sidebar .nav-link {
            color: #4a5568;
            padding: 12px 16px;
            margin: 4px 8px;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
        }
        .sidebar .nav-link:hover {
            background: rgba(49, 130, 206, 0.05);
            color: #3182ce;
            transform: translateX(4px);
        }
        .sidebar .nav-link i {
            margin-right: 12px;
            font-size: 1.1em;
            width: 20px;
            text-align: center;
        }
        .main-content {
            margin-left: 260px;
            padding: 2rem;
            background: transparent;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        .main-content.expanded {
            margin-left: 0;
        }
        .table-actions button, .table-actions a {
            margin-right: 0.5rem;
        }

        .card {
            border: none;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.98) 50%, rgba(255,255,255,0.95) 100%);
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1), 0 8px 16px rgba(0,0,0,0.06), inset 0 1px 0 rgba(255,255,255,0.8);
            color: #2d3748;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.8) 50%, transparent 100%);
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15), 0 12px 24px rgba(0,0,0,0.08), inset 0 1px 0 rgba(255,255,255,0.9);
        }
        .card-header {
            background: #f1f5f9;
            border-bottom: 1px solid #e2e8f0;
            color: #2d3748;
            font-weight: 600;
            padding: 1rem 1.25rem;
            font-size: 1em;
        }
        .card-body {
            padding: 1.25rem;
        }

        .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
        }
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .btn:hover::before {
            left: 100%;
        }
        .btn-primary {
            background: #3182ce;
            color: white;
            box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
        }
        .btn-primary:hover {
            background: #2c5282;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(49, 130, 206, 0.4);
        }
        .btn-success {
            background: #38a169;
            color: white;
            box-shadow: 0 4px 15px rgba(56, 161, 105, 0.3);
        }
        .btn-success:hover {
            background: #2f855a;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(56, 161, 105, 0.4);
        }
        .btn-info {
            background: #4299e1;
            color: white;
            box-shadow: 0 4px 15px rgba(66, 153, 225, 0.3);
        }
        .btn-info:hover {
            background: #3182ce;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(66, 153, 225, 0.4);
        }
        .btn-warning {
            background: #d69e2e;
            color: white;
            box-shadow: 0 4px 15px rgba(214, 158, 46, 0.3);
        }
        .btn-warning:hover {
            background: #b7791f;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(214, 158, 46, 0.4);
        }
        .btn-danger {
            background: #e53e3e;
            color: white;
            box-shadow: 0 4px 15px rgba(229, 62, 62, 0.3);
        }
        .btn-danger:hover {
            background: #c53030;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(229, 62, 62, 0.4);
        }
        .btn-secondary {
            background: #718096;
            color: white;
            box-shadow: 0 4px 15px rgba(113, 128, 150, 0.3);
        }
        .btn-secondary:hover {
            background: #4a5568;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(113, 128, 150, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid #3182ce;
            color: #3182ce;
            background: transparent;
        }
        .btn-outline-primary:hover {
            background: #3182ce;
            border-color: #3182ce;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(49, 130, 206, 0.4);
        }
        .btn-outline-success {
            border: 2px solid #38a169;
            color: #38a169;
            background: transparent;
        }
        .btn-outline-success:hover {
            background: #38a169;
            border-color: #38a169;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(56, 161, 105, 0.4);
        }
        .btn-outline-danger {
            border: 2px solid #e53e3e;
            color: #e53e3e;
            background: transparent;
        }
        .btn-outline-danger:hover {
            background: #e53e3e;
            border-color: #e53e3e;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(229, 62, 62, 0.4);
        }
        .btn-outline-warning {
            border: 2px solid #d69e2e;
            color: #d69e2e;
            background: transparent;
        }
        .btn-outline-warning:hover {
            background: #d69e2e;
            border-color: #d69e2e;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(214, 158, 46, 0.4);
        }
        .btn-outline-info {
            border: 2px solid #4299e1;
            color: #4299e1;
            background: transparent;
        }
        .btn-outline-info:hover {
            background: #4299e1;
            border-color: #4299e1;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(66, 153, 225, 0.4);
        }
        .btn-outline-secondary {
            border: 2px solid #718096;
            color: #718096;
            background: transparent;
        }
        .btn-outline-secondary:hover {
            background: #718096;
            border-color: #718096;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(113, 128, 150, 0.4);
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            background: #ffffff;
            border: none;
        }
        .table thead th {
            background: #f1f5f9;
            color: #2d3748;
            border: none;
            font-weight: 600;
            padding: 1rem;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table tbody tr {
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }
        .table tbody tr:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transform: scale(1.005);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #4a5568;
        }

        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            background: #c6f6d5;
            color: #22543d;
            border-left: 4px solid #38a169;
        }
        .alert-success {
            background: #c6f6d5;
            color: #22543d;
            border-left-color: #38a169;
        }

        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 25px 50px rgba(0,0,0,0.25), 0 0 0 1px rgba(255,255,255,0.8);
            background: #ffffff;
            overflow: hidden;
            backdrop-filter: blur(20px);
            z-index: 1070 !important;
        }
        .modal-backdrop {
            z-index: 1055 !important;
            display: none !important;
        }
        .modal-header {
            background: #f1f5f9;
            border-bottom: 1px solid #e2e8f0;
            color: #2d3748;
            padding: 1.5rem;
        }
        .modal-header .modal-title {
            font-weight: 600;
            font-size: 1.2em;
        }
        .modal-body {
            background: #ffffff;
            color: #4a5568;
            padding: 2rem;
            line-height: 1.7;
        }
        .modal-footer {
            background: #f1f5f9;
            border-top: 1px solid #e2e8f0;
            padding: 1.5rem;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            background: #ffffff;
            color: #2d3748;
            padding: 0.75rem 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95em;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1), 0 4px 12px rgba(102, 126, 234, 0.15);
            background: #ffffff;
            transform: translateY(-1px);
        }
        .form-control::placeholder {
            color: #a0aec0;
        }
        .form-label {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge {
            border-radius: 20px;
            font-weight: 600;
            padding: 0.375rem 0.875rem;
            font-size: 0.75em;
            background: linear-gradient(135deg, #e6f3ff 0%, #d1e9ff 100%);
            color: #1e40af;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.3);
            border: 1px solid rgba(59, 130, 246, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.2s ease;
        }

        .badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.4);
        }

        /* Utility classes for gradient backgrounds */
        .bg-gradient-primary {
            background: #3182ce !important;
        }
        .bg-gradient-success {
            background: #38a169 !important;
        }
        .bg-gradient-info {
            background: #4299e1 !important;
        }
        .bg-gradient-warning {
            background: #d69e2e !important;
        }
        .bg-gradient-danger {
            background: #e53e3e !important;
        }

        /* Modern spacing utilities */
        .section-spacing {
            padding: 3rem 0;
        }

        .content-spacing {
            padding: 2rem;
        }

        /* Enhanced focus states */
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1), 0 4px 12px rgba(102, 126, 234, 0.15);
            background: #ffffff;
            transform: translateY(-1px);
        }

        /* Smooth transitions for all interactive elements */
        a, button, .btn, .nav-link, .card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Enhanced scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #cbd5e0 0%, #a0aec0 100%);
            border-radius: 10px;
            border: 2px solid #f1f5f9;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
        }

        /* Responsive styles */
        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -260px;
                width: 260px;
                z-index: 1060;
                transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .sidebar.show {
                left: 0;
            }
            .main-content {
                padding: 1rem;
                margin-left: 0;
            }
            .card-body {
                padding: 1rem;
            }
            .table-responsive {
                font-size: 0.875em;
            }
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.875em;
            }
            .card-header {
                padding: 0.75rem 1rem;
                font-size: 0.9em;
            }
        }
        @media (min-width: 768px) {
            .sidebar-toggle {
                display: none !important;
            }
        }
        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            .card-body {
                padding: 0.75rem;
            }
            .table-responsive {
                font-size: 0.8em;
            }
            .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.8em;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Container effects */
        .container-fluid {
            position: relative;
            z-index: 10;
        }

        /* Enhanced layering effects */
        .main-content {
            position: relative;
            z-index: 5;
        }

        /* Floating effect for important elements */
        .card.important, .alert.important {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        /* Responsive Design Improvements */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .main-content.expanded {
                margin-left: 0;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            .card {
                margin-bottom: 1rem;
                border-radius: 8px;
            }
            .card-header {
                padding: 0.75rem 1rem;
                font-size: 0.9em;
            }
            .card-body {
                padding: 1rem;
            }
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9em;
            }
            .table-responsive {
                font-size: 0.85em;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            .card {
                margin-bottom: 0.75rem;
            }
            .d-flex.justify-content-between.align-items-center.mb-4 {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }
            .d-flex.justify-content-between.align-items-center.mb-4 > div:first-child {
                text-align: center;
            }
            .btn-lg {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        /* Mobile Overlay */
        .overlay {
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(2px);
            display: none;
            transition: opacity 0.3s ease;
        }
        .overlay.show {
            display: block;
            opacity: 1;
        }

        /* Mobile Toggle Button */
        .sidebar-toggle {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }
        .sidebar-toggle:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0,0,0,0.2);
        }

        /* Hide modal backdrop for delete confirmations */
        .modal-backdrop {
            display: none !important;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar Toggle Button for Mobile -->
    <button class="btn btn-primary sidebar-toggle position-fixed top-0 start-0 m-3 d-lg-none" type="button" onclick="toggleSidebar()" style="z-index: 1070;" aria-label="Toggle Sidebar">
        <i class="bi bi-list"></i>
    </button>

    <!-- Overlay for Mobile -->
    <div class="overlay position-fixed w-100 h-100" id="overlay" onclick="toggleSidebar()" style="z-index: 1040;"></div>

    <nav class="sidebar" id="sidebar">
        <div class="p-3 border-bottom bg-light">
            <h5 class="mb-0">Menu</h5>
        </div>
        <ul class="nav flex-column p-2">
            <li class="nav-item mb-1">
                <a href="{{ route('letters.index') }}" class="nav-link @if(request()->routeIs('letters.*')) active @endif">
                    <i class="bi bi-archive"></i> Arsip Surat
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('categories.index') }}" class="nav-link @if(request()->routeIs('categories.*')) active @endif">
                    <i class="bi bi-tags"></i> Kategori Surat
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('about') }}" class="nav-link @if(request()->routeIs('about')) active @endif">
                    <i class="bi bi-info-circle"></i> Tentang
                </a>
            </li>
        </ul>
    </nav>
    <div class="main-content flex-fill">
        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mainContent = document.querySelector('.main-content');

        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');

        // Prevent body scroll when sidebar is open on mobile
        if (window.innerWidth <= 1024) {
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        }
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleBtn = document.querySelector('.sidebar-toggle');

        if (window.innerWidth <= 1024 &&
            sidebar.classList.contains('show') &&
            !sidebar.contains(event.target) &&
            event.target !== toggleBtn &&
            !toggleBtn.contains(event.target)) {
            toggleSidebar();
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        if (window.innerWidth > 1024) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
    });
</script>
@stack('scripts')
</body>
</html>
