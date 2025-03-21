<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'datetime_start' => 'datetime',
            'datetime_end' => 'datetime',
        ];
    }

    public $timestamps = false;
}
