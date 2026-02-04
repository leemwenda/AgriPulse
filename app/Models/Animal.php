<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Animal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'tag_number',
        'breed',
        'gender',
        'date_of_birth',
        'color',
        'notes',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the animal's age in years
     */
    public function getAgeAttribute(): string
    {
        $years = Carbon::parse($this->date_of_birth)->age;
        $months = Carbon::parse($this->date_of_birth)->diffInMonths(Carbon::now()) % 12;
        
        if ($years > 0) {
            return $years . ' year' . ($years > 1 ? 's' : '') . 
                   ($months > 0 ? ' ' . $months . ' month' . ($months > 1 ? 's' : '') : '');
        }
        
        return $months . ' month' . ($months > 1 ? 's' : '');
    }

    /**
     * Get milk production records for this animal
     */
    public function milkProductions()
    {
        return $this->hasMany(MilkProduction::class);
    }

    /**
     * Get health records for this animal
     */
    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class);
    }

    /**
     * Get breeding records for this animal
     */
    public function breedings()
    {
        return $this->hasMany(Breeding::class);
    }

    /**
     * Get latest milk production
     */
    public function latestMilkProduction()
    {
        return $this->hasOne(MilkProduction::class)->latestOfMany();
    }

    /**
     * Get latest health record
     */
    public function latestHealthRecord()
    {
        return $this->hasOne(HealthRecord::class)->latestOfMany();
    }

    /**
     * Get active breeding record
     */
    public function activeBreeding()
    {
        return $this->hasOne(Breeding::class)
            ->whereIn('pregnancy_status', ['pending', 'pregnant'])
            ->latest();
    }

    /**
     * Scope a query to only include active animals
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include female animals
     */
    public function scopeFemale($query)
    {
        return $query->where('gender', 'female');
    }

    /**
     * Scope a query to only include male animals
     */
    public function scopeMale($query)
    {
        return $query->where('gender', 'male');
    }
}
