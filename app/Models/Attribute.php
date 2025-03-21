<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $guarded = [
        'id',
    ];

    public $timestamps = false;


    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }


    public function getName()
    {
        return $this->name;
    }
}
