<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $guarded = [
        'id',
    ];


    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function size()
    {
        return $this->belongsTo(AttributeValue::class, 'size_id');
    }
}
