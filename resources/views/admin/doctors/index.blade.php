
@extends('layouts.admin')
@section('title','الدكاترة')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-person-badge me-2 text-success"></i>إدارة الدكاترة</h4>
    <a href="{{ route('admin.doctors.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i>إضافة دكتور
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>الاسم</th><th>البريد</th><th>القسم</th><th>التليفون</th><th>الجداول</th><th>إجراءات</th></tr>
            </thead>
            <tbody>
                @forelse($doctors as $doc)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $doc->name }}</strong></td>
                    <td class="text-muted small">{{ $doc->user->email }}</td>
                    <td>{{ $doc->department ?? '—' }}</td>
                    <td>{{ $doc->phone ?? '—' }}</td>
                    <td><span class="badge bg-secondary">{{ $doc->schedules_count }}</span></td>
                    <td>
                        <a href="{{ route('admin.doctors.edit', $doc) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.doctors.destroy', $doc) }}" class="d-inline"
                              onsubmit="return confirm('حذف هذا الدكتور وحسابه؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">لا يوجد دكاترة مضافين</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $doctors->links() }}</div>
</div>
@endsection
