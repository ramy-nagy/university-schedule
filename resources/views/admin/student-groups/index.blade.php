
@extends('layouts.admin')
@section('title','المجموعات الطلابية')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-people me-2 text-info"></i>إدارة المجموعات الطلابية</h4>
    <a href="{{ route('admin.student-groups.create') }}" class="btn btn-info text-white">
        <i class="bi bi-plus-lg me-1"></i>إضافة مجموعة
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>اسم المجموعة</th><th>أيام الدراسة</th><th>الطلاب</th><th>الجداول</th><th>إجراءات</th></tr>
            </thead>
            <tbody>
                @forelse($groups as $group)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $group->name }}</strong></td>
                    <td>
                        @foreach(explode(',', $group->study_days) as $day)
                            <span class="badge bg-info text-white me-1">{{ trim($day) }}</span>
                        @endforeach
                    </td>
                    <td><span class="badge bg-primary">{{ $group->students_count }} طالب</span></td>
                    <td><span class="badge bg-secondary">{{ $group->schedules_count }}</span></td>
                    <td>
                        <a href="{{ route('admin.student-groups.edit', $group) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.student-groups.destroy', $group) }}" class="d-inline"
                              onsubmit="return confirm('حذف هذه المجموعة؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">لا توجد مجموعات مضافة</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $groups->links() }}</div>
</div>
@endsection
