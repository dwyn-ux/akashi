<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'reg_number',
        'status',
        'payment_status',
        'admin_note',
        'extra_choice',
        'participant_id',
        'competition_id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(RegistrationDocument::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(RegistrationMember::class);
    }
}
