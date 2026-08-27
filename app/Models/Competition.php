<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'category',
        'level',
        'description',
        'min_age',
        'max_age',
        'grade_class',
        'quota',
        'fee',
        'location',
        'schedule_text',
        'duration',
        'status',
        'cover_url',
        'team_size',
        'prize_1',
        'prize_2',
        'prize_3',
        'prize_extra',
        'requirements',
        'rules',
        'required_docs',
        'contact_person',
    ];

    protected function casts(): array
    {
        return [
            'min_age' => 'integer',
            'max_age' => 'integer',
            'quota' => 'integer',
            'fee' => 'integer',
            'team_size' => 'integer',
            'status' => 'string',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'OPEN');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'DRAFT');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'CLOSED');
    }
}
