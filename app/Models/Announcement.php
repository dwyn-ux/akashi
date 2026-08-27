<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'title',
        'body',
        'competition_id',
        'published',
    ];

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    public function winners(): HasMany
    {
        return $this->hasMany(Winner::class);
    }

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }
}
