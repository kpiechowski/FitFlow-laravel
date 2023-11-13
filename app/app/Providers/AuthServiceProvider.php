<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Team;
use App\Models\TeamRequest;
use App\Policies\TeamPolicy;
use App\Policies\TeamRequestPolicy;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        Team::class => TeamPolicy::class,
        TeamRequest::class => TeamRequestPolicy::class,


    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
