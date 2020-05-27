<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // MANY-TO-MANY RELATIONSHIP TO Post
    public function posts()
    {
        //return $this->belongsToMany('App\Post');
        return $this->belongsToMany('App\Post')->withTimestamps()->as('tagged');
    }

    // MIGRATIONS
    // $table->string('name', 40);

    // MIGRATIONS FOR POST_TAG TABLE WHICH CREATES
    // MANY-TO-MANY RELATIONSHIP
    // $table->unsignedInteger('post_id')->index();
    // $table->foreign('post_id')->references('id')
    //     ->on('posts')
    //     ->onDelete('cascade');
    // $table->unsignedInteger('tag_id')->index();
    // $table->foreign('tag_id')->references('id')
    //     ->on('tags')
    //     ->onDelete('cascade');
    
}
