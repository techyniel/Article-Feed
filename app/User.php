<?php

namespace App;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password'
        // 'category_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if(empty($user->api_token)) {
                $user->api_token = str_random(50);
            }
        });

        static::deleting(function ($user) {
            $user->article()->delete();
            $user->comments()->delete();
        });
    }

    public function article()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeAdmin($query)
    {
        return $query->where('is_admin', true);
    }
}
