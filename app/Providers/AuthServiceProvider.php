<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
public function boot()
{
    $this->registerPolicies();

    Gate::define('isColaborador', fn($user) => $user->isColaborador());
    Gate::define('isTecnico', fn($user) => $user->isTecnico());
}

}
