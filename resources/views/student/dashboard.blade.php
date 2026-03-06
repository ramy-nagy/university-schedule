{{-- ══════════════════════════════════════════════════════ --}}
{{-- FILE: resources/views/student/dashboard.blade.php     --}}
{{-- ══════════════════════════════════════════════════════ --}}
@extends('layouts.admin')
@section('title', 'لوحة تحكم الطالب')
@section('content')

{{-- ── Welcome + Group Info ─────────────────────────────── --}}
<div class="row g-3 mb-4">
    {{-- Welcome Card --}}
    <div class="col-md-8">
        <div class="card h-100" style="background:linear-gradient(135deg,#198754,#20c997);color:#fff;border-radius:16px">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div style="width:60px;height:60px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.8rem">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">أهلاً، {{ auth()->user()->name }} 👋</h5>
                    <p class="mb-0 opacity-75 small">
                        <i class="bi bi-people me-1"></i>{{ auth()->user()->studentGroup->name ?? 'غير محدد' }}
                        &nbsp;·&nbsp;
                        <i class="bi bi-calendar me-1"></i>{{ auth()->user()->studentGroup->study_days ?? '—' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="col-md-4">
        <div class="card h-100 text-center">
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="text-success fs-1"><i class="bi bi-calendar-check"></i></div>
                <div class="fs-2 fw-bold">{{ $totalSchedules }}</div>
                <div class="text-muted small">إجمالي المحاضرات</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Today's Lectures ─────────────────────────────────── --}}
<div class="card mb-4 day-card">
    <div class="card-header bg-success text-white fw-bold">
        <i class="bi bi-sun me-2"></i>محاضرات اليوم
        <span class="badge bg-white text-success ms-2">{{ $todaySchedules->count() }}</span>
    </div>
    <div class="card-body p-0">
        @forelse($todaySchedules as $s)
        <div class="lecture-item d-flex align-items-center px-4 py-3 border-bottom">
            <div class="text-center me-4" style="min-width:60px">
                <div class="fw-bold text-success">{{ \Carbon\Carbon::parse($s->start_time)->format('h:i') }}</div>
                <div class="text-muted" style="font-size:.7rem">{{ \Carbon\Carbon::parse($s->start_time)->format('A') }}</div>
            </div>
            <div class="flex-grow-1">
                <div class="fw-semibold">{{ $s->subject->name }}</div>
                <div class="text-muted small">
                    <i class="bi bi-person-badge me-1"></i>{{ $s->doctor->name }}
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
        @empty
        <div class="text-center text-muted py-5">
            <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>لا توجد محاضرات اليوم 🎉
        </div>
        @endforelse
    </div>
</div>

{{-- ── Upcoming Lectures (Next 3) ──────────────────────── --}}
@if($upcomingSchedules->count())
<div class="card">
    <div class="card-header bg-light fw-bold">
        <i class="bi bi-clock-history me-2 text-primary"></i>المحاضرات القادمة
    </div>
    <div class="card-body p-0">
        @foreach($upcomingSchedules as $s)
        <div class="d-flex align-items-center px-4 py-3 border-bottom">
            <div class="me-3">
                <div class="badge bg-light text-dark border" style="font-size:.8rem">
                    {{ $s->date->format('d/m') }}
                </div>
            </div>
            <div class="flex-grow-1">
                <div class="fw-semibold small">{{ $s->subject->name }}</div>
                <div class="text-muted" style="font-size:.75rem">{{ $s->doctor->name }} · {{ $s->hall->name }}</div>
            </div>
            <span class="text-muted small">{{ $s->start_time }}</span>
        </div>
        @endforeach
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('student.schedule') }}" class="btn btn-sm btn-outline-success">
            عرض الجدول كاملاً <i class="bi bi-arrow-left ms-1"></i>
        </a>
    </div>
</div>
@endif

@endsection