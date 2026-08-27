<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'full_name',
        'nisn',
        'gender',
        'birth_place',
        'birth_date',
        'school',
        'grade_class',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
