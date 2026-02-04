<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is worker
     */
    public function isWorker(): bool
    {
        return $this->role === 'worker';
    }

    /**
     * Get the worker profile associated with the user
     */
    public function worker()
    {
        return $this->hasOne(Worker::class);
    }

    /**
     * Get milk production records created by this user
     */
    public function milkProductions()
    {
        return $this->hasMany(MilkProduction::class, 'recorded_by');
    }

    /**
     * Get health records created by this user
     */
    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class, 'recorded_by');
    }

    /**
     * Get breeding records created by this user
     */
    public function breedings()
    {
        return $this->hasMany(Breeding::class, 'recorded_by');
    }

    /**
     * Get financial transactions created by this user
     */
    public function financialTransactions()
    {
        return $this->hasMany(FinancialTransaction::class, 'recorded_by');
    }
}
