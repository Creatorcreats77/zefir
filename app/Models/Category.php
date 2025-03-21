<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [
        'id',
    ];

    public $timestamps = false;


    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function homeProducts()
    {
        return $this->hasMany(Product::class, 'home_category_id');
    }


    public function grandparent()
    {
        return $this->belongsTo(self::class, 'grandparent_id');
    }


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }


    public function grandChildren()
    {
        return $this->hasMany(self::class, 'grandparent_id');
    }


    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }


    public function getName()
    {
        return $this->name;
    }
}
