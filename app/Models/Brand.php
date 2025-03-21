<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = [
        'id',
    ];

    public $timestamps = false;


    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function getName()
    {
        return $this->name;
    }


    public function getImage()
    {
        if (isset($this->image)) {

        } else {
            return asset('img/brand.jpg');
        }
    }
}
