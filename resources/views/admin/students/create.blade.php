
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

                <div class="col-md-6">
                    <label class="form-label fw-semibold">الفرقة  الدراسية <span class="text-danger">*</span></label>
                    <select name="student_group_id"
                            class="form-select @error('student_group_id') is-invalid @enderror" required>
                        <option value="">-- اختر الفرقة  --</option>
                        @foreach($groups as $g)
                        <option value="{{ $g->id }}" {{ old('student_group_id')==$g->id?'selected':'' }}>
                            {{ $g->name }} — {{ $g->study_days }}
                        </option>
                        @endforeach
                    </select>
                    @error('student_group_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">القسم/الشعبة</label>
                    <select name="section_id"
                            class="form-select @error('section_id') is-invalid @enderror">
                        <option value="">-- اختر القسم (اختياري) --</option>
                        @foreach($sections as $sec)
                        <option value="{{ $sec->id }}" {{ old('section_id')==$sec->id?'selected':'' }}>
                            {{ $sec->name }}
                        </option>
                        @endforeach
                    </select>
                    <small class="text-muted">اختياري - القسم الذي ينتمي إليه الطالب للحصص العملية</small>
                    @error('section_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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