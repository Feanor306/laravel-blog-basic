<?php

namespace App\Http\ViewComposers;

use App\Post;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class ActivityComposer
{
    // When we register a View composer, all the variables declared
    // within the composer will always be available for the views that use composer
    // must be registered in AppSeviceProvider boot()
    // view()->composer('posts.index', ActivityComposer::class);
    public function compose(View $view)
    {
        $mostCommented = Cache::remember('mostCommented', now()->addHours(1), function(){
            return Post::mostCommented()->take(5)->get();
        });

        $view->with('mostCommented', $mostCommented);
    }
}