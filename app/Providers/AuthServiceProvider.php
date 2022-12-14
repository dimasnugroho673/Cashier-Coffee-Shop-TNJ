<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        $roles = Role::get();

        foreach ($roles as $ru) {
            Gate::define($ru->name, function() use ($ru) {
                $getLoggedinAccountRole = RoleUser::join('roles', 'roles.id', '=', 'role_users.role_id')->where('role_users.user_id', auth()->user()->id)->first();

                if ($ru->name == $getLoggedinAccountRole->name) {
                    return true;
                } else {
                    return false;
                }
            });
        }
    }
}
