<?php


// ══════════════════════════════════════════════════════════
// FILE: app/Models/Schedule.php
// ══════════════════════════════════════════════════════════
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'doctor_id','subject_id','hall_id',
        'student_group_id','day_of_week','start_time','end_time','type',
    ];

    public function doctor()       { return $this->belongsTo(Doctor::class); }
    public function subject()      { return $this->belongsTo(Subject::class); }
    public function hall()         { return $this->belongsTo(Hall::class); }
    public function studentGroup() { return $this->belongsTo(StudentGroup::class); }
    public function sections()     { return $this->belongsToMany(Section::class, 'schedule_section'); }

    // Accessors
    public function getDayOfWeekLabelAttribute()
    {
        $days = [
            'saturday'  => 'السبت',
            'sunday'    => 'الأحد',
            'monday'    => 'الاثنين',
            'tuesday'   => 'الثلاثاء',
            'wednesday' => 'الأربعاء',
            'thursday'  => 'الخميس',
            'friday'    => 'الجمعة',
        ];
        return $days[$this->day_of_week] ?? $this->day_of_week;
    }

    // Scopes
    public function scopeForDoctor($q, $doctorId)      { return $q->where('doctor_id', $doctorId); }
    public function scopeForGroup($q, $groupId)        { return $q->where('student_group_id', $groupId); }
    public function scopeForSection($q, $sectionId)   { return $q->where('section_id', $sectionId); }
    public function scopeForDay($q, $dayOfWeek)        { return $q->where('day_of_week', $dayOfWeek); }
}