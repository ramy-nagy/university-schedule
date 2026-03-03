<?php


// ══════════════════════════════════════════════════════════
// FILE: app/Models/StudentGroup.php
// ══════════════════════════════════════════════════════════
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
    protected $fillable = ['name', 'study_days', 'description'];

    public function students()   { return $this->hasMany(User::class); }
    public function schedules()  { return $this->hasMany(Schedule::class); }
}