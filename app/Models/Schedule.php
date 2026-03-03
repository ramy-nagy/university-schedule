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
        'student_group_id','date','start_time','end_time','type'
    ];

    protected $casts = ['date' => 'date'];

    public function doctor()       { return $this->belongsTo(Doctor::class); }
    public function subject()      { return $this->belongsTo(Subject::class); }
    public function hall()         { return $this->belongsTo(Hall::class); }
    public function studentGroup() { return $this->belongsTo(StudentGroup::class); }

    // Scopes
    public function scopeForDoctor($q, $doctorId)      { return $q->where('doctor_id', $doctorId); }
    public function scopeForGroup($q, $groupId)        { return $q->where('student_group_id', $groupId); }
    public function scopeUpcoming($q)                  { return $q->where('date', '>=', today()); }
    public function scopeForDate($q, $date)            { return $q->where('date', $date); }
}