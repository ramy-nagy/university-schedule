<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'بوابة الدكتور') | الجامعة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --doctor-color: #667eea;
            --white: #ffffff;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Cairo', 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #2d3748;
            overflow-x: hidden;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ==================== NAVBAR STYLES ==================== */
        .navbar-doctor {
            background: var(--primary-gradient);
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
            padding: 16px 0;
            border-bottom: none;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        /* Animated navbar background */
        .navbar-doctor::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(245, 87, 108, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .navbar-doctor > * {
            position: relative;
            z-index: 1;
        }

        .navbar-doctor .navbar-brand {
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

        .navbar-doctor .navbar-brand:hover {
            transform: translateY(-2px);
        }

        .navbar-doctor .navbar-brand i {
            font-size: 1.5rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .navbar-doctor .navbar-toggler {
            min-width: 48px;
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: none;
        }

        .navbar-doctor .navbar-toggler:focus {
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.3);
        }

        .navbar-doctor .nav-link {
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

        .navbar-doctor .nav-link::before {
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

        .navbar-doctor .nav-link:hover::before {
            left: 0;
        }

        .navbar-doctor .nav-link:hover,
        .navbar-doctor .nav-link.active {
            color: #fff;
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
            font-weight: 700;
        }

        .navbar-doctor .nav-link i {
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .navbar-doctor .nav-link:hover i {
            transform: scale(1.2) rotate(10deg);
        }

        .navbar-doctor .nav-link.active i {
            transform: scale(1.25);
        }

        .navbar-doctor .nav-link .badge {
            font-size: 0.7rem;
            margin-left: 6px;
            padding: 4px 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Doctor Info Section */
        .navbar-doctor .doctor-info {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
        }

        .navbar-doctor .doctor-info .avatar {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .navbar-doctor .doctor-info-text {
            display: flex;
            flex-direction: column;
        }

        .navbar-doctor .doctor-name {
            font-size: 0.95rem;
            font-weight: 700;
        }

        .navbar-doctor .doctor-department {
            font-size: 0.75rem;
            opacity: 0.85;
            font-weight: 500;
        }

        .navbar-doctor .btn-outline-light {
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

        .navbar-doctor .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            color: #fff;
        }

        /* ==================== MAIN CONTAINER ==================== */
        .container {
            flex: 1;
            padding-bottom: 40px;
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
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.15);
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
            background: var(--white);
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
            box-shadow: 0 16px 40px rgba(102, 126, 234, 0.2);
            transform: translateY(-8px);
        }

        .card:hover::after {
            transform: scaleX(1);
        }

        .card-header {
            border-radius: 16px 16px 0 0 !important;
            /* background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); */
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

        /* ==================== MINI STAT CARDS ==================== */
        .mini-stat {
            background: var(--white);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            border-right: 5px solid var(--doctor-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .mini-stat::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .mini-stat:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(102, 126, 234, 0.2);
            border-right-color: #f093fb;
        }

        .mini-stat > * {
            position: relative;
            z-index: 1;
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

        .alert-warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(245, 158, 11, 0.05) 100%);
            color: #78350f;
            border-left: 5px solid var(--warning);
        }

        .alert .btn-close {
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }

        .alert .btn-close:hover {
            opacity: 1;
        }

        /* ==================== BUTTON STYLES ==================== */
        .btn {
            border: none;
            border-radius: 10px;
            font-weight: 700;
            padding: 12px 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            gap: 8px;
            cursor: pointer;
            letter-spacing: 0.3px;
            font-size: 0.95rem;
            text-transform: uppercase;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            color: white;
        }

        /* ==================== FOOTER ==================== */
        footer {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            color: #6b7280;
            font-size: 0.9rem;
            padding: 28px 0;
            border-top: 1px solid rgba(102, 126, 234, 0.15);
            text-align: center;
            font-weight: 600;
            margin-top: auto;
            letter-spacing: 0.3px;
        }

        footer i {
            color: var(--doctor-color);
            font-size: 1.1rem;
        }

        /* ==================== FORM ELEMENTS ==================== */
        .form-control,
        .form-select {
            border: 2px solid #e2e8f0;
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
            border-color: var(--doctor-color);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
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

        .badge-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .badge-info {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
        }

        /* ==================== RESPONSIVE TABLET ==================== */
        @media(max-width: 992px) {
            .navbar-doctor .navbar-brand {
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

            .navbar-doctor {
                padding: 12px 0;
            }

            .navbar-doctor .navbar-brand {
                font-size: 1rem;
            }

            .navbar-doctor .nav-link {
                padding: 10px 14px !important;
                margin: 2px 2px;
                font-size: 0.85rem;
            }

            .navbar-doctor .doctor-info {
                margin-top: 12px;
                font-size: 0.85rem;
            }

            .navbar-doctor .collapse {
                margin-top: 12px;
                padding: 12px;
                background: rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }

            .container {
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

            .mini-stat {
                padding: 16px;
                margin-bottom: 12px;
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
            .navbar-doctor .navbar-brand {
                font-size: 0.95rem;
                gap: 6px;
            }

            .navbar-doctor .navbar-brand i {
                font-size: 1.2rem;
            }

            .navbar-doctor .doctor-info-text {
                display: none;
            }

            .container {
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

            .mini-stat {
                padding: 14px;
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
            .navbar-doctor {
                padding: 10px 0;
            }

            .navbar-doctor .navbar-brand {
                font-size: 0.85rem;
                gap: 6px;
            }

            .navbar-doctor .navbar-brand i {
                font-size: 1.1rem;
            }

            .navbar-doctor .nav-link {
                padding: 8px 10px !important;
                font-size: 0.75rem;
            }

            .navbar-doctor .btn-outline-light {
                padding: 6px 10px;
                font-size: 0.7rem;
                min-height: 36px;
            }

            .container {
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

            .mini-stat {
                padding: 12px;
                margin-bottom: 10px;
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
            outline: 2px solid var(--doctor-color);
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
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
        }
    </style>
</head>
<body>

    {{-- ── Navbar ────────────────────────────────────────────── --}}
    <nav class="navbar navbar-expand-lg navbar-doctor px-2 px-md-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('doctor.dashboard') }}">
                <i class="bi bi-mortarboard-fill"></i>
                <span>بوابة الدكتور</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#doctorNav" aria-label="فتح القائمة">
                <i class="bi bi-list"></i>
            </button>

            <div class="collapse navbar-collapse" id="doctorNav">
                <ul class="navbar-nav me-auto gap-1 mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a href="{{ route('doctor.dashboard') }}"
                           class="nav-link @if(request()->routeIs('doctor.dashboard')) active @endif">
                            <i class="bi bi-speedometer2 mx-2"></i>
                            <span>الرئيسية</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('doctor.schedule') }}"
                           class="nav-link @if(request()->routeIs('doctor.schedule')) active @endif">
                            <i class="bi bi-calendar-week mx-2"></i>
                            <span>جدولي الدراسي</span>
                            @php
                                $todayCount = \App\Models\Schedule::where('doctor_id', auth()->user()->doctor_id)
                                    ->where('date', today())->count();
                            @endphp
                            @if($todayCount)
                                <span class="badge badge-warning">{{ $todayCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>

                {{-- Doctor Info + Logout --}}
                <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 gap-lg-3 mt-3 mt-lg-0 border-top border-lg-0 border-opacity-25 pt-3 pt-lg-0">
                    <div class="doctor-info">
                        <div class="avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="doctor-info-text">
                            <div class="doctor-name">{{ auth()->user()->name }}</div>
                            <div class="doctor-department">
                                {{ auth()->user()->doctor->department ?? 'عضو هيئة تدريس' }}
                            </div>
                        </div>
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
    <div class="container mt-4">

        {{-- Page Header --}}
        <div class="page-header">
            <h5>@yield('title', 'الرئيسية')</h5>
            <p>
                <i class="bi bi-calendar3 me-2"></i>{{ now()->translatedFormat('l، d F Y') }}
            </p>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>{{ session('warning') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
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
            const navbarCollapse = document.querySelector('#doctorNav');

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