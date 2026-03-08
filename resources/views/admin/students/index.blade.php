
@extends('layouts.admin')
@section('title','الطلاب')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-mortarboard-fill me-2 text-primary"></i>إدارة الطلاب</h4>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>إضافة طالب
    </a>
</div>

{{-- Search & Filter --}}
<div class="card mb-3">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.students.index') }}">
            <div class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0"
                               placeholder="بحث بالاسم أو البريد..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="group_id" class="form-select">
                        <option value="">-- كل الفرق --</option>
                        @foreach($groups as $g)
                            <option value="{{ $g->id }}" {{ request('group_id')==$g->id?'selected':'' }}>{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">بحث</button>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">مسح</a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-bold">إجمالي الطلاب: <span class="text-primary">{{ $students->total() }}</span></span>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>اسم الطالب</th>
                    <th>البريد الإلكتروني</th>
                    <th>الفرقة </th>
                    <th>رقم القسم</th>
                    <th>أيام الدراسة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td class="text-muted small">{{ $student->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:36px;height:36px;background:#e0e7ff;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#4f46e5;font-weight:700;font-size:.85rem">
                                {{ mb_substr($student->name,0,1) }}
                            </div>
                            <strong>{{ $student->name }}</strong>
                        </div>
                    </td>
                    <td class="text-muted small">{{ $student->email }}</td>
                    <td>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                            {{ $student->studentGroup->name ?? '—' }}
                        </span>
                    </td>
                    <td class="text-muted small">{{ $student->section_id ?? '—' }}</td>
                    <td class="text-muted small">{{ $student->studentGroup->study_days ?? '—' }}</td>
                    <td>
                        {{-- عرض جدول الطالب --}}
                        <a href="{{ route('admin.students.show', $student) }}"
                           class="btn btn-sm btn-outline-info" title="عرض الجدول">
                            <i class="bi bi-calendar3"></i>
                        </a>
                        <a href="{{ route('admin.students.edit', $student) }}"
                           class="btn btn-sm btn-outline-warning" title="تعديل">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.students.destroy', $student) }}"
                              class="d-inline" onsubmit="return confirm('حذف هذا الطالب؟')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="حذف">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-people fs-2 d-block mb-2"></i>
                        لا يوجد طلاب مسجلين
                        @if(request('search') || request('group_id'))
                            — جرّب تغيير معايير البحث
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $students->links() }}</div>
</div>
@endsection
