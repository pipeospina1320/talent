<?php

namespace App\Providers;

use App\Models\Challenge;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'users' => User::class,
            'challenges' => Challenge::class,
            'companies' => Company::class,
        ]);
    }
}
