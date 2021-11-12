<?php

namespace App\Providers;

use App\Models\Leave;
use App\Models\User;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('approve-leave', function (User $user) {
            return $user->role_id === 1;
        });

        Gate::define('cancel-leave', function (User $user, Leave $leave) {
            return $user->id === $leave->staff_id;
        });
    }
}
