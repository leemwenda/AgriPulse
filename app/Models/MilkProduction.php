<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MilkProduction extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'milk_production';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'animal_id',
        'production_date',
        'quantity_liters',
        'notes',
        'recorded_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'production_date' => 'date',
        'quantity_liters' => 'decimal:2',
    ];

    /**
     * Get the animal that owns the milk production record
     */
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    /**
     * Get the user who recorded this production
     */
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Scope a query to only include records from today
     */
    public function scopeToday($query)
    {
        return $query->whereDate('production_date', today());
    }

    /**
     * Scope a query to only include records from this week
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('production_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope a query to only include records from this month
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('production_date', now()->month)
            ->whereYear('production_date', now()->year);
    }

    /**
     * Scope a query to filter by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('production_date', [$startDate, $endDate]);
    }
}
