
@extends('layouts.doctor')
@section('title', 'جدولي الدراسي')
@section('content')
<h4 class="mb-4"><i class="bi bi-calendar3 me-2 text-primary"></i>جدولي الدراسي — {{ $doctor->name }}</h4>

@forelse($schedules as $date => $daySchedules)
<div class="card mb-3">
    <div class="card-header bg-light fw-bold">
        <i class="bi bi-calendar-day me-2"></i>{{ \Carbon\Carbon::parse($date)->translatedFormat('l، d F Y') }}
    </div>
    <div class="card-body p-0">
        <table class="table table-sm mb-0">
            <thead class="table-primary"><tr><th>المادة</th><th>القاعة</th><th>المجموعة</th><th>الوقت</th><th>النوع</th></tr></thead>
            <tbody>
                @foreach($daySchedules as $s)
                <tr>
                    <td><strong>{{ $s->subject->name }}</strong></td>
                    <td>{{ $s->hall->name }}</td>
                    <td>{{ $s->studentGroup->name }}</td>
                    <td>{{ $s->start_time }} – {{ $s->end_time }}</td>
                    <td><span class="badge {{ $s->type==='lecture'?'bg-primary':'bg-success' }}">{{ $s->type==='lecture'?'محاضرة':'معمل' }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@empty
    <div class="alert alert-info">لا توجد محاضرات مجدولة حالياً</div>
@endforelse
@endsection