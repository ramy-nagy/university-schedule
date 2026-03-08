{{-- ══════════════════════════════════════════════════════ --}}
{{-- FILE: resources/views/student/schedule.blade.php     --}}
{{-- ══════════════════════════════════════════════════════ --}}
@extends('layouts.student')
@section('title', 'جدولي الدراسي')

@section('content')

    <style>
        .schedule-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            color: #fff;
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 32px;
            box-shadow: 0 12px 40px rgba(16, 185, 129, 0.3);
        }

        .schedule-header h4 {
            font-weight: 800;
            font-size: 1.6rem;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .schedule-header p {
            opacity: 0.9;
            font-weight: 500;
            margin: 0;
        }

        .day-schedule {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            margin-bottom: 28px;
            border-right: 5px solid #10b981;
            position: relative;
        }

        .day-schedule::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #34d399 0%, #10b981 100%);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .day-schedule:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(16, 185, 129, 0.15);
            border-right-color: #34d399;
        }

        .day-schedule:hover::after {
            transform: scaleX(1);
        }

        .day-header {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: none;
            padding: 20px 28px;
            font-weight: 800;
            color: #065f46;
            font-size: 1.15rem;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: 0.3px;
        }

        .day-header i {
            color: #10b981;
            font-size: 1.4rem;
        }

        .schedule-item {
            padding: 22px 28px;
            border-bottom: 1px solid #f0fdf4;
            display: flex;
            align-items: flex-start;
            gap: 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .schedule-item:last-child {
            border-bottom: none;
        }

        .schedule-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, #10b981 0%, #34d399 100%);
            transform: scaleY(0);
            transform-origin: top;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .schedule-item:hover::before {
            transform: scaleY(1);
        }

        .schedule-item>* {
            position: relative;
            z-index: 1;
        }

        .schedule-item:hover {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        }

        .time-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            min-width: 80px;
        }

        .start-time {
            font-weight: 800;
            color: #10b981;
            font-size: 1.15rem;
        }

        .end-time {
            font-size: 0.8rem;
            color: #9ca3af;
            font-weight: 600;
        }

        .time-divider {
            width: 2px;
            height: 20px;
            background: linear-gradient(180deg, #10b981, #34d399);
            border-radius: 1px;
        }

        .subject-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .subject-name {
            font-weight: 800;
            color: #1f2937;
            font-size: 1rem;
        }

        .doctor-info,
        .hall-info {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .doctor-info i,
        .hall-info i {
            color: #10b981;
            font-size: 1rem;
        }

        .type-badge {
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .type-badge.lecture {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            border: 1px solid rgba(30, 64, 175, 0.2);
        }

        .type-badge.lab {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 1px solid rgba(6, 95, 70, 0.2);
        }

        .type-badge i {
            font-size: 1rem;
        }

        .empty-schedule {
            text-align: center;
            padding: 80px 40px;
            color: #9ca3af;
        }

        .empty-schedule i {
            font-size: 5rem;
            color: #d1fae5;
            margin-bottom: 20px;
            display: block;
        }

        .empty-schedule p {
            font-size: 1.15rem;
            font-weight: 600;
        }

        /* Timeline connecting lines */
        .day-schedule:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 0;
            top: 100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #d1fae5, transparent);
        }

        @media (max-width: 768px) {
            .schedule-header {
                padding: 20px;
                margin-bottom: 24px;
            }

            .schedule-header h4 {
                font-size: 1.3rem;
            }

            .day-header {
                padding: 16px 20px;
                font-size: 1rem;
            }

            .schedule-item {
                padding: 16px 20px;
                gap: 16px;
                flex-wrap: wrap;
            }

            .time-block {
                min-width: 70px;
            }

            .start-time {
                font-size: 1rem;
            }

            .subject-info {
                width: 100%;
            }

            .type-badge {
                width: 100%;
                justify-content: flex-start;
            }
        }

        @media (max-width: 480px) {
            .schedule-header {
                padding: 16px;
            }

            .schedule-header h4 {
                font-size: 1.15rem;
            }

            .schedule-header p {
                font-size: 0.85rem;
            }

            .day-header {
                padding: 14px 16px;
                font-size: 0.95rem;
            }

            .schedule-item {
                padding: 14px 16px;
                gap: 12px;
            }

            .time-block {
                min-width: 60px;
            }

            .start-time {
                font-size: 0.95rem;
            }

            .subject-name {
                font-size: 0.9rem;
            }

            .doctor-info,
            .hall-info {
                font-size: 0.75rem;
            }

            .type-badge {
                font-size: 0.7rem;
                padding: 6px 12px;
            }

            .empty-schedule {
                padding: 60px 20px;
            }

            .empty-schedule i {
                font-size: 4rem;
            }

            .empty-schedule p {
                font-size: 1rem;
            }
        }
    </style>

    {{-- Page Header --}}
    <div class="schedule-header">
        <h4><i class="bi bi-table me-2"></i>جدولي الدراسي</h4>
        <p>
            <i class="bi bi-people me-2"></i>{{ auth()->user()->studentGroup->name ?? 'غير محدد' }}
            &nbsp;·&nbsp;
            <i class="bi bi-calendar me-2"></i>أيام الدراسة: {{ auth()->user()->studentGroup->study_days ?? '—' }}
        </p>
    </div>

    {{-- Schedule Items --}}
    @forelse($schedules as $dayLabel => $daySchedules)
        <div class="day-schedule">
            <div class="day-header">
                <i class="bi bi-calendar-event"></i>
                {{ $dayLabel }}
            </div>

            @foreach ($daySchedules as $s)
                <div class="schedule-item">
                    <div class="time-block">
                        <div class="start-time">{{ $s->start_time }}</div>
                        <div class="time-divider"></div>
                        <div class="end-time">{{ $s->end_time }}</div>
                    </div>

                    <div class="subject-info">
                        <div class="subject-name">{{ $s->subject->name }}</div>
                        <div class="doctor-info">
                            <i class="bi bi-person-badge"></i>
                            {{ $s->doctor?->name ?? 'غير محدد' }}
                        </div>
                        <div class="hall-info">
                            <i class="bi bi-geo-alt"></i>
                            {{ $s->hall?->name ?? 'غير محدد' }}
                        </div>
                    </div>

                    <div class="type-badge {{ $s->type === 'lecture' ? 'lecture' : 'lab' }}">
                        <i class="bi {{ $s->type === 'lecture' ? 'bi-book' : 'bi-pc-display' }}"></i>
                        {{ $s->type === 'lecture' ? 'محاضرة' : 'معمل' }}
                    </div>
                    @if ($s->type === 'lab')
                        <span class="badge badge-warning {{ $s->section_id ? 'section' : 'no-section' }}">
                            {{ $s->section_id ? "سكشن {$s->section_id}" : 'غير محدد' }}
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    @empty
        <div class="empty-schedule">
            <i class="bi bi-calendar-x"></i>
            <p>لا توجد محاضرات مجدولة لمجموعتك حالياً 📚</p>
        </div>
    @endforelse

@endsection
