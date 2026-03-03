{{-- ══════════════════════════════════════════════════════════ --}}
{{-- FILE: resources/views/admin/students/index.blade.php      --}}
{{-- ══════════════════════════════════════════════════════════ --}}
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
                        <option value="">-- كل المجموعات --</option>
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
                    <th>المجموعة</th>
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


{{-- ══════════════════════════════════════════════════════════ --}}
{{-- FILE: resources/views/admin/students/create.blade.php     --}}
{{-- ══════════════════════════════════════════════════════════ --}}
@extends('layouts.admin')
@section('title','إضافة طالب')
@section('content')
<div class="card" style="max-width:650px;margin:auto">
    <div class="card-header bg-primary text-white fw-bold">
        <i class="bi bi-person-plus-fill me-2"></i>إضافة طالب جديد
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.students.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">الاسم كاملاً <span class="text-danger">*</span></label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="مثال: أحمد محمد علي" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">البريد الإلكتروني <span class="text-danger">*</span></label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="student@uni.edu" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">المجموعة الدراسية <span class="text-danger">*</span></label>
                    <select name="student_group_id"
                            class="form-select @error('student_group_id') is-invalid @enderror" required>
                        <option value="">-- اختر المجموعة --</option>
                        @foreach($groups as $g)
                        <option value="{{ $g->id }}" {{ old('student_group_id')==$g->id?'selected':'' }}>
                            {{ $g->name }} — {{ $g->study_days }}
                        </option>
                        @endforeach
                    </select>
                    @error('student_group_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">كلمة المرور <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password" id="pass"
                               class="form-control @error('password') is-invalid @enderror" required>
                        <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePass('pass','eye1')">
                            <i class="bi bi-eye" id="eye1"></i>
                        </button>
                    </div>
                    @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="pass2"
                               class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePass('pass2','eye2')">
                            <i class="bi bi-eye" id="eye2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i>إضافة الطالب
                </button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function togglePass(id, eyeId) {
    const input = document.getElementById(id);
    const eye   = document.getElementById(eyeId);
    input.type  = input.type === 'password' ? 'text' : 'password';
    eye.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
@endpush
@endsection


{{-- ══════════════════════════════════════════════════════════ --}}
{{-- FILE: resources/views/admin/students/edit.blade.php       --}}
{{-- ══════════════════════════════════════════════════════════ --}}
@extends('layouts.admin')
@section('title','تعديل بيانات الطالب')
@section('content')
<div class="card" style="max-width:650px;margin:auto">
    <div class="card-header bg-warning text-dark fw-bold">
        <i class="bi bi-pencil-square me-2"></i>تعديل: {{ $student->name }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.students.update', $student) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">الاسم كاملاً</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $student->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">البريد الإلكتروني</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $student->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">المجموعة الدراسية</label>
                    <select name="student_group_id" class="form-select" required>
                        @foreach($groups as $g)
                        <option value="{{ $g->id }}"
                            {{ $student->student_group_id == $g->id ? 'selected' : '' }}>
                            {{ $g->name }} — {{ $g->study_days }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <div class="alert alert-light border small">
                        <i class="bi bi-info-circle text-primary me-1"></i>
                        اترك حقول كلمة المرور فاضية لو مش عايز تغيّرها
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">كلمة المرور الجديدة</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-warning px-4">
                    <i class="bi bi-check-lg me-1"></i>تحديث
                </button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection