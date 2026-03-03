
@extends('layouts.admin')
@section('title','تعديل دكتور')
@section('content')
<div class="card" style="max-width:650px;margin:auto">
    <div class="card-header bg-warning text-dark fw-bold">
        <i class="bi bi-pencil-square me-2"></i>تعديل: {{ $doctor->name }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.doctors.update', $doctor) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">الاسم كاملاً</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $doctor->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">القسم</label>
                    <input type="text" name="department" class="form-control"
                           value="{{ old('department', $doctor->department) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">رقم التليفون</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone', $doctor->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $doctor->user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i>اتركهم فاضيين لو مش عايز تغير كلمة المرور</p>
                </div>
                <div class="col-md-6">
                    <label class="form-label">كلمة المرور الجديدة</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg me-1"></i>تحديث</button>
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection