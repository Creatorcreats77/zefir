<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
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


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function homeCategory()
    {
        return $this->belongsTo(Category::class, 'home_category_id');
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public function color()
    {
        return $this->belongsTo(AttributeValue::class, 'color_id');
    }


    public function variants()
    {
        return $this->hasMany(Variant::class);
    }


    public function scopeOnlyOwner(Builder $query): void
    {
        $query->when(!auth()->user()['is_admin'], function ($query) {
            return $query->where('user_id', auth()->id());
        });
    }


    public function getImage()
    {
        if (isset($this->image)) {

        } else {
            return asset('img/gender-' . $this->gender_id . '.jpg');
        }
    }


    public function isNew()
    {
        return $this->created_at >= Carbon::now()->subMonths(2);
    }


    public function getName()
    {
        return $this->name;
    }
}
