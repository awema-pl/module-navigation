<?php


namespace AwemaPL\Navigation;

use App\Http\Kernel;
use AwemaPL\Navigation\Middlewares\AddNavigationComponent;
use AwemaPL\Navigation\NavChecker;
use AwemaPL\Navigation\NavGenerator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NavigationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->make(\Illuminate\Contracts\Http\Kernel::class)
            ->appendMiddlewareToGroup('web', AddNavigationComponent::class);

        $this->publishes([
            __DIR__ . '/../config/navigation.php' => config_path('navigation.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/navigation.php',
            'navigation'
        );

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'navigation');

    }
}
