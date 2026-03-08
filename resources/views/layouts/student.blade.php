<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'جدولي الدراسي') | الجامعة</title>
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
            --primary-gradient: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            --secondary-gradient: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            --accent-gradient: linear-gradient(135deg, #6ee7b7 0%, #a7f3d0 100%);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --student-color: #10b981;
            --white: #ffffff;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Cairo', 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            color: #1f2937;
            overflow-x: hidden;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ==================== NAVBAR STYLES ==================== */
        .navbar-student {
            background: var(--primary-gradient);
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
            padding: 16px 0;
            border-bottom: none;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        /* Animated navbar background */
        .navbar-student::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .navbar-student > * {
            position: relative;
            z-index: 1;
        }

        .navbar-student .navbar-brand {
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

        .navbar-student .navbar-brand:hover {
            transform: translateY(-2px);
        }

        .navbar-student .navbar-brand i {
            font-size: 1.5rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .navbar-student .navbar-toggler {
            min-width: 48px;
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .navbar-student .navbar-toggler:focus {
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.3);
        }

        .navbar-student .nav-link {
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

        .navbar-student .nav-link::before {
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

        .navbar-student .nav-link:hover::before {
            left: 0;
        }

        .navbar-student .nav-link:hover,
        .navbar-student .nav-link.active {
            color: #fff;
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
            font-weight: 700;
        }

        .navbar-student .nav-link i {
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .navbar-student .nav-link:hover i {
            transform: scale(1.2) rotate(10deg);
        }

        .navbar-student .nav-link.active i {
            transform: scale(1.25);
        }

        /* User Info Section */
        .navbar-student .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
        }

        .navbar-student .user-info i {
            font-size: 1.3rem;
        }

        .navbar-student .user-info span {
            font-size: 0.95rem;
        }

        .navbar-student .btn-outline-light {
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

        .navbar-student .btn-outline-light:hover {
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

        /* ==================== STUDENT INFO CARD ==================== */
        .student-info-card {
            background: var(--primary-gradient);
            color: #fff;
            border-radius: 18px;
            padding: 28px;
            margin-bottom: 32px;
            box-shadow: 0 12px 40px rgba(16, 185, 129, 0.3);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .student-info-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .student-info-card > * {
            position: relative;
            z-index: 1;
        }

        .student-info-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px rgba(16, 185, 129, 0.4);
        }

        .student-info-card .avatar {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            flex-shrink: 0;
        }

        .student-info-card h5 {
            font-weight: 800;
            font-size: 1.3rem;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .student-info-card small {
            font-weight: 500;
            opacity: 0.9;
            font-size: 0.95rem;
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
            box-shadow: 0 16px 40px rgba(16, 185, 129, 0.15);
            transform: translateY(-8px);
        }

        .card:hover::after {
            transform: scaleX(1);
        }

        .card-header {
            border-radius: 16px 16px 0 0 !important;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-bottom: none;
            padding: 24px !important;
            font-weight: 700;
            color: #065f46;
            font-size: 1.1rem;
            letter-spacing: 0.3px;
        }

        .card-body {
            padding: 24px !important;
        }

        /* ==================== DAY CARD STYLES ==================== */
        .day-card {
            border-right: 5px solid var(--student-color) !important;
            transition: all 0.3s ease;
        }

        .day-card:hover {
            border-right-color: #f093fb;
        }

        /* ==================== LECTURE ITEM ==================== */
        .lecture-item {
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            border-left: 4px solid var(--student-color);
            position: relative;
            overflow: hidden;
        }

        .lecture-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(16, 185, 129, 0.05);
            transition: left 0.3s ease;
            z-index: 0;
        }

        .lecture-item:hover::before {
            left: 0;
        }

        .lecture-item > * {
            position: relative;
            z-index: 1;
        }

        .lecture-item:hover {
            background: #fff;
            transform: translateX(8px);
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.12);
            /* border-left-color: #f093fb; */
        }

        .lecture-item small {
            color: #6b7280;
            font-weight: 600;
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
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
            color: white;
        }

        /* ==================== FOOTER ==================== */
        footer {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            color: #6b7280;
            font-size: 0.9rem;
            padding: 28px 0;
            border-top: 1px solid rgba(16, 185, 129, 0.15);
            text-align: center;
            font-weight: 600;
            margin-top: auto;
            letter-spacing: 0.3px;
        }

        footer i {
            color: var(--student-color);
            font-size: 1.1rem;
        }

        /* ==================== FORM ELEMENTS ==================== */
        .form-control,
        .form-select {
            border: 2px solid #d1fae5;
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
            border-color: var(--student-color);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
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
            .navbar-student .navbar-brand {
                font-size: 1.1rem;
            }

            .student-info-card {
                padding: 24px;
            }

            .card-header {
                font-size: 1rem;
            }
        }

        /* ==================== RESPONSIVE MOBILE ==================== */
        @media(max-width: 768px) {
            body {
                background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            }

            .navbar-student {
                padding: 12px 0;
            }

            .navbar-student .navbar-brand {
                font-size: 1rem;
            }

            .navbar-student .nav-link {
                padding: 10px 14px !important;
                margin: 2px 2px;
                font-size: 0.85rem;
            }

            .navbar-student .user-info {
                margin-top: 12px;
                font-size: 0.85rem;
            }

            .container {
                padding: 0 12px;
                padding-bottom: 30px;
            }

            .student-info-card {
                padding: 20px;
                margin-bottom: 24px;
                border-radius: 14px;
            }

            .student-info-card h5 {
                font-size: 1.15rem;
            }

            .student-info-card .avatar {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
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

            .lecture-item {
                padding: 14px;
                margin-bottom: 10px;
                border-radius: 10px;
            }

            .alert {
                padding: 14px 16px;
                font-size: 0.9rem;
                gap: 10px;
            }

            .btn {
                padding: 10px 16px;
                font-size: 0.8rem;
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
            .navbar-student .navbar-brand {
                font-size: 0.95rem;
            }

            .navbar-student .collapse {
                margin-top: 12px;
                padding: 12px;
                background: rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }

            .navbar-student .nav-link {
                padding: 9px 12px !important;
                font-size: 0.8rem;
            }

            .container {
                padding: 0 10px;
                padding-bottom: 25px;
            }

            .student-info-card {
                padding: 16px;
                margin-bottom: 20px;
            }

            .student-info-card h5 {
                font-size: 1.05rem;
            }

            .student-info-card small {
                font-size: 0.8rem;
            }

            .student-info-card .avatar {
                width: 45px;
                height: 45px;
                font-size: 1.3rem;
            }

            .card-header {
                padding: 14px !important;
                font-size: 0.9rem;
            }

            .card-body {
                padding: 14px !important;
            }

            .lecture-item {
                padding: 12px;
                font-size: 0.85rem;
            }

            .alert {
                padding: 12px 14px;
                font-size: 0.85rem;
            }

            .btn {
                padding: 8px 12px;
                font-size: 0.75rem;
                min-height: 38px;
                gap: 6px;
            }

            h5 {
                font-size: 1.1rem;
            }

            h6 {
                font-size: 0.95rem;
            }

            footer {
                padding: 16px 0;
                font-size: 0.8rem;
            }
        }

        /* ==================== RESPONSIVE EXTRA SMALL ==================== */
        @media(max-width: 480px) {
            .navbar-student {
                padding: 10px 0;
            }

            .navbar-student .navbar-brand {
                font-size: 0.85rem;
                gap: 6px;
            }

            .navbar-student .navbar-brand i {
                font-size: 1.2rem;
            }

            .navbar-student .collapse {
                margin-top: 10px;
            }

            .navbar-student .nav-link {
                padding: 8px 10px !important;
                font-size: 0.75rem;
            }

            .navbar-student .user-info {
                font-size: 0.75rem;
                gap: 8px;
                margin-top: 10px;
            }

            .navbar-student .btn-outline-light {
                padding: 6px 10px;
                font-size: 0.7rem;
                min-height: 36px;
            }

            .container {
                padding: 0 8px;
                padding-bottom: 20px;
            }

            .student-info-card {
                padding: 14px;
                margin-bottom: 16px;
                flex-direction: column;
                text-align: center;
            }

            .student-info-card .avatar {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
                margin: 0 auto;
            }

            .student-info-card h5 {
                font-size: 0.95rem;
            }

            .student-info-card small {
                font-size: 0.7rem;
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

            .lecture-item {
                padding: 10px;
                font-size: 0.8rem;
                margin-bottom: 8px;
            }

            .alert {
                padding: 10px 12px;
                font-size: 0.8rem;
                gap: 6px;
            }

            .btn {
                padding: 6px 10px;
                font-size: 0.7rem;
                min-height: 36px;
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
            outline: 2px solid var(--student-color);
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
            box-shadow: 0 10px 40px rgba(16, 185, 129, 0.2);
        }
    </style>
</head>
<body>

    {{-- ── Navbar ────────────────────────────────────────────── --}}
    <nav class="navbar navbar-expand-lg navbar-student px-2 px-md-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('student.dashboard') }}">
                <i class="bi bi-mortarboard-fill"></i>
                <span>بوابة الطالب</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#studentNav" aria-label="فتح القائمة">
                <i class="bi bi-list"></i>
            </button>

            <div class="collapse navbar-collapse" id="studentNav">
                <ul class="navbar-nav me-auto gap-1 mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a href="{{ route('student.dashboard') }}"
                           class="nav-link @if(request()->routeIs('student.dashboard')) active @endif mx-2">
                            <i class="bi bi-house mx-2"></i>
                            <span>الرئيسية</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.schedule') }}"
                           class="nav-link @if(request()->routeIs('student.schedule')) active @endif mx-2">
                            <i class="bi bi-calendar3 mx-2"></i>
                            <span>جدولي الدراسي</span>
                        </a>
                    </li>
                </ul>

                {{-- User Info + Logout --}}
                <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 gap-lg-3 mt-3 mt-lg-0 border-top border-lg-0 border-opacity-25 pt-3 pt-lg-0">
                    <div class="user-info">
                        <i class="bi bi-person-circle"></i>
                        <span>{{ auth()->user()->name }}</span>
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
    <div class="container my-4">

        {{-- Student Info Banner --}}
        @hasSection('show_banner')
        <div class="student-info-card d-flex align-items-center gap-3 my-4">
            <div class="avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <h5>{{ auth()->user()->name }}</h5>
                <small>
                    <i class="bi bi-people me-1"></i>
                    {{ auth()->user()->studentGroup->name ?? 'غير محدد' }} ·
                    أيام الدراسة: {{ auth()->user()->studentGroup->study_days ?? '—' }}
                </small>
            </div>
        </div>
        @endif

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
            const navbarCollapse = document.querySelector('#studentNav');

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