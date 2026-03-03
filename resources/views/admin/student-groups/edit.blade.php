@extends('layouts.admin')
@section('title','تعديل مجموعة')
@section('content')
<div class="card" style="max-width:600px;margin:auto">
    <div class="card-header bg-info text-white fw-bold">
        <i class="bi bi-pencil-square me-2"></i>تعديل مجموعة طلابية
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong><i class="bi bi-exclamation-circle me-2"></i>خطأ التحقق:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.student-groups.update', $group->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">اسم المجموعة <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $group->name) }}" placeholder="مثال: المجموعة الأولى" required>
                @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">أيام الدراسة <span class="text-danger">*</span></label>
                <div class="d-flex flex-wrap gap-2 @error('study_days') border border-danger p-2 rounded @enderror">
                    @php
                        $groupDays = old('days', explode(',', $group->study_days ?? ''));
                    @endphp
                    @foreach(['السبت','الأحد','الاثنين','الثلاثاء','الأربعاء','الخميس'] as $day)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="days[]"
                               value="{{ $day }}" id="day_{{ $loop->index }}"
                               {{ in_array($day, $groupDays) ? 'checked' : '' }}>
                        <label class="form-check-label" for="day_{{ $loop->index }}">{{ $day }}</label>
                    </div>
                    @endforeach
                </div>
                {{-- نجمع الأيام في حقل مخفي قبل الإرسال --}}
                <input type="hidden" name="study_days" id="study_days_input">
                @error('study_days')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"
                          placeholder="مثال: تبدأ من الساعة 8 صباحاً">{{ old('description', $group->description) }}</textarea>
                @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-info text-white"><i class="bi bi-check-lg me-1"></i>حفظ التعديلات</button>
                <a href="{{ route('admin.student-groups.index') }}" class="btn btn-outline-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// جمع الأيام المختارة في حقل واحد مفصول بفاصلة
document.querySelector('form').addEventListener('submit', function() {
    const checked = [...document.querySelectorAll('input[name="days[]"]:checked')]
        .map(el => el.value);
    document.getElementById('study_days_input').value = checked.join(',');
});
</script>
@endpush
@endsection
