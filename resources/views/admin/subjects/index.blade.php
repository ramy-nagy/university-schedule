
@extends('layouts.admin')
@section('title','المواد التعليمية')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-book me-2 text-warning"></i>إدارة المواد التعليمية</h4>
    <a href="{{ route('admin.subjects.create') }}" class="btn btn-warning text-white">
        <i class="bi bi-plus-lg me-1"></i>إضافة مادة
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>اسم المادة</th><th>الكود</th><th>الدكتور</th><th>الجداول</th><th>إجراءات</th></tr>
            </thead>
            <tbody>
                @forelse($subjects as $subject)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $subject->name }}</strong></td>
                    <td><span class="badge bg-dark">{{ $subject->code }}</span></td>
                    <td>{{ $subject->doctor->name }}</td>
                    <td><span class="badge bg-secondary">{{ $subject->schedules_count }}</span></td>
                    <td>
                        <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.subjects.destroy', $subject) }}" class="d-inline"
                              onsubmit="return confirm('حذف هذه المادة؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">لا توجد مواد مضافة</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $subjects->links() }}</div>
</div>
@endsection