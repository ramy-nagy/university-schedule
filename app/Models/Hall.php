<?php
// ══════════════════════════════════════════════════════════
// FILE: app/Models/Hall.php
// ══════════════════════════════════════════════════════════
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    protected $fillable = ['name', 'type', 'description', 'capacity'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Helper: is this hall free at a given time?
    public function isFreeAt(string $date, string $start, string $end, ?int $excludeId = null): bool
    {
        return !$this->schedules()
            ->where('date', $date)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->where(fn($q) =>
                $q->whereBetween('start_time', [$start, $end])
                  ->orWhereBetween('end_time', [$start, $end])
                  ->orWhere(fn($q) => $q->where('start_time','<=',$start)->where('end_time','>=',$end))
            )->exists();
    }
}
