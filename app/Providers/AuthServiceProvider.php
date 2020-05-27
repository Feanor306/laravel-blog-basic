<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',

        // IF YOU REGISTER POLICY IN THIS WAY
        // IT CAN BE CALLED BY
        // $this->authorize('policyMethodName', $modelInstance); in controller  
        // 'App\Post' => 'App\Policies\PostPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-post', function($user, $post) {
            return $user->id == $post->user_id;
        });

        Gate::define('delete-post', function($user, $post) {
            return $user->id == $post->user_id;
        });

        // BEFORE() gets called before any other gate checks
        Gate::before(function ($user, $ability) {
            if ($user->is_admin
                // IF WE WANT TO ALLOW ONLY CERTAIN ABILITIES TO ADMIN
                // && in_array($ability, ['update-post', 'delete-post'])
            ){
                return true;
            }
        });

        // AFTER() runs after the gate checks,
        // $result parameter contains the return value of the gate checks
        Gate::after(function ($user, $ability, $result) {
            if ($user->is_admin){
                return true;
            }
        });

        // GATE DEFINITION USING POLICY 
        // REMEMBER TO CALL BY NEW NAME posts.update etc.
        // Gate::define('posts.update', 'App\Policies\PostPolicy@update');
        // Gate::define('posts.delete', 'App\Policies\PostPolicy@delete');

        // GATE DEFINITION FOR WHOLE MODEL USING POLICY
        // REMEMBER ALL METHODS IN POLICY THAT WE CALL USING 
        // $this->authorize('posts.method'); in controller 
        // MUST HAVE RETURN (bool) 
        // Gate::resource('posts', 'App\Policies\PostPolicy');
        // CAN ALSO BE DEFINED ABOVE AT protected $policies = []
    }
}
