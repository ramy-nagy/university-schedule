@extends('layouts.admin')
@section('title','تعديل مجموعة')
@section('content')
<div class="card" style="max-width:600px;margin:auto">
    <div class="card-header bg-info text-white fw-bold">
        <i class="bi bi-pencil-square me-2"></i>تعديل مجموعة طلابية
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.student-groups.update', $studentGroup->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">اسم المجموعة <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $studentGroup->name) }}" placeholder="مثال: المجموعة الأولى" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">أيام الدراسة <span class="text-danger">*</span></label>
                <div class="d-flex flex-wrap gap-2">
                    @php
                        $groupDays = old('days', explode(',', $studentGroup->study_days ?? ''));
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
            </div>
            <div class="mb-4">
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-control" rows="3"
                          placeholder="مثال: تبدأ من الساعة 8 صباحاً">{{ old('description', $studentGroup->description) }}</textarea>
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
