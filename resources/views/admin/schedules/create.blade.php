
@extends('layouts.admin')
@section('title', 'إضافة توقيت')
@section('content')
<div class="card" style="max-width:700px;margin:auto">
    <div class="card-header bg-primary text-white"><i class="bi bi-calendar-plus me-2"></i>إضافة توقيت جديد</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.schedules.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">الدكتور</label>
                    <select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                        <option value="">-- اختر الدكتور --</option>
                        @foreach($doctors as $d)
                            <option value="{{ $d->id }}" {{ old('doctor_id')==$d->id?'selected':'' }}>{{ $d->name }}</option>
                        @endforeach
                    </select>
                    @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">المادة</label>
                    <select name="subject_id" class="form-select @error('subject_id') is-invalid @enderror" required>
                        <option value="">-- اختر المادة --</option>
                        @foreach($subjects as $sub)
                            <option value="{{ $sub->id }}" {{ old('subject_id')==$sub->id?'selected':'' }}>{{ $sub->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">القاعة</label>
                    <select name="hall_id" class="form-select" required>
                        <option value="">-- اختر القاعة --</option>
                        @foreach($halls as $h)
                            <option value="{{ $h->id }}">{{ $h->name }} ({{ $h->type === 'lab' ? 'معمل' : 'مدرج' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الفرقة  الطلابية</label>
                    <select name="student_group_id" class="form-select" required>
                        <option value="">-- اختر الفرقة  --</option>
                        @foreach($studentGroups as $g)
                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">التاريخ</label>
                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                           value="{{ old('date') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">من الساعة</label>
                    <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">إلى الساعة</label>
                    <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">نوع الحصة</label>
                    <select name="type" class="form-select">
                        <option value="lecture">محاضرة نظرية</option>
                        <option value="lab">حصة معمل</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>حفظ التوقيت</button>
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-outline-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection