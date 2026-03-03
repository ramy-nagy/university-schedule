
@extends('layouts.admin')
@section('title','تعديل قاعة')
@section('content')
<div class="card" style="max-width:600px;margin:auto">
    <div class="card-header bg-warning text-dark fw-bold">
        <i class="bi bi-pencil-square me-2"></i>تعديل: {{ $hall->name }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.halls.update', $hall) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">اسم القاعة</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $hall->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">النوع</label>
                <select name="type" class="form-select" required>
                    <option value="lecture_hall" {{ $hall->type=='lecture_hall'?'selected':'' }}>مدرج / قاعة محاضرات</option>
                    <option value="lab"          {{ $hall->type=='lab'?'selected':'' }}>معمل</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">الطاقة الاستيعابية</label>
                <input type="number" name="capacity" class="form-control"
                       value="{{ old('capacity', $hall->capacity) }}" min="1" required>
            </div>
            <div class="mb-4">
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $hall->description) }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg me-1"></i>تحديث</button>
                <a href="{{ route('admin.halls.index') }}" class="btn btn-outline-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
