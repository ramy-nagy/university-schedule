@extends('layouts.admin')

@section('title', 'إضافة مجموعة')

@section('content')
    <div class="card" style="max-width:600px;margin:auto">
        <div class="card-header bg-info text-white fw-bold">
            إضافة مجموعة طلابية جديدة
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.student-groups.store') }}">
                @csrf

                {{-- اسم المجموعة --}}
                <div class="mb-3">
                    <label class="form-label">اسم المجموعة *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                {{-- أيام الدراسة --}}
                <div class="mb-3">
                    <label class="form-label">أيام الدراسة *</label>

                    <div class="d-flex flex-wrap gap-3">
                        @foreach (['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس'] as $day)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="study_days[]"
                                    value="{{ $day }}" id="day_{{ $loop->index }}"
                                    {{ in_array($day, old('study_days', [])) ? 'checked' : '' }}>

                                <label class="form-check-label" for="day_{{ $loop->index }}">
                                    {{ $day }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    @error('study_days')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- الوصف --}}
                <div class="mb-4">
                    <label class="form-label">الوصف</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-info text-white">حفظ</button>
                    <a href="{{ route('admin.student-groups.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </div>

            </form>
        </div>
    </div>
@endsection
