{{-- FILE: resources/views/admin/dashboard.blade.php --}}

@extends('layouts.admin')
@section('title', 'لوحة التحكم')

@section('content')

{{-- ── Page Title ───────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-speedometer2 me-2 text-primary"></i>لوحة التحكم</h4>
    <span class="text-muted small">{{ now()->translatedFormat('l، d F Y') }}</span>
</div>

{{-- ── Stats Cards ──────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card text-center h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="fs-2 text-primary"><i class="bi bi-building"></i></div>
                <div class="fs-3 fw-bold">{{ $stats['halls'] }}</div>
                <div class="text-muted small">قاعة</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card text-center h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="fs-2 text-success"><i class="bi bi-person-badge"></i></div>
                <div class="fs-3 fw-bold">{{ $stats['doctors'] }}</div>
                <div class="text-muted small">دكتور</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card text-center h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="fs-2 text-warning"><i class="bi bi-book"></i></div>
                <div class="fs-3 fw-bold">{{ $stats['subjects'] }}</div>
                <div class="text-muted small">مادة</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card text-center h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="fs-2 text-info"><i class="bi bi-people"></i></div>
                <div class="fs-3 fw-bold">{{ $stats['student_groups'] }}</div>
                <div class="text-muted small">فرقة </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card text-center h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="fs-2 text-secondary"><i class="bi bi-calendar-check"></i></div>
                <div class="fs-3 fw-bold">{{ $stats['schedules'] }}</div>
                <div class="text-muted small">جدول كلي</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card text-center h-100 border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="fs-2"><i class="bi bi-clock-history"></i></div>
                <div class="fs-3 fw-bold">{{ $stats['upcoming'] }}</div>
                <div class="small opacity-75">قادم</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Today's Schedule + Latest Added ─────────────────── --}}
<div class="row g-4">

    {{-- Today --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header bg-success text-white fw-bold">
                <i class="bi bi-sun me-2"></i>جداول اليوم
                <span class="badge bg-white text-success ms-2">{{ $todaySchedules->count() }}</span>
            </div>
            <div class="card-body p-0">
                @forelse($todaySchedules as $s)
                <div class="d-flex align-items-center px-3 py-2 border-bottom">
                    <div class="me-3 text-center" style="min-width:55px">
                        <div class="fw-bold text-primary small">{{ $s->start_time }}</div>
                        <div class="text-muted" style="font-size:.7rem">{{ $s->end_time }}</div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">{{ $s->subject->name }}</div>
                        <div class="text-muted small">{{ $s->doctor?->name ?? 'غير محدد' }} · {{ $s->hall->name }}</div>
                    </div>
                    <span class="badge {{ $s->type==='lecture'?'bg-primary':'bg-warning' }}">
                        {{ $s->type==='lecture'?'محاضرة':'معمل' }}
                    </span>
                </div>
                @empty
                <div class="text-center text-muted py-5">
                    <i class="bi bi-calendar-x fs-2"></i>
                    <p class="mt-2">لا توجد جداول اليوم</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Latest Added --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-clock-history me-2"></i>آخر الجداول المضافة
            </div>
            <div class="card-body p-0">
                @forelse($latestSchedules as $s)
                <div class="d-flex align-items-center px-3 py-2 border-bottom">
                    <div class="flex-grow-1">
                        <div class="fw-semibold">{{ $s->subject->name }}</div>
                        <div class="text-muted small">
                            {{ $s->doctor?->name ?? 'غير محدد' }} ·
                            {{ $s->studentGroup->name }} ·
                            {{ $s->day_of_week_label }}
                        </div>
                    </div>
                    <span class="badge bg-secondary">{{ $s->hall->name }}</span>
                    @if ($s->type === 'lab')
                        <span class="badge badge-warning text-white ms-2">
                            {{ $s->section_id ? "سكشن {$s->section_id}" : 'غير محدد' }}
                        </span>
                    @endif
                </div>
                @empty
                <div class="text-center text-muted py-5">لا توجد بيانات</div>
                @endforelse
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-sm btn-outline-primary">
                    عرض الكل <i class="bi bi-arrow-left ms-1"></i>
                </a>
            </div>
        </div>
    </div>

</div>

{{-- ── Week Schedule ────────────────────────────────────── --}}
@if($weekSchedules->count())
<div class="card mt-4">
    <div class="card-header bg-light fw-bold">
        <i class="bi bi-calendar-week me-2 text-primary"></i>جداول الأسبوع
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>اليوم</th><th>المادة</th><th>الدكتور</th>
                    <th>القاعة</th><th>الفرقة </th><th>الوقت</th>
                </tr>
            </thead>
            <tbody>
                @foreach($weekSchedules as $dayLabel => $dayItems)
                    @foreach($dayItems as $i => $s)
                    <tr>
                        @if($i === 0)
                        <td rowspan="{{ $dayItems->count() }}" class="fw-bold text-primary align-middle">
                            {{ $dayLabel }}
                        </td>
                        @endif
                        <td>{{ $s->subject->name }}</td>
                        <td>{{ $s->doctor?->name ?? 'غير محدد' }}</td>
                        <td><span class="badge bg-secondary">{{ $s->hall->name }}</span></td>
                        <td>{{ $s->studentGroup->name }}</td>
                        <td class="text-nowrap">{{ $s->start_time }} – {{ $s->end_time }}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection