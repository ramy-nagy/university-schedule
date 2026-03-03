
@extends('layouts.admin')
@section('title','القاعات')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-building me-2 text-primary"></i>إدارة القاعات</h4>
    <a href="{{ route('admin.halls.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>إضافة قاعة
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>الاسم</th><th>النوع</th><th>الطاقة</th><th>الجداول</th><th>الوصف</th><th>إجراءات</th></tr>
            </thead>
            <tbody>
                @forelse($halls as $hall)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $hall->name }}</strong></td>
                    <td>
                        <span class="badge {{ $hall->type === 'lab' ? 'bg-success' : 'bg-primary' }}">
                            {{ $hall->type === 'lab' ? 'معمل' : 'مدرج' }}
                        </span>
                    </td>
                    <td><i class="bi bi-people me-1 text-muted"></i>{{ $hall->capacity }}</td>
                    <td><span class="badge bg-secondary">{{ $hall->schedules_count }}</span></td>
                    <td class="text-muted small">{{ Str::limit($hall->description, 40) }}</td>
                    <td>
                        <a href="{{ route('admin.halls.edit', $hall) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.halls.destroy', $hall) }}" class="d-inline"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذه القاعة؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">لا توجد قاعات مضافة</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $halls->links() }}</div>
</div>
@endsection