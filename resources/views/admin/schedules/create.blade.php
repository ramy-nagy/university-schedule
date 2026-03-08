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
                        <select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror">
                            <option value="">-- اختر الدكتور --</option>
                            @foreach ($doctors as $d)
                                <option value="{{ $d->id }}" {{ old('doctor_id') == $d->id ? 'selected' : '' }}>
                                    {{ $d->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">المادة</label>
                        <select name="subject_id" class="form-select @error('subject_id') is-invalid @enderror" required>
                            <option value="">-- اختر المادة --</option>
                            @foreach ($subjects as $sub)
                                <option value="{{ $sub->id }}" {{ old('subject_id') == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">القاعة</label>
                        <select name="hall_id" class="form-select @error('hall_id') is-invalid @enderror" required>
                            <option value="">-- اختر القاعة --</option>
                            @foreach ($halls as $h)
                                <option value="{{ $h->id }}" {{ old('hall_id') == $h->id ? 'selected' : '' }}>
                                    {{ $h->name }} ({{ $h->type === 'lab' ? 'معمل' : 'مدرج' }})</option>
                            @endforeach
                        </select>
                        @error('hall_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الفرقة الطلابية</label>
                        <select name="student_group_id" class="form-select @error('student_group_id') is-invalid @enderror"
                            required>
                            <option value="">-- اختر الفرقة --</option>
                            @foreach ($studentGroups as $g)
                                <option value="{{ $g->id }}" {{ old('student_group_id') == $g->id ? 'selected' : '' }}>
                                    {{ $g->name }}</option>
                            @endforeach
                        </select>
                        @error('student_group_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">يوم الأسبوع</label>
                        <select name="day_of_week" class="form-select @error('day_of_week') is-invalid @enderror" required>
                            <option value="">-- اختر اليوم --</option>
                            <option value="saturday" {{ old('day_of_week') == 'saturday' ? 'selected' : '' }}>السبت</option>
                            <option value="sunday" {{ old('day_of_week') == 'sunday' ? 'selected' : '' }}>الأحد</option>
                            <option value="monday" {{ old('day_of_week') == 'monday' ? 'selected' : '' }}>الاثنين</option>
                            <option value="tuesday" {{ old('day_of_week') == 'tuesday' ? 'selected' : '' }}>الثلاثاء</option>
                            <option value="wednesday" {{ old('day_of_week') == 'wednesday' ? 'selected' : '' }}>الأربعاء</option>
                            <option value="thursday" {{ old('day_of_week') == 'thursday' ? 'selected' : '' }}>الخميس</option>
                            <option value="friday" {{ old('day_of_week') == 'friday' ? 'selected' : '' }}>الجمعة</option>
                        </select>
                        @error('day_of_week')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">من الساعة</label>
                        <input type="time" name="start_time"
                            class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time') }}"
                            required>
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">إلى الساعة</label>
                        <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
                            value="{{ old('end_time') }}" required>
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">نوع الحصة</label>
                        <select name="type" id="scheduleType" class="form-select @error('type') is-invalid @enderror">
                            <option value="lecture" {{ old('type', 'lecture') == 'lecture' ? 'selected' : '' }}>محاضرة نظرية</option>
                            <option value="lab" {{ old('type') == 'lab' ? 'selected' : '' }}>حصة معمل / قسم</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6" id="sectionIdContainer">
                        <label class="form-label">الأقسام/الشعب</label>
                        <input type="text" name="section_ids_input" id="sectionIdInput"
                            class="form-control @error('section_ids') is-invalid @enderror"
                            placeholder="مثال: 1,2,3" 
                            value="{{ old('section_ids_input') }}">
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle"></i> أدخل أرقام الأقسام مفصولة بفواصل (مثال: 1,2,3 أو 5,10,15)
                        </small>
                        @error('section_ids')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>حفظ التوقيت</button>
                    <a href="{{ route('admin.schedules.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scheduleTypeSelect = document.getElementById('scheduleType');
            const sectionIdContainer = document.getElementById('sectionIdContainer');
            const sectionIdInput = document.getElementById('sectionIdInput');
            
            function toggleSectionIdField() {
                if (scheduleTypeSelect.value === 'lab') {
                    sectionIdContainer.style.display = 'block';
                    sectionIdInput.required = true;
                } else {
                    sectionIdContainer.style.display = 'none';
                    sectionIdInput.required = false;
                    sectionIdInput.value = '';
                }
            }
            
            // Initialize on page load
            toggleSectionIdField();
            
            // Update when type changes
            scheduleTypeSelect.addEventListener('change', toggleSectionIdField);
        });
    </script>
@endsection
