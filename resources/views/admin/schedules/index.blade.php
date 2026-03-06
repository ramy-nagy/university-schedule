
@extends('layouts.admin')
@section('title', 'إدارة الجداول')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-calendar-week me-2 text-primary"></i>الجداول الدراسية</h4>
    <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>إضافة توقيت</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>الدكتور</th><th>المادة</th><th>القاعة</th>
                    <th>الفرقة </th><th>التاريخ</th><th>الوقت</th>
                    <th>النوع</th><th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $s)
                <tr>
                    <td><i class="bi bi-person-badge me-1 text-muted"></i>{{ $s->doctor->name }}</td>
                    <td>{{ $s->subject->name }}</td>
                    <td><span class="badge bg-secondary">{{ $s->hall->name }}</span></td>
                    <td>{{ $s->studentGroup->name }}</td>
                    <td>{{ $s->date->format('Y/m/d') }}<br><small class="text-muted">{{ $s->date->translatedFormat('l') }}</small></td>
                    <td>{{ $s->start_time }} – {{ $s->end_time }}</td>
                    <td>
                        <span class="badge {{ $s->type === 'lecture' ? 'badge-lecture' : 'badge-lab' }} text-white">
                            {{ $s->type === 'lecture' ? 'محاضرة' : 'معمل' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.schedules.edit', $s) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('admin.schedules.destroy', $s) }}" class="d-inline"
                              onsubmit="return confirm('حذف هذا التوقيت؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">لا توجد جداول مضافة بعد</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $schedules->links() }}</div>
</div>
@endsection
