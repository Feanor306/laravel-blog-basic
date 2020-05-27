<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function author()
    {
        //CREATES 1-TO-1 RELATIONSHIP TO Author
        return $this->belongsTo('App\Author');
    }

    // MIGRATION FOREIGN KEY
    // $table->unsignedInteger('author_id')->unique();
    // $table->foreign('author_id')->references('id')->on('authors');
}
