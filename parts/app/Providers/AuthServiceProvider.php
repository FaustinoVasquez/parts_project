<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Kit;
use App\Models\User;
use App\Policies\KitPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Kit::class => KitPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
