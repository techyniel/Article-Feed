<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Users;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($category) {
            $category->article()->delete();
        });
    }

    public function articles()
    {
        return $this->hasMany(article::class);
    }

    // public function users()
    // {
        // return $this->hasMany(users::class);
    // }

}
