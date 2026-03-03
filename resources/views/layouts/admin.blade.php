<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'لوحة الإدارة') | الجامعة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: #f4f6fb;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: #1e3a5f;
            color: #fff;
            width: 250px;
            position: fixed;
            top: 0;
            right: 0;
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #cde;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 8px;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #2e6da4;
            color: #fff;
        }

        .sidebar .logo {
            padding: 20px;
            font-size: 1.2rem;
            font-weight: bold;
            border-bottom: 1px solid #2e6da4;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar .btn-close-white {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .sidebar .btn-close-white:hover {
            opacity: 1;
        }

        .main-content {
            margin-right: 250px;
            padding: 25px;
            transition: margin-right 0.3s ease-in-out;
            min-height: 100vh;
        }

        .toggle-sidebar {
            display: none;
            background: #1e3a5f;
            color: white;
            border: none;
            padding: 12px 16px;
            border-radius: 8px;
            cursor: pointer;
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 999;
            font-size: 1.25rem;
            line-height: 1;
            min-height: 44px;
            min-width: 44px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .toggle-sidebar:active {
            transform: scale(0.95);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
        }

        .card-header {
            border-radius: 12px 12px 0 0 !important;
        }

        .badge-lecture {
            background: #0d6efd;
        }

        .badge-lab {
            background: #198754;
        }

        .conflict-alert {
            border-right: 4px solid #dc3545;
        }

        /* Improved touch targets and accessibility */
        button,
        .nav-link,
        .btn {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="date"],
        input[type="time"],
        select,
        textarea {
            font-size: 16px;
            min-height: 44px;
        }

        /* Better scrolling on mobile */
        html {
            scroll-behavior: smooth;
        }

        /* Prevent zoom on input focus */
        @media (max-width: 768px) {
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            input[type="date"],
            input[type="time"],
            select,
            textarea {
                font-size: 16px;
            }
        }

        /* Prevent horizontal scroll */
        body,
        html {
            overflow-x: hidden;
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 240px;
            }

            .main-content {
                margin-right: 240px;
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: 100vh;
                transform: translateX(100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-right: 0;
                padding: 15px;
                margin-top: 55px;
            }

            .toggle-sidebar {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .card {
                margin-bottom: 15px;
                border-radius: 10px;
            }

            .card-header {
                padding: 1rem;
                font-size: 0.95rem;
            }

            .sidebar .logo {
                padding: 15px;
                font-size: 1rem;
            }

            .sidebar .nav-link {
                padding: 10px 16px;
                margin: 2px 5px;
                font-size: 0.95rem;
            }

            table {
                font-size: 0.85rem;
            }

            .table th,
            .table td {
                padding: 0.6rem 0.4rem;
            }

            .btn {
                padding: 0.5rem 0.8rem;
                font-size: 0.85rem;
                min-height: 38px;
            }

            .btn-group {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .form-control,
            .form-select {
                min-height: 40px;
                font-size: 1rem;
            }

            .alert {
                padding: 0.8rem;
                font-size: 0.9rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            h2 {
                font-size: 1.25rem;
            }

            h3 {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 12px;
                margin-top: 50px;
            }

            .toggle-sidebar {
                top: 10px;
                right: 10px;
                padding: 10px 12px;
                font-size: 1.1rem;
            }

            .card {
                border-radius: 8px;
                margin-bottom: 12px;
            }

            .card-body {
                padding: 0.75rem;
            }

            .card-header {
                padding: 0.75rem;
                font-size: 0.9rem;
            }

            .sidebar .logo {
                padding: 12px;
                font-size: 0.9rem;
            }

            .sidebar .nav-link {
                padding: 8px 12px;
                margin: 1px 3px;
                font-size: 0.9rem;
                border-radius: 6px;
            }

            .btn {
                padding: 0.4rem 0.7rem;
                font-size: 0.8rem;
                min-height: 36px;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .btn-group {
                gap: 0.25rem;
            }

            table {
                font-size: 0.75rem;
            }

            .table th,
            .table td {
                padding: 0.4rem 0.3rem;
            }

            .form-control,
            .form-select {
                min-height: 38px;
                font-size: 16px;
                padding: 0.5rem;
            }

            .form-label {
                font-size: 0.85rem;
                margin-bottom: 0.3rem;
            }

            .alert {
                padding: 0.6rem;
                font-size: 0.85rem;
                border-radius: 6px;
            }

            .badge {
                font-size: 0.75rem;
                padding: 0.35em 0.6em;
            }

            h1 {
                font-size: 1.25rem;
                margin-bottom: 1rem;
            }

            h2 {
                font-size: 1.1rem;
            }

            h3 {
                font-size: 1rem;
            }

            .row {
                margin-right: -6px;
                margin-left: -6px;
            }

            .col {
                padding-right: 6px;
                padding-left: 6px;
            }

            /* Stack columns on very small screens */
            .col-lg-6,
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        @media (max-width: 400px) {
            .main-content {
                padding: 8px;
                margin-top: 48px;
            }

            .toggle-sidebar {
                top: 8px;
                right: 8px;
                padding: 8px 10px;
                font-size: 1rem;
                min-height: 40px;
                min-width: 40px;
            }

            .btn {
                padding: 0.3rem 0.6rem;
                font-size: 0.75rem;
                min-height: 34px;
            }

            .table th,
            .table td {
                padding: 0.35rem 0.25rem;
            }

            .sidebar .nav-link i {
                margin-right: 0.5rem !important;
            }
        }
    </style>
</head>

<body>

    {{-- Mobile Menu Toggle --}}
    <button class="toggle-sidebar" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    {{-- Sidebar --}}
    <div class="sidebar pt-0" id="sidebar">
        <div class="logo d-flex justify-content-between align-items-center">
            <span><i class="bi bi-mortarboard-fill me-2"></i>نظام الجداول</span>
            <button type="button" class="btn-close btn-close-white d-md-none" id="closeSidebar" aria-label="إغلاق"></button>
        </div>
        <nav class="nav flex-column mt-3">
            <a href="{{ route('admin.dashboard') }}" class="nav-link @active('admin/dashboard')"><i
                    class="bi bi-speedometer2 me-2"></i>الرئيسية</a>
            <a href="{{ route('admin.halls.index') }}" class="nav-link @active('admin/halls*')"><i
                    class="bi bi-building me-2"></i>القاعات</a>
            <a href="{{ route('admin.doctors.index') }}" class="nav-link @active('admin/doctors*')"><i
                    class="bi bi-person-badge me-2"></i>الدكاترة</a>
            <a href="{{ route('admin.subjects.index') }}" class="nav-link @active('admin/subjects*')"><i
                    class="bi bi-book me-2"></i>المواد</a>
            <a href="{{ route('admin.student-groups.index') }}" class="nav-link @active('admin/student-groups*')"><i
                    class="bi bi-people me-2"></i>المجموعات</a>
            <a href="{{ route('admin.schedules.index') }}" class="nav-link @active('admin/schedules*')"><i
                    class="bi bi-calendar-week me-2"></i>الجداول</a>
            <a href="{{ route('admin.students.index') }}" class="nav-link @active('admin/students*')">
                <i class="bi bi-mortarboard me-2"></i>الطلاب
            </a>
            <hr style="border-color:#2e6da4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="nav-link border-0 bg-transparent w-100 text-start text-danger"><i
                        class="bi bi-box-arrow-left me-2"></i>تسجيل الخروج</button>
            </form>
        </nav>
    </div>

    <div class="main-content">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('conflict_error'))
            <div class="alert alert-danger conflict-alert alert-dismissible fade show">
                {{ session('conflict_error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const closeSidebar = document.getElementById('closeSidebar');

            // Toggle sidebar on button click
            sidebarToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.toggle('show');
            });

            // Close sidebar with close button
            if (closeSidebar) {
                closeSidebar.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebar.classList.remove('show');
                });
            }

            // Close sidebar when a nav link is clicked
            sidebar.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                });
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });

            // Close sidebar on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                }
            });

            // Better touch support
            if (window.innerWidth <= 768) {
                document.querySelector('body').style.touchAction = 'manipulation';
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
