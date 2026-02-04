<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'animal_id',
        'record_date',
        'condition',
        'treatment',
        'doctor_name',
        'vaccination',
        'notes',
        'recorded_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'record_date' => 'date',
    ];

    /**
     * Get the animal that owns the health record
     */
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    /**
     * Get the user who recorded this health record
     */
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Scope a query to only include vaccination records
     */
    public function scopeVaccinations($query)
    {
        return $query->whereNotNull('vaccination');
    }

    /**
     * Scope a query to only include treatment records
     */
    public function scopeTreatments($query)
    {
        return $query->whereNotNull('treatment');
    }

    /**
     * Scope a query to filter by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('record_date', [$startDate, $endDate]);
    }

    /**
     * Scope a query to only include recent records
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('record_date', '>=', now()->subDays($days));
    }
}
