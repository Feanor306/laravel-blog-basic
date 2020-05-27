<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function profile()
    {
        //CREATES 1-TO-1 RELATIONSHIP TO PROFILE
        return $this->hasOne('App\Profile');
    }
}
