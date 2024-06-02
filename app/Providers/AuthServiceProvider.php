<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        if(!Schema::hasTable('permissions')) {
            return;
        }
        foreach (Permission::all() as $permission) {
            Gate::define($permission->name, function (User $user) use ($permission) {
                return $user->permissions->contains('name', $permission->name) ? 
                    Response::allow() : 
                    Response::deny("Forbidden Action");
            });
        }
    }
}
