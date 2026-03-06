@extends('layouts.admin')
@section('title', 'جدول ' . $student->name)
@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-3">
            <div
                style="width:50px;height:50px;background:#e0e7ff;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#4f46e5;font-weight:800;font-size:1.2rem">
                {{ mb_substr($student->name, 0, 1) }}
            </div>
            <div>
                <h5 class="mb-0 fw-bold">{{ $student->name }}</h5>
                <small class="text-muted">
                    <i class="bi bi-envelope me-1"></i>{{ $student->email }}
                    &nbsp;·&nbsp;
                    <i class="bi bi-people me-1"></i>{{ $student->studentGroup->name ?? '—' }}
                </small>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-outline-warning">
                <i class="bi bi-pencil me-1"></i>تعديل
            </a>
            <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-right me-1"></i>رجوع
            </a>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold text-primary">{{ $stats['total'] }}</div>
                    <div class="text-muted small">إجمالي</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold text-success">{{ $stats['upcoming'] }}</div>
                    <div class="text-muted small">قادمة</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold text-warning">{{ $stats['today'] }}</div>
                    <div class="text-muted small">اليوم</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold text-info">{{ $stats['lectures'] }}</div>
                    <div class="text-muted small">محاضرات</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold text-secondary">{{ $stats['labs'] }}</div>
                    <div class="text-muted small">معامل</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card text-center border-0 shadow-sm bg-primary text-white">
                <div class="card-body py-3">
                    <div class="fs-5 fw-bold">{{ $student->studentGroup->study_days ?? '—' }}</div>
                    <div class="small opacity-75">أيام الدراسة</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Full Schedule --}}
    @forelse($schedules as $dayLabel => $daySchedules)
        <div class="card mb-3" style="border-right: 4px solid #0d6efd">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-calendar-day me-2 text-primary"></i>
                    {{ $dayLabel }}
                </span>
                <span class="badge bg-primary bg-opacity-10 text-primary">
                    {{ $daySchedules->count() }} {{ $daySchedules->count() == 1 ? 'حصة' : 'حصص' }}
                </span>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>الوقت</th>
                            <th>المادة</th>
                            <th>الدكتور</th>
                            <th>القاعة</th>
                            <th>النوع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daySchedules as $s)
                            <tr>
                                <td class="text-nowrap fw-semibold text-primary">
                                    {{ $s->start_time }} – {{ $s->end_time }}
                                </td>
                                <td><strong>{{ $s->subject->name }}</strong></td>
                                <td>{{ $s->doctor->name }}</td>
                                <td><span class="badge bg-secondary">{{ $s->hall->name }}</span></td>
                                <td>
                                    <span class="badge {{ $s->type === 'lecture' ? 'bg-primary' : 'bg-success' }}">
                                        {{ $s->type === 'lecture' ? 'محاضرة' : 'معمل' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="card">
            <div class="card-body text-center text-muted py-5">
                <i class="bi bi-calendar-x fs-1 d-block mb-3 text-muted"></i>
                <h5>لا توجد جداول لهذا الطالب</h5>
                <p class="small">مجموعته ({{ $student->studentGroup->name ?? '—' }}) ليس لها جداول مضافة بعد</p>
                <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-lg me-1"></i>إضافة جدول الآن
                </a>
            </div>
        </div>
    @endforelse

@endsection
