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
        }

        .sidebar .nav-link {
            color: #cde;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 8px;
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
        }

        .main-content {
            margin-right: 250px;
            padding: 25px;
            transition: margin-right 0.3s ease-in-out;
        }

        .toggle-sidebar {
            display: none;
            background: #1e3a5f;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 999;
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

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                transform: translateX(100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-right: 0;
                padding: 15px;
            }

            .toggle-sidebar {
                display: block;
            }

            .card {
                margin-bottom: 15px;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 10px;
            }

            .card {
                border-radius: 8px;
            }

            .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.875rem;
            }

            .btn-group {
                flex-wrap: wrap;
                gap: 0.25rem;
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
        <div class="logo"><i class="bi bi-mortarboard-fill me-2"></i>نظام الجداول</div>
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
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        });

        // Close sidebar when a link is clicked on mobile
        if (window.innerWidth <= 768) {
            document.querySelectorAll('.sidebar .nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    document.getElementById('sidebar').classList.remove('show');
                });
            });
        }
    </script>
    @stack('scripts')
</body>

</html>
