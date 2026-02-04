<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Breeding extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'breeding';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'animal_id',
        'service_date',
        'expected_birth_date',
        'actual_birth_date',
        'bull_name',
        'pregnancy_status',
        'notes',
        'recorded_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'service_date' => 'date',
        'expected_birth_date' => 'date',
        'actual_birth_date' => 'date',
    ];

    /**
     * Get the animal that owns the breeding record
     */
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    /**
     * Get the user who recorded this breeding
     */
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Scope a query to only include pending records
     */
    public function scopePending($query)
    {
        return $query->where('pregnancy_status', 'pending');
    }

    /**
     * Scope a query to only include pregnant records
     */
    public function scopePregnant($query)
    {
        return $query->where('pregnancy_status', 'pregnant');
    }

    /**
     * Scope a query to only include successful births
     */
    public function scopeGaveBirth($query)
    {
        return $query->where('pregnancy_status', 'gave_birth');
    }

    /**
     * Scope a query to only include failed pregnancies
     */
    public function scopeFailed($query)
    {
        return $query->where('pregnancy_status', 'failed');
    }

    /**
     * Scope a query to only include active pregnancies
     */
    public function scopeActive($query)
    {
        return $query->whereIn('pregnancy_status', ['pending', 'pregnant']);
    }

    /**
     * Scope a query for upcoming births (within next 30 days)
     */
    public function scopeUpcomingBirths($query, $days = 30)
    {
        return $query->where('pregnancy_status', 'pregnant')
            ->whereNotNull('expected_birth_date')
            ->whereBetween('expected_birth_date', [
                now(),
                now()->addDays($days)
            ]);
    }

    /**
     * Get days until expected birth
     */
    public function getDaysUntilBirthAttribute(): ?int
    {
        if (!$this->expected_birth_date || $this->pregnancy_status !== 'pregnant') {
            return null;
        }

        return Carbon::parse($this->expected_birth_date)->diffInDays(now(), false);
    }

    /**
     * Check if birth is overdue
     */
    public function isOverdue(): bool
    {
        if (!$this->expected_birth_date || $this->pregnancy_status !== 'pregnant') {
            return false;
        }

        return Carbon::parse($this->expected_birth_date)->isPast();
    }
}
