
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'جدولي الدراسي') | الجامعة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root { --student-color: #198754; --student-light: #d1e7dd; }

        body { background: #f0f7f4; font-family: 'Segoe UI', Tahoma, sans-serif; }

        /* ── Navbar ── */
        .navbar-student {
            background: linear-gradient(135deg, #198754, #0f5132);
            box-shadow: 0 2px 12px rgba(25,135,84,.3);
        }
        .navbar-student .navbar-brand { color: #fff; font-weight: bold; font-size: 1.1rem; }
        .navbar-student .nav-link     { color: rgba(255,255,255,.85); }
        .navbar-student .nav-link:hover,
        .navbar-student .nav-link.active { color: #fff; background: rgba(255,255,255,.15); border-radius: 8px; }

        /* ── Student Info Card ── */
        .student-info-card {
            background: linear-gradient(135deg, #198754, #20c997);
            color: #fff;
            border-radius: 16px;
            padding: 20px 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(25,135,84,.25);
        }
        .student-info-card .avatar {
            width: 55px; height: 55px;
            background: rgba(255,255,255,.25);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
        }

        /* ── Cards ── */
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.07); }
        .card-header { border-radius: 12px 12px 0 0 !important; }

        /* ── Schedule Day Card ── */
        .day-card { border-right: 4px solid var(--student-color) !important; }
        .lecture-item { transition: background .2s; }
        .lecture-item:hover { background: #f8f9fa; }

        /* ── Flash Messages ── */
        .alert { border-radius: 10px; }

        /* ── Footer ── */
        footer { background: #e9f5ee; color: #6c757d; font-size: .85rem; }
    </style>
</head>
<body>

{{-- ── Navbar ────────────────────────────────────────────── --}}
<nav class="navbar navbar-expand-lg navbar-student px-3 mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('student.dashboard') }}">
            <i class="bi bi-mortarboard-fill me-2"></i>بوابة الطالب
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#studentNav">
            <i class="bi bi-list text-white fs-4"></i>
        </button>

        <div class="collapse navbar-collapse" id="studentNav">
            <ul class="navbar-nav me-auto gap-1">
                <li class="nav-item">
                    <a href="{{ route('student.dashboard') }}"
                       class="nav-link px-3 py-2 @if(request()->routeIs('student.dashboard')) active @endif">
                        <i class="bi bi-house me-1"></i>الرئيسية
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('student.schedule') }}"
                       class="nav-link px-3 py-2 @if(request()->routeIs('student.schedule')) active @endif">
                        <i class="bi bi-calendar3 me-1"></i>جدولي الدراسي
                    </a>
                </li>
            </ul>

            {{-- User Info + Logout --}}
            <div class="d-flex align-items-center gap-3">
                <span class="text-white opacity-75 small">
                    <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-light">
                        <i class="bi bi-box-arrow-left me-1"></i>خروج
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

{{-- ── Main Content ────────────────────────────────────────── --}}
<div class="container pb-5">

    {{-- Student Info Banner --}}
    @hasSection('show_banner')
    <div class="student-info-card d-flex align-items-center gap-3">
        <div class="avatar"><i class="bi bi-person-fill"></i></div>
        <div>
            <h5 class="mb-0 fw-bold">{{ auth()->user()->name }}</h5>
            <small class="opacity-75">
                <i class="bi bi-people me-1"></i>
                {{ auth()->user()->studentGroup->name ?? 'غير محدد' }} ·
                أيام الدراسة: {{ auth()->user()->studentGroup->study_days ?? '—' }}
            </small>
        </div>
    </div>
    @endif

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show mb-4">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

{{-- ── Footer ─────────────────────────────────────────────── --}}
<footer class="text-center py-3 mt-auto">
    <div class="container">
        <span><i class="bi bi-mortarboard text-success me-1"></i>نظام إدارة الجداول الجامعية &copy; {{ date('Y') }}</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>