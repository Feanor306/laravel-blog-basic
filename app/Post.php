<?php

namespace App;

use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    // ENABLES SOFT DELETING ON MODEL
    use SoftDeletes;

    // TABLE NAME
    protected $table = 'posts';

    // ACCESSIBLE FIELDS
    protected $fillable = ['title', 'content', 'user_id'];
    
    // CREATES 1-TO-MANY RELATIONSHIP TO COMMENT
    public function comments()
    {
        // USE COMMENTS LOCAL QUERY SCOPE scopeLatest() by default
        // return $this->hasMany('App\Comment')->latest();

        return $this->hasMany('App\Comment');

        // optional parameters if foreign key name or post id is custom
        // return $this->hasMany('App\Comment', 'foreign_key_name', 'related_table_primary_key');
    }

    // MANY-TO-1 relationship to USER
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // MANY-TO-MANY relationship to TAG
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    // ONE-TO-ONE *POLYMORPHIC relationship with IMAGE
    public function image()
    {
        //return $this->hasOne('App\Image');
        return $this->morphOne('App\Image', 'imageable');
    }

    // Local query scope, must start with scope{Name}
    // call it as latest()
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        return $query->widthCount('comments')->orderBy('comments_count', 'desc');
    }

    public static function boot()
    {
        // Soft deletes in parent boot take precedence
        // So we need to call this before parent::boot()
        static::addGlobalScope(new DeletedAdminScope);

        parent::boot();

        //static::addGlobalScope(new LatestScope);
        
        static::deleting(function (Post $post) {
            // Deletes related comments
            $post->comments()->delete();
            // $post->image()->delete();
            // Reset cache on delete
        });

        static::restoring(function (Post $post) {
            // Cascade restore related comments
            $post->comments()->restore();
        });

        // RESET CACHE ON UPDATE
        // static::updating(function (Post $post){
        //     Cache::forget("post-{$post->id}");
        // });
    }
    
    // MIGRATIONS
    // $table->string('title')->default('');
    // $table->string('content')->default('');
    // $table->timestamps();
    // $table->softDeletes();

    // $table->unsignedInteger('user_id');
    // $table->foreign('user_id')->references('id')->on('users');

    // MIGRATIONS DOWN
    // $table->dropForeign(['user_id']);
    // $table->dropColumn('user_id');
}
