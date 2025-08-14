<?php

namespace App\Providers;

use App\Models\Hero;
use App\Models\Keunggulan;
use App\Models\Statistik;
use App\Models\AboutHero;
use App\Models\User;
use App\Policies\HeroPolicy;
use App\Policies\KeunggulanPolicy;
use App\Policies\StatistikPolicy;
use App\Policies\AboutHeroPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Hero::class => HeroPolicy::class,
        Keunggulan::class => KeunggulanPolicy::class,
        Statistik::class => StatistikPolicy::class,
        AboutHero::class => AboutHeroPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
