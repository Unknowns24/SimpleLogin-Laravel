<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Auth;
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

        Auth::provider('eloquent', function($app, array $config)
        {
            return new class($app['hash'], $config['model']) extends \Illuminate\Auth\EloquentUserProvider
            {
                public function validateCredentials(UserContract $user, array $credentials)
                {
                    $pass = $credentials['password'];
            
                    if ($pass == $user->getAuthPassword()) {
                      return true;
                    }
                
                    return false; 
                }
            };
        });
    }
}
