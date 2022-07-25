<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Post' => 'App\Policies\PostPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-post', 'App\Policies\PostPolicy@view');

        Gate::define('update-post', function (User $user, Post $post) {
            return $user->id === $post->user_id;
        });

        Gate::define('create-post', 'App\Policies\PostPolicy@create');
        Gate::define('delete-post', 'App\Policies\PostPolicy@delete');
    }
}
