<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'لوحة الإدارة') | الجامعة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Cairo:wght@400;600;700;900&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-gradient: linear-gradient(135deg, #1e3a5f 0%, #2e5a8f 100%);
            --secondary-gradient: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            --accent: #00d4ff;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --card-bg: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Cairo', 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f4f8 0%, #e8f1f9 100%);
            color: var(--text-primary);
            overflow-x: hidden;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ==================== NAVBAR STYLES ==================== */
        .navbar-admin {
            background: var(--primary-gradient);
            box-shadow: 0 8px 32px rgba(30, 58, 95, 0.3);
            padding: 16px 0;
            border-bottom: none;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        /* Animated navbar background */
        .navbar-admin::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .navbar-admin>* {
            position: relative;
            z-index: 1;
        }

        .navbar-admin .navbar-brand {
            color: #fff;
            font-weight: 800;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .navbar-admin .navbar-brand:hover {
            transform: translateY(-2px);
        }

        .navbar-admin .navbar-brand i {
            font-size: 1.5rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .navbar-admin .navbar-toggler {
            min-width: 48px;
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: none;
        }

        .navbar-admin .navbar-toggler:focus {
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.3);
        }

        .navbar-admin .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 12px 18px !important;
            border-radius: 10px;
            margin: 4px 4px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
        }

        .navbar-admin .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .navbar-admin .nav-link:hover::before {
            left: 0;
        }

        .navbar-admin .nav-link:hover,
        .navbar-admin .nav-link.active {
            color: #fff;
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
            font-weight: 700;
        }

        .navbar-admin .nav-link i {
            transition: all 0.3s ease;
            font-size: 1.1rem;
            margin-left: 6px;
        }

        .navbar-admin .nav-link:hover i {
            transform: scale(1.2) rotate(10deg);
        }

        .navbar-admin .nav-link.active i {
            transform: scale(1.25);
        }

        /* Admin Info Section */
        .navbar-admin .admin-info {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
        }

        .navbar-admin .admin-info i {
            font-size: 1.3rem;
        }

        .navbar-admin .admin-info span {
            font-size: 0.95rem;
        }

        .navbar-admin .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.4);
            color: #fff;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .navbar-admin .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            color: #fff;
        }

        /* ==================== MAIN CONTAINER ==================== */
        .container-main {
            flex: 1;
            padding-bottom: 40px;
        }

        /* ==================== MAIN CONTENT ==================== */
        .main-content {
            padding: 35px;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ==================== PAGE HEADER ==================== */
        .page-header {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 32px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .page-header:hover {
            box-shadow: 0 8px 32px rgba(30, 58, 95, 0.15);
            transform: translateY(-2px);
        }

        .page-header h5 {
            font-weight: 800;
            color: #1a202c;
            font-size: 1.5rem;
            margin-bottom: 8px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-header p {
            color: #6b7280;
            font-weight: 500;
            margin: 0;
        }

        /* ==================== CARD STYLES ==================== */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--card-bg);
            overflow: hidden;
            position: relative;
        }

        .card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--secondary-gradient);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            box-shadow: 0 16px 40px rgba(30, 58, 95, 0.15);
            transform: translateY(-8px);
        }

        .card:hover::after {
            transform: scaleX(1);
        }

        .card-header {
            border-radius: 16px 16px 0 0 !important;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border-bottom: none;
            padding: 24px !important;
            font-weight: 700;
            color: #1a202c;
            font-size: 1.1rem;
            letter-spacing: 0.3px;
        }

        .card-body {
            padding: 24px !important;
        }

        /* ==================== ALERT STYLES ==================== */
        .alert {
            border: none;
            border-radius: 14px;
            padding: 16px 20px;
            font-weight: 600;
            margin-bottom: 24px;
            animation: slideInDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
            color: #065f46;
            border-left: 5px solid var(--success);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            color: #7f1d1d;
            border-left: 5px solid var(--danger);
        }

        .conflict-alert {
            border-left: 5px solid var(--danger) !important;
        }

        /* ==================== BUTTON STYLES ==================== */
        .btn {
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 12px 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            gap: 10px;
            cursor: pointer;
            letter-spacing: 0.4px;
            font-size: 0.95rem;
            text-transform: uppercase;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 6px 20px rgba(30, 58, 95, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(30, 58, 95, 0.3);
            color: white;
        }

        /* ==================== FOOTER ==================== */
        footer {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            color: #6b7280;
            font-size: 0.9rem;
            padding: 28px 0;
            border-top: 1px solid rgba(30, 58, 95, 0.15);
            text-align: center;
            font-weight: 600;
            margin-top: auto;
            letter-spacing: 0.3px;
        }

        footer i {
            color: #1e3a5f;
            font-size: 1.1rem;
        }

        /* ==================== FORM ELEMENTS ==================== */
        .form-control,
        .form-select {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            min-height: 44px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Cairo', 'Poppins', sans-serif;
            background-color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #1e3a5f;
            box-shadow: 0 0 0 4px rgba(30, 58, 95, 0.1);
            background-color: #fff;
        }

        /* ==================== BADGE STYLES ==================== */
        .badge {
            font-weight: 700;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 0.8rem;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .badge-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .badge-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        /* ==================== RESPONSIVE TABLET ==================== */
        @media(max-width: 992px) {
            .navbar-admin .navbar-brand {
                font-size: 1.1rem;
            }

            .page-header {
                padding: 24px;
            }

            .card-header {
                font-size: 1rem;
            }
        }

        /* ==================== RESPONSIVE MOBILE ==================== */
        @media(max-width: 768px) {
            body {
                padding-top: 0;
            }

            .navbar-admin {
                padding: 12px 0;
            }

            .navbar-admin .navbar-brand {
                font-size: 1rem;
            }

            .navbar-admin .nav-link {
                padding: 10px 14px !important;
                margin: 2px 2px;
                font-size: 0.85rem;
            }

            .navbar-admin .admin-info {
                margin-top: 12px;
                font-size: 0.85rem;
            }

            .navbar-admin .collapse {
                margin-top: 12px;
                padding: 12px;
                background: rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }

            .main-content {
                padding: 0 12px;
                padding-bottom: 30px;
            }

            .page-header {
                padding: 20px;
                margin-bottom: 24px;
            }

            .page-header h5 {
                font-size: 1.2rem;
            }

            .card {
                margin-bottom: 16px;
                border-radius: 14px;
            }

            .card-header {
                padding: 18px !important;
                font-size: 0.95rem;
            }

            .card-body {
                padding: 18px !important;
            }

            .btn {
                padding: 10px 16px;
                font-size: 0.85rem;
                min-height: 40px;
            }

            .btn-sm {
                padding: 8px 12px;
                font-size: 0.75rem;
                min-height: 36px;
            }

            footer {
                padding: 20px 0;
                font-size: 0.85rem;
            }
        }

        /* ==================== RESPONSIVE SMALL MOBILE ==================== */
        @media(max-width: 640px) {
            .navbar-admin .navbar-brand {
                font-size: 0.95rem;
                gap: 6px;
            }

            .navbar-admin .navbar-brand i {
                font-size: 1.2rem;
            }

            .navbar-admin .admin-info span {
                display: none;
            }

            .main-content {
                padding: 0 10px;
                padding-bottom: 25px;
            }

            .page-header {
                padding: 16px;
                margin-bottom: 20px;
            }

            .page-header h5 {
                font-size: 1.05rem;
            }

            .page-header p {
                font-size: 0.8rem;
            }

            .card-header {
                padding: 14px !important;
                font-size: 0.9rem;
            }

            .card-body {
                padding: 14px !important;
            }

            .btn {
                padding: 8px 12px;
                font-size: 0.8rem;
                min-height: 38px;
            }

            .alert {
                padding: 12px 14px;
                font-size: 0.85rem;
            }

            footer {
                padding: 16px 0;
                font-size: 0.8rem;
            }
        }

        /* ==================== RESPONSIVE EXTRA SMALL ==================== */
        @media(max-width: 480px) {
            .navbar-admin {
                padding: 10px 0;
            }

            .navbar-admin .navbar-brand {
                font-size: 0.85rem;
                gap: 6px;
            }

            .navbar-admin .navbar-brand i {
                font-size: 1.1rem;
            }

            .navbar-admin .nav-link {
                padding: 8px 10px !important;
                font-size: 0.75rem;
            }

            .navbar-admin .btn-outline-light {
                padding: 6px 10px;
                font-size: 0.7rem;
                min-height: 36px;
            }

            .main-content {
                padding: 0 8px;
                padding-bottom: 20px;
            }

            .page-header {
                padding: 14px;
                margin-bottom: 16px;
            }

            .page-header h5 {
                font-size: 1rem;
            }

            .page-header p {
                font-size: 0.75rem;
            }

            .card {
                border-radius: 12px;
                margin-bottom: 12px;
            }

            .card-header {
                padding: 12px !important;
                font-size: 0.85rem;
            }

            .card-body {
                padding: 12px !important;
            }

            .btn {
                padding: 6px 10px;
                font-size: 0.75rem;
                min-height: 36px;
            }

            .alert {
                padding: 10px 12px;
                font-size: 0.8rem;
                gap: 6px;
            }

            footer {
                padding: 14px 0;
                font-size: 0.75rem;
            }

            .mb-4 {
                margin-bottom: 1rem !important;
            }
        }

        /* ==================== ACCESSIBILITY ==================== */
        button,
        .btn,
        .nav-link {
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

        body,
        html {
            overflow-x: hidden;
        }

        @media (max-width: 768px) {

            input,
            select,
            textarea {
                font-size: 16px !important;
            }
        }

        /* Focus states for accessibility */
        .nav-link:focus,
        .btn:focus,
        .form-control:focus,
        .form-select:focus,
        button:focus {
            outline: 2px solid #1e3a5f;
            outline-offset: 2px;
        }

        /* ==================== UTILITY CLASSES ==================== */
        .gradient-text {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }

        .shadow-gradient {
            box-shadow: 0 10px 40px rgba(30, 58, 95, 0.2);
        }
    </style>
</head>

<body>

    {{-- ── Navbar ────────────────────────────────────────────── --}}
    <nav class="navbar navbar-expand-lg navbar-admin px-2 px-md-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-mortarboard-fill"></i>
                <span>نظام الجداول</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav"
                aria-label="فتح القائمة">
                <i class="bi bi-list"></i>
            </button>

            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav me-auto gap-1 mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link @if (request()->routeIs('admin.dashboard')) active @endif">
                            <i class="bi bi-speedometer2"></i>
                            <span>الرئيسية</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.halls.index') }}"
                            class="nav-link @if (request()->routeIs('admin.halls*')) active @endif">
                            <i class="bi bi-building"></i>
                            <span>القاعات</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.doctors.index') }}"
                            class="nav-link @if (request()->routeIs('admin.doctors*')) active @endif">
                            <i class="bi bi-person-badge"></i>
                            <span>الدكاترة</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.subjects.index') }}"
                            class="nav-link @if (request()->routeIs('admin.subjects*')) active @endif">
                            <i class="bi bi-book"></i>
                            <span>المواد</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.student-groups.index') }}"
                            class="nav-link @if (request()->routeIs('admin.student-groups*')) active @endif">
                            <i class="bi bi-people"></i>
                            <span>الفرق </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.schedules.index') }}"
                            class="nav-link @if (request()->routeIs('admin.schedules*')) active @endif">
                            <i class="bi bi-calendar-week"></i>
                            <span>الجداول</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.students.index') }}"
                            class="nav-link @if (request()->routeIs('admin.students*')) active @endif">
                            <i class="bi bi-mortarboard"></i>
                            <span>الطلاب</span>
                        </a>
                    </li>
                </ul>

                {{-- Admin Info + Logout --}}
                <div
                    class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 gap-lg-3 mt-3 mt-lg-0 border-top border-lg-0 border-opacity-25 pt-3 pt-lg-0">
                    <div class="admin-info">
                        <i class="bi bi-shield-check"></i>
                        <span>مدير النظام</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm w-100">
                            <i class="bi bi-box-arrow-left"></i>
                            <span>خروج</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- ── Main Content ────────────────────────────────────────── --}}
    <div class="container-main">
        <div class="main-content">

            {{-- Page Header --}}
            <div class="page-header">
                <h5>@yield('title', 'الرئيسية')</h5>
                <p>
                    <i class="bi bi-calendar3 me-2"></i>{{ now()->translatedFormat('l، d F Y') }}
                </p>
            </div>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('conflict_error'))
                <div class="alert alert-danger conflict-alert alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>{{ session('conflict_error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    {{-- ── Footer ─────────────────────────────────────────────── --}}
    <footer>
        <div class="container">
            <span><i class="bi bi-mortarboard"></i> نظام إدارة الجداول الجامعية &copy; {{ date('Y') }}</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('#adminNav');

            // Auto-close navbar when a link is clicked
            navbarCollapse.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        navbarToggler.click();
                    }
                });
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
