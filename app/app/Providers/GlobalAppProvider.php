<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class GlobalAppProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //

        // dd(Auth::check());
        // if(Auth::check()){
        //     view()->composer('*', function ($view) {

        //         $user = Auth::user();
        //         $hasTeam = $user->team;
        //         dump($hasTeam);

        //         $view()->share('userHasTeam', $hasTeam);
        //     });

        // }
    }
}
