<?php


// ══════════════════════════════════════════════════════════
// FILE: app/Models/Doctor.php
// ══════════════════════════════════════════════════════════
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = ['user_id', 'name', 'department', 'phone'];

    public function user()       { return $this->belongsTo(User::class); }
    public function subjects()   { return $this->hasMany(Subject::class); }
    public function schedules()  { return $this->hasMany(Schedule::class); }

    public function upcomingSchedules()
    {
        return $this->schedules()
            ->with(['subject', 'hall', 'studentGroup'])
            ->where('date', '>=', today())
            ->orderBy('date')->orderBy('start_time');
    }
}