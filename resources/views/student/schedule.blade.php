
@extends('layouts.student')
@section('title', 'جدولي')
@section('content')
<h4 class="mb-4"><i class="bi bi-table me-2 text-success"></i>جدولي الدراسي</h4>

@forelse($schedules as $date => $daySchedules)
<div class="card mb-3 border-start border-success border-3">
    <div class="card-header bg-white fw-bold">
        📅 {{ \Carbon\Carbon::parse($date)->translatedFormat('l، d F Y') }}
    </div>
    <div class="list-group list-group-flush">
        @foreach($daySchedules as $s)
        <div class="list-group-item">
            <div class="d-flex justify-content-between">
                <div>
                    <strong>{{ $s->subject->name }}</strong>
                    <span class="text-muted ms-2">— {{ $s->doctor->name }}</span>
                </div>
                <span class="badge {{ $s->type==='lecture'?'bg-primary':'bg-success' }}">
                    {{ $s->type==='lecture'?'محاضرة':'معمل' }}
                </span>
            </div>
            <small class="text-muted">
                <i class="bi bi-geo-alt me-1"></i>{{ $s->hall->name }}
                &nbsp;|&nbsp;
                <i class="bi bi-clock me-1"></i>{{ $s->start_time }} – {{ $s->end_time }}
            </small>
        </div>
        @endforeach
    </div>
</div>
@empty
    <div class="alert alert-warning">لا توجد محاضرات مجدولة لمجموعتك حالياً</div>
@endforelse
@endsection