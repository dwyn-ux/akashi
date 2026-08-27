<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'date',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }
}
