
@extends('layouts.doctor')
@section('title', 'الرئيسية')

@section('content')

{{-- ── Mini Stats Row ───────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="mini-stat">
            <div class="text-muted small mb-1">محاضرات اليوم</div>
            <div class="fw-bold fs-4 text-primary">{{ $todayCount }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mini-stat" style="border-color:#198754">
            <div class="text-muted small mb-1">هذا الأسبوع</div>
            <div class="fw-bold fs-4 text-success">{{ $weekCount }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mini-stat" style="border-color:#fd7e14">
            <div class="text-muted small mb-1">إجمالي المواد</div>
            <div class="fw-bold fs-4 text-warning">{{ $subjectsCount }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mini-stat" style="border-color:#6f42c1">
            <div class="text-muted small mb-1">إجمالي الجداول</div>
            <div class="fw-bold fs-4 text-purple" style="color:#6f42c1">{{ $totalCount }}</div>
        </div>
    </div>
</div>

{{-- ── Today Timeline ───────────────────────────────────── --}}
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-sun me-2"></i>جدول اليوم — {{ now()->translatedFormat('l') }}
            </div>
            <div class="card-body">
                @forelse($todaySchedules as $s)
                <div class="timeline-item {{ $s->type }}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-bold">{{ $s->subject->name }}</div>
                            <div class="text-muted small">
                                <i class="bi bi-people me-1"></i>{{ $s->studentGroup->name }}
                                &nbsp;·&nbsp;
                                <i class="bi bi-geo-alt me-1"></i>{{ $s->hall->name }}
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge {{ $s->type==='lecture'?'bg-primary':'bg-success' }}">
                                {{ $s->type==='lecture'?'محاضرة':'معمل' }}
                            </span>
                            <div class="text-muted small mt-1">{{ $s->start_time }} – {{ $s->end_time }}</div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>لا توجد محاضرات اليوم 🎉
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Upcoming Lectures --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-clock-history me-2"></i>المحاضرات القادمة
            </div>
            <div class="card-body p-0">
                @forelse($upcomingSchedules as $s)
                <div class="d-flex align-items-center px-3 py-3 border-bottom">
                    <div class="me-3 text-center" style="min-width:45px">
                        <div class="fw-bold text-primary small">{{ $s->day_of_week_label }}</div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold small">{{ $s->subject->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">
                            {{ $s->hall->name }} · {{ $s->studentGroup->name }}
                        </div>
                    </div>
                    <div class="text-muted small">{{ $s->start_time }}</div>
                </div>
                @empty
                <div class="text-center text-muted py-4">لا توجد محاضرات قادمة</div>
                @endforelse
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('doctor.schedule') }}" class="btn btn-sm btn-outline-primary">
                    الجدول الكامل <i class="bi bi-arrow-left ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection