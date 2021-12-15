<?php

namespace AwemaPL\Navigation\Middlewares;

use AwemaPL\Auth\Facades\Auth;
use AwemaPL\Navigation\NavChecker;
use AwemaPL\Navigation\NavGenerator;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class AddNavigationComponent
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
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
        return $next($request);
    }
}