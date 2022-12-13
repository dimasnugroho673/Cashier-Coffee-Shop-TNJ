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

        // foreach ($roleUsers as $ru) {
        //     Gate::define($ru->role->name, function($ru) {
        //         return $ru->role->name;
        //     });
        // }

        Gate::define('admin', function () {
            $roleUsers = RoleUser::get();

            foreach ($roleUsers as $ru) {
                if ((auth()->user()->id == $ru->user->id) && ($ru->role->name == 'admin')) {
                    return true;
                } else {
                    return false;
                }
            }
        });

        Gate::define('cashier', function () {
            $roleUsers = RoleUser::get();
            $policies = RoleUser::where(['user_id' => auth()->user()->id, 'role_id' => 2])->first();

            if (!empty($policies)) {
                return true;
            } else {
                return false;
            }

            // foreach ($roleUsers as $ru) {
            //     if ((auth()->user()->id == $ru->user->id) && ($ru->role->name == 'cashier')) {
            //         return true;
            //     } else {
            //         return false;
            //     }
            // }
        });
    }
}
