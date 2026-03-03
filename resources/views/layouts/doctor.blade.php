
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'بوابة الدكتور') | الجامعة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root { --doctor-color: #0d6efd; --doctor-dark: #084298; }

        body { background: #f0f4ff; font-family: 'Segoe UI', Tahoma, sans-serif; }

        /* ── Sidebar ── */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #0d2d6e 0%, #1a4a9e 100%);
            position: fixed;
            top: 0; right: 0;
            box-shadow: -3px 0 15px rgba(0,0,0,.15);
            z-index: 100;
        }
        .sidebar .logo {
            padding: 22px 20px;
            border-bottom: 1px solid rgba(255,255,255,.1);
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
        }
        .sidebar .doctor-card {
            margin: 15px 12px;
            background: rgba(255,255,255,.1);
            border-radius: 12px;
            padding: 14px;
            color: #fff;
        }
        .sidebar .doctor-card .avatar {
            width: 45px; height: 45px;
            background: rgba(255,255,255,.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 11px 20px;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all .2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,.15);
            color: #fff;
            padding-right: 25px;
        }
        .sidebar .nav-link .badge { font-size: .65rem; }
        .sidebar hr { border-color: rgba(255,255,255,.1); margin: 8px 15px; }

        /* ── Main Content ── */
        .main-content { margin-right: 260px; padding: 28px; min-height: 100vh; }

        /* ── Top Bar ── */
        .top-bar {
            background: #fff;
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-bar .date-badge {
            background: #eef2ff;
            color: #3b5bdb;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: .85rem;
            font-weight: 500;
        }

        /* ── Cards ── */
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.07); }
        .card-header { border-radius: 12px 12px 0 0 !important; }

        /* ── Stat Mini Cards ── */
        .mini-stat {
            background: #fff;
            border-radius: 10px;
            padding: 14px 18px;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
            border-right: 3px solid var(--doctor-color);
        }

        /* ── Schedule Timeline ── */
        .timeline-item { border-right: 3px solid #dee2e6; padding-right: 20px; position: relative; margin-bottom: 20px; }
        .timeline-item::before {
            content: '';
            width: 12px; height: 12px;
            background: var(--doctor-color);
            border-radius: 50%;
            position: absolute;
            right: -7px; top: 4px;
        }
        .timeline-item.lab::before { background: #198754; }

        /* ── Responsive ── */
        @media(max-width: 768px) {
            .sidebar { width: 100%; min-height: auto; position: relative; }
            .main-content { margin-right: 0; padding: 15px; }
        }
    </style>
</head>
<body>

{{-- ── Sidebar ─────────────────────────────────────────────── --}}
<div class="sidebar">
    {{-- Logo --}}
    <div class="logo">
        <i class="bi bi-mortarboard-fill me-2 text-warning"></i>بوابة الدكتور
    </div>

    {{-- Doctor Info Card --}}
    <div class="doctor-card d-flex align-items-center gap-2">
        <div class="avatar"><i class="bi bi-person-fill"></i></div>
        <div>
            <div class="fw-bold small">{{ auth()->user()->name }}</div>
            <div class="opacity-75" style="font-size:.75rem">
                {{ auth()->user()->doctor->department ?? 'عضو هيئة تدريس' }}
            </div>
        </div>
    </div>

    {{-- Nav Links --}}
    <nav class="nav flex-column mt-1">
        <a href="{{ route('doctor.dashboard') }}"
           class="nav-link @if(request()->routeIs('doctor.dashboard')) active @endif">
            <i class="bi bi-speedometer2 me-2"></i>الرئيسية
        </a>
        <a href="{{ route('doctor.schedule') }}"
           class="nav-link @if(request()->routeIs('doctor.schedule')) active @endif">
            <i class="bi bi-calendar-week me-2"></i>جدولي الدراسي
            @php
                $todayCount = \App\Models\Schedule::where('doctor_id', auth()->user()->doctor_id)
                    ->where('date', today())->count();
            @endphp
            @if($todayCount)
                <span class="badge bg-warning text-dark ms-auto">{{ $todayCount }} اليوم</span>
            @endif
        </a>

        <hr>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="nav-link border-0 bg-transparent w-100 text-start text-danger">
                <i class="bi bi-box-arrow-left me-2"></i>تسجيل الخروج
            </button>
        </form>
    </nav>
</div>

{{-- ── Main Content ─────────────────────────────────────────── --}}
<div class="main-content">

    {{-- Top Bar --}}
    <div class="top-bar">
        <h5 class="mb-0 fw-bold text-dark">@yield('title', 'الرئيسية')</h5>
        <span class="date-badge">
            <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('l، d F Y') }}
        </span>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>