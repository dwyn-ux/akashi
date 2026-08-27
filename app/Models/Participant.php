<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'nisn',
        'full_name',
        'gender',
        'birth_place',
        'birth_date',
        'school',
        'grade_class',
        'address',
        'whatsapp',
        'email',
        'guardian',
        'guardian_rel',
        'guardian_wa',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function members(): HasManyThrough
    {
        return $this->hasManyThrough(RegistrationMember::class, Registration::class);
    }
}
