<?php


namespace AwemaPL\Navigation;

use AwemaPL\Navigation\NavChecker;
use AwemaPL\Navigation\NavGenerator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NavigationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/navigation.php' => config_path('navigation.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/navigation.php',
            'navigation'
        );

        $generator = new NavGenerator();

        $navs = $generator->getNavs();
        foreach ($navs as $var => $items) {
            NavChecker::check($items);
            View::composer('*', function ($view) use ($var, $items) {
                $view->with($var, $items);
            });
        }

        if (!empty($navs = $generator->getTopNavs())) {
            NavChecker::check($navs);
            View::composer('*', function ($view) use ($navs) {
                $view->with(config('navigation.top_var_name'), $navs);
            });
        }
    }
}
