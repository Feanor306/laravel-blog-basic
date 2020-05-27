<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = ['path'];

    // public function post()
    // {
    //     return $this->belongsTo('App\Post');
    // }

    // ONE TO ONE *POLYMORPHIC (TO MULTIPLE OTHER TABLES)
    public function imageable()
    {
        return $this->morphTo();
    }

    public function url()
    {
        return Storage::url($this->path);
    }

    // MIGRATIONS
    // $table->id();
    // $table->string('path');
    // $table->unsignedInteger('post_id')->nullable();
    // $table->timestamps();

    // MORPHS WILL CREATE FOREIGN TABLE ID AND TYPE (NO FK) (REMOVE post_id)
    // $table->morphs('imageable');
}
