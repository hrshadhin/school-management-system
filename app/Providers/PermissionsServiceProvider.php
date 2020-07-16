<?php

namespace App\Providers;

use App\Http\Helpers\AppHelper;
use Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

            AppHelper::getPermissions()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    // for super admin no need to check permissions
                    if($user->is_super_admin) {
                        return true;
                    }
                    return $user->hasPermissionTo($permission);
                });
            });

            Blade::directive('role', function ($role) {
                return "<?php if(auth()->check() && auth()->user()->hasRole({$role})) : ?>";
            });
            Blade::directive('endrole', function ($role) {
                return "<?php endif; ?>";
            });

            Blade::directive('notrole', function ($role) {
                return "<?php if(auth()->check() && !auth()->user()->hasRole({$role})) : ?>";
            });
            Blade::directive('endnotrole', function ($role) {
                return "<?php endif; ?>";
            });

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
