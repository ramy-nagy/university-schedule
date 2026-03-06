
@extends('layouts.admin')
@section('title','إضافة مادة')
@section('content')
<div class="card" style="max-width:600px;margin:auto;width:100%">
    <div class="card-header bg-warning text-dark fw-bold">
        <i class="bi bi-book me-2"></i>إضافة مادة جديدة
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.subjects.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">اسم المادة <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            {{-- <div class="mb-3">
                <label class="form-label">كود المادة <span class="text-danger">*</span></label>
                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                       value="{{ old('code') }}" placeholder="مثال: CS101" required>
                @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div> --}}
            <div class="mb-3">
                <label class="form-label">الدكتور المسؤول <span class="text-danger">*</span></label>
                <select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                    <option value="">-- اختر الدكتور --</option>
                    @foreach($doctors as $d)
                        <option value="{{ $d->id }}" {{ old('doctor_id')==$d->id?'selected':'' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
                @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning text-white"><i class="bi bi-check-lg me-1"></i>حفظ</button>
                <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection