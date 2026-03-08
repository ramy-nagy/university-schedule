<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['name', 'description'];

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'schedule_section');
    }
}
