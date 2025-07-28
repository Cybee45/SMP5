<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Filament Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Filament will be accessible from.
    | You can change it to any path you like.
    |
    */

    'path' => env('FILAMENT_PATH', 'admin'),

    /*
    |--------------------------------------------------------------------------
    | Filament Core Resource Registration
    |--------------------------------------------------------------------------
    |
    | Whether to automatically register Filament's built-in resources.
    |
    */

    'register_core_resources' => true,

    /*
    |--------------------------------------------------------------------------
    | Filament Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be applied to every Filament request.
    | You may customize this middleware or add your own.
    |
    */

    'middleware' => [
        'web',
        \Filament\Http\Middleware\Authenticate::class,
        \Filament\Http\Middleware\DisableBladeIconComponents::class,
        \Filament\Http\Middleware\DispatchServingFilamentEvent::class,
        \Filament\Http\Middleware\SetUpDefaultFilamentTheme::class,
        \Filament\Http\Middleware\BootFilamentTenancy::class,
        App\Http\Middleware\EnsureRole::class, // jika kamu memakai middleware akses role
    ],

    /*
    |--------------------------------------------------------------------------
    | Filament Auth Guard
    |--------------------------------------------------------------------------
    |
    | Here you may specify the authentication guard that should be used
    | while accessing Filament.
    |
    */

    'auth_guard' => env('FILAMENT_AUTH_GUARD', 'web'),

    /*
    |--------------------------------------------------------------------------
    | Filament User Model
    |--------------------------------------------------------------------------
    |
    | This is the user model that Filament uses to authenticate users.
    | It must implement the Filament\Models\Contracts\FilamentUser contract.
    |
    */

    'user_model' => App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Filament Panel Configuration
    |--------------------------------------------------------------------------
    |
    | Configure your custom panel settings here.
    |
    */

    'panel' => [
        'id' => 'default',
        'path' => 'admin',
        'domain' => null,
        'middleware' => ['web'],
        'auth_guard' => 'web',
    ],

    /*
    |--------------------------------------------------------------------------
    | Filament Branding
    |--------------------------------------------------------------------------
    |
    | Customize the branding elements like name and logo.
    |
    */

    'brand' => [
        'name' => 'Admin Sekolah',
        'logo' => null,
        'favicon' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Filament Theme (Opsional untuk Tailwind Extend)
    |--------------------------------------------------------------------------
    */

    'theme' => [
        'colors' => [
            'primary' => '#0d6efd',
        ],
    ],
];
