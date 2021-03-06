<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\ActivityComposer;
use App\View\Components\Errors;
use App\View\Components\Tags;
use App\View\Components\Updated;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // This will solve the problem with maximum key length (default 255)
        Schema::defaultStringLength(191);
        
        Blade::component('components.badge', 'badge');
        //Blade::component('components.updated', 'updated');
        //Blade::component('components.tags', 'tags');
        //Blade::component('components.errors', 'errors');
        Blade::component('updated', Updated::class);
        Blade::component('tags', Tags::class);
        Blade::component('errors', Errors::class);
        

        // When we register a View composer, all the variables declared
        // within the composer will always be available for this view
        view()->composer('posts.index', ActivityComposer::class);
        //view()->composer(['posts.index', 'posts.show'], ActivityComposer::class);
        //view()->composer('*', ActivityComposer::class);
    }
}
