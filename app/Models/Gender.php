<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $guarded = [
        'id',
    ];

    public $timestamps = false;


    public function categories()
    {
        return $this->hasMany(Category::class);
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function getName()
    {
        $locale = app()->getLocale();
        if ($locale == 'tm') {
            return $this->name_tm ?: $this->name;
        } elseif ($locale == 'ru') {
            return $this->name_ru ?: $this->name;
        } else {
            return $this->name;
        }
    }
}
