
@extends('layouts.admin')
@section('title','إضافة قاعة')
@section('content')
<div class="card" style="max-width:600px;margin:auto">
    <div class="card-header bg-primary text-white fw-bold">
        <i class="bi bi-building-add me-2"></i>إضافة قاعة جديدة
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.halls.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">اسم القاعة <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="مثال: مدرج 6أ" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">النوع <span class="text-danger">*</span></label>
                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                    <option value="">-- اختر النوع --</option>
                    <option value="lecture_hall" {{ old('type')=='lecture_hall'?'selected':'' }}>مدرج / قاعة محاضرات</option>
                    <option value="lab"          {{ old('type')=='lab'?'selected':'' }}>معمل</option>
                </select>
                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">الطاقة الاستيعابية <span class="text-danger">*</span></label>
                <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror"
                       value="{{ old('capacity') }}" min="1" placeholder="مثال: 150" required>
                @error('capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-control" rows="3"
                          placeholder="وصف مختصر للقاعة">{{ old('description') }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>حفظ</button>
                <a href="{{ route('admin.halls.index') }}" class="btn btn-outline-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection