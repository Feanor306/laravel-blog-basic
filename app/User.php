<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeWithMostPosts(Builder $query)
    {
        return $query->widthCount('posts')->orderBy('posts_count', 'desc');
    }

    public function scopeWithMostPostsLastMonth(Builder $query)
    {
        return $query->widthCount(['posts' => function(Builder $query){
            $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
        }])
        ->has('posts_count', '>=', 2)
        ->orderBy('posts_count', 'desc');
    }

    // 1-TO-MANY relationship to posts
    public function posts()
    {
        //return $this->hasMany(Post::class);
        return $this->hasMany('App\Post');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /* MIGRATION
    $table->id();
    $table->string('name');
    $table->string('email', 191)->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->boolean('is_admin')->default(false);
    $table->rememberToken();
    $table->timestamps();
    */
}
