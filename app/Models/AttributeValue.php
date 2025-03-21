<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $guarded = [
        'id',
    ];

    public $timestamps = false;


    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }


    public function colorProducts()
    {
        return $this->hasMany(Product::class, 'color_id');
    }


    public function sizeVariants()
    {
        return $this->hasMany(Variant::class, 'size_id');
    }


    public function getName()
    {
        return $this->name;
    }
}
