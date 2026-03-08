{{-- ══════════════════════════════════════════════════════ --}}
{{-- FILE: resources/views/student/dashboard.blade.php     --}}
{{-- ══════════════════════════════════════════════════════ --}}
@extends('layouts.student')
@section('title', 'الرئيسية')
@section('show_banner') @endsection

@section('content')

    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            color: #fff;
            border-radius: 18px;
            padding: 32px;
            margin-bottom: 32px;
            box-shadow: 0 12px 40px rgba(16, 185, 129, 0.3);
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
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

        .dashboard-header>* {
            position: relative;
            z-index: 1;
        }

        .dashboard-header:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(16, 185, 129, 0.4);
        }

        .dashboard-header .avatar {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            flex-shrink: 0;
        }

        .dashboard-header h5 {
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .dashboard-header p {
            opacity: 0.9;
            font-weight: 500;
            margin: 0;
            font-size: 0.95rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid rgba(16, 185, 129, 0.2);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
            z-index: 0;
        }

        .stat-card>* {
            position: relative;
            z-index: 1;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(16, 185, 129, 0.2);
            border-color: rgba(16, 185, 129, 0.4);
        }

        .stat-card .stat-icon {
            font-size: 2.5rem;
            color: #10b981;
            margin-bottom: 12px;
            display: block;
        }

        .stat-card .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #065f46;
            margin-bottom: 8px;
            letter-spacing: -1px;
        }

        .stat-card .stat-label {
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .schedule-card {
            /* background: #fff; */
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 5px solid #10b981;
            margin-bottom: 24px;
        }

        .schedule-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #34d399 0%, #10b981 100%);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .schedule-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(16, 185, 129, 0.15);
            border-right-color: #34d399;
        }

        .schedule-card:hover::after {
            transform: scaleX(1);
        }

        .schedule-card .card-header {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: none;
            padding: 20px 24px;
            font-weight: 700;
            color: #065f46;
            font-size: 1.1rem;
            letter-spacing: 0.3px;
        }

        .schedule-card .card-header .badge {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-left: auto;
        }

        .lecture-item {
            padding: 20px 24px;
            border-bottom: 1px solid #f0fdf4;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .lecture-item:last-child {
            border-bottom: none;
        }

        .lecture-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, #10b981 0%, #34d399 100%);
            transform: scaleY(0);
            transform-origin: top;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .lecture-item:hover::before {
            transform: scaleY(1);
        }

        .lecture-item:hover {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        }

        .lecture-item>* {
            position: relative;
            z-index: 1;
        }

        .lecture-time {
            min-width: 70px;
            text-align: center;
        }

        .lecture-time .time {
            font-weight: 800;
            color: #10b981;
            font-size: 1.1rem;
        }

        .lecture-time .period {
            font-size: 0.7rem;
            color: #9ca3af;
            margin-top: 2px;
        }

        .lecture-info {
            flex: 1;
        }

        .lecture-subject {
            font-weight: 700;
            color: #1f2937;
            font-size: 0.95rem;
            margin-bottom: 6px;
        }

        .lecture-details {
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 500;
        }

        .lecture-details i {
            color: #10b981;
            margin-right: 4px;
        }

        .lecture-type {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
        }

        .lecture-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .lecture-badge.lecture {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
        }

        .lecture-badge.lab {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .lecture-time-range {
            font-size: 0.75rem;
            color: #9ca3af;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 4rem;
            color: #d1fae5;
            margin-bottom: 16px;
            display: block;
        }

        .empty-state p {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .upcoming-card {
            background: #fff;
            border-radius: 14px;
            padding: 18px;
            border-right: 4px solid #10b981;
            transition: all 0.3s ease;
            margin-bottom: 12px;
        }

        .upcoming-card:hover {
            transform: translateX(8px);
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.12);
            border-right-color: #34d399;
        }

        .upcoming-date {
            display: inline-block;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            color: #065f46;
            padding: 8px 14px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.8rem;
            border: 1px solid rgba(16, 185, 129, 0.2);
            margin-bottom: 12px;
        }

        .upcoming-subject {
            font-weight: 700;
            color: #1f2937;
            font-size: 0.95rem;
            margin-bottom: 6px;
        }

        .upcoming-details {
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .upcoming-time {
            font-size: 0.85rem;
            color: #10b981;
            font-weight: 700;
        }

        .view-all-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .view-all-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-header {
                padding: 24px;
                margin-bottom: 24px;
            }

            .dashboard-header h5 {
                font-size: 1.2rem;
            }

            .stat-card {
                padding: 20px;
                margin-bottom: 16px;
            }

            .stat-card .stat-icon {
                font-size: 2rem;
            }

            .stat-card .stat-number {
                font-size: 1.6rem;
            }

            .lecture-item {
                padding: 16px;
                gap: 12px;
                flex-wrap: wrap;
            }

            .lecture-type {
                width: 100%;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .schedule-card .card-header {
                padding: 16px;
            }
        }

        @media (max-width: 480px) {
            .dashboard-header {
                padding: 20px;
                flex-direction: column;
                text-align: center;
            }

            .dashboard-header .avatar {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
                margin: 0 auto;
            }

            .dashboard-header h5 {
                font-size: 1.1rem;
            }

            .dashboard-header p {
                font-size: 0.85rem;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-card .stat-number {
                font-size: 1.4rem;
            }

            .lecture-item {
                padding: 14px;
                gap: 10px;
            }

            .lecture-time {
                min-width: 60px;
            }

            .lecture-time .time {
                font-size: 0.95rem;
            }

            .schedule-card .card-header {
                font-size: 0.95rem;
                padding: 14px;
            }
        }
    </style>

    {{-- ── Welcome + Group Info ─────────────────────────────── --}}
    <div class="row g-3 mb-4">
        {{-- Welcome Card --}}
        <div class="col-lg-6">
            <div class="dashboard-header d-flex align-items-center gap-4">
                <div class="avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <h5>أهلاً، {{ auth()->user()->name }} 👋</h5>
                    <p>
                        <i class="bi bi-people me-2"></i>{{ auth()->user()->studentGroup->name ?? 'غير محدد' }}
                        &nbsp;·&nbsp;
                        <i class="bi bi-calendar me-2"></i>{{ auth()->user()->studentGroup->study_days ?? '—' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="col-lg-3">
            <div class="stat-card">
                <span class="stat-icon"><i class="bi bi-calendar-check"></i></span>
                <div class="stat-number">{{ $totalLecture ?? 0 }}</div>
                <div class="stat-label">إجمالي المحاضرات</div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="stat-card">
                <span class="stat-icon"><i class="bi bi-pc-display"></i></span>
                <div class="stat-number">{{ $totalLabs ?? 0 }}</div>
                <div class="stat-label">إجمالي السكاشن</div>
            </div>
        </div>
    </div>

    {{-- ── Today's Lectures ─────────────────────────────────── --}}
    @if ($todaySchedules->where('type', 'lecture')->count() > 0)
         <div class="schedule-card">
        <div class="card-header d-flex align-items-center">
            <span><i class="bi bi-sun me-2"></i>محاضرات اليوم</span>
            <span class="badge">{{ $todaySchedules->where('type', 'lecture')->count() }}</span>
        </div>
        @forelse($todaySchedules->where('type', 'lecture') as $s)
            <div class="lecture-item">
                <div class="lecture-time">
                    <div class="time">{{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }}</div>
                    <div class="period">{{ \Carbon\Carbon::parse($s->start_time)->format('A') }}</div>
                </div>
                <div class="lecture-info">
                    <div class="lecture-subject">{{ $s->subject->name }}</div>
                    <div class="lecture-details">
                        <i class="bi bi-person-badge"></i>{{ $s->doctor?->name ?? 'غير محدد' }}
                        &nbsp;·&nbsp;
                        <i class="bi bi-geo-alt"></i>{{ $s->hall?->name ?? 'غير محدد' }}
                    </div>
                </div>
                <div class="lecture-type">
                    <span class="lecture-badge lecture">محاضرة</span>
                    <div class="lecture-time-range">{{ $s->start_time }} – {{ $s->end_time }}</div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-calendar-x"></i>
                <p>لا توجد محاضرات اليوم 🎉</p>
            </div>
        @endforelse
    </div>
    @endif

    {{-- ── Today's Labs/Sections ─────────────────────────────────── --}}
    @if ($todaySchedules->where('type', 'lab')->count())
        <div class="schedule-card">
            <div class="card-header d-flex align-items-center">
                <span><i class="bi bi-sun me-2"></i>سكاشن اليوم</span>
                <span class="badge">{{ $todaySchedules->where('type', 'lab')->count() }}</span>
            </div>
            @foreach($todaySchedules->where('type', 'lab') as $s)
                <div class="lecture-item">
                    <div class="lecture-time">
                        <div class="time">{{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }}</div>
                        <div class="period">{{ \Carbon\Carbon::parse($s->start_time)->format('A') }}</div>
                    </div>
                    <div class="lecture-info">
                        <div class="lecture-subject">{{ $s->subject->name }}</div>
                        <div class="lecture-details">
                            <i class="bi bi-person-badge"></i>{{ $s->doctor?->name ?? 'غير محدد' }}
                            &nbsp;·&nbsp;
                            <i class="bi bi-geo-alt"></i>{{ $s->hall?->name ?? 'غير محدد' }}
                        </div>
                    </div>
                    <div class="lecture-type">
                        <span class="lecture-badge lab">معمل</span>
                        @if ($s->sections->count() > 0)
                            <span class="badge badge-warning section">
                                أقسام: {{ $s->sections->pluck('id')->join(', ') }}
                            </span>
                        @endif
                        <div class="lecture-time-range">{{ $s->start_time }} – {{ $s->end_time }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- ── Upcoming Lectures (Next 3) ──────────────────────── --}}
    @if ($upcomingSchedules->count())
        <div class="schedule-card">
            <div class="card-header">
                <i class="bi bi-clock-history me-2"></i>المحاضرات القادمة
            </div>
            <div style="padding: 20px 24px;">
                @foreach ($upcomingSchedules as $s)
                    <div class="upcoming-card">
                        <div class="upcoming-date">
                            {{ $s->day_of_week_label }}
                        </div>
                        <div class="upcoming-subject">{{ $s->subject->name }}</div>
                        <div class="upcoming-details">
                            <i class="bi bi-person-badge me-1"></i>{{ $s->doctor?->name ?? 'غير محدد' }} ·
                            <i class="bi bi-geo-alt me-1"></i>{{ $s->hall?->name ?? 'غير محدد' }}
                        </div>
                        <div class="upcoming-time">
                            <i class="bi bi-clock me-1"></i>{{ $s->start_time }} – {{ $s->end_time }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="padding: 0 24px 20px;">
                <a href="{{ route('student.schedule') }}" class="view-all-btn">
                    عرض الجدول كاملاً
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
        </div>
    @endif

@endsection
