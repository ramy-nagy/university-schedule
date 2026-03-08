


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
                <div class="col-md-6">
                    <label class="form-label fw-semibold">الفرقة  الدراسية</label>
                    <select name="student_group_id" class="form-select" required>
                        @foreach($groups as $g)
                        <option value="{{ $g->id }}"
                            {{ $student->student_group_id == $g->id ? 'selected' : '' }}>
                            {{ $g->name }} — {{ $g->study_days }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">القسم/الشعبة</label>
                    <select name="section_id" class="form-select" >
                        <option value="">-- اختر القسم (اختياري) --</option>
                        @foreach($sections as $sec)
                        <option value="{{ $sec->id }}" 
                            {{ $student->section_id == $sec->id ? 'selected' : '' }}>
                            {{ $sec->name }}
                        </option>
                        @endforeach
                    </select>
                    <small class="text-muted">اختياري - القسم الذي ينتمي إليه الطالب للحصص العملية</small>
                    @error('section_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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