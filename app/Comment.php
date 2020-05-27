<?php

namespace App;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    
    public function post()
    {
        // CREATES MANY-TO-1 RELATIONSHIP TO POST
        return $this->belongsTo('App\Post');
    }

    // MANY-TO-1 relationship to USER
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Local query scope, must start with scope{Name}
    // call it as latest()
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LatestScope);
    }

    // MIGRATION FIELDS
    // $table->text('content');

    // MIGRATION FOREIGN KEY
    // $table->unsignedInteger('post_id')->index();
    // $table->foreign('blog_post_id')->references('id')->on('posts')->onDelete('cascade');
}
