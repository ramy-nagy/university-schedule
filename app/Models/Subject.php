<?php


// ══════════════════════════════════════════════════════════
// FILE: app/Models/Subject.php
// ══════════════════════════════════════════════════════════
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'code', 'doctor_id', 'description'];

    public function doctor()    { return $this->belongsTo(Doctor::class); }
    public function schedules() { return $this->hasMany(Schedule::class); }
}