<?php


namespace AwemaPL\Navigation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class NavGenerator
{
    /**
     * @var array
     */
    protected $navs;

    /**
     * @var array
     */
    protected $top_navs = [
        'navs' => [],
        'level' => 0
    ];

    /** @var array $routes */
    protected $routes;

    /**
     * @return array
     */
    public function getNavs($isTop = false): array
    {
        $tempNavs = config('temp_navigation.navs', []);
        $navs = config('navigation.navs', []);
        if ($tempNavs){
            $navs = array_merge($navs, $tempNavs);
        }
        foreach ($navs as &$nav) {
            $nav = $this->setActive($nav, null, $isTop);
            $nav = $this->translate($nav);
            $nav = $this->permission($nav);
            $nav = $this->existLink($nav);
        }
        $this->navs = $navs;

        return $navs;
    }

    /**
     * @return array
     */
    public function getTopNavs(): array
    {
        if (empty($navs)) {
            $this->getNavs(true);
        }

        return $this->top_navs['navs'];
    }

    /**
     * @param array $item
     * @return bool
     */
    protected function isActiveTop(array $item): bool
    {

        $path = $item['link'] ?? null;

        if (!empty($item['active']) && is_bool($item['active'])) {
            return $item['active'];
        }
        if (empty($path)) {
            return false;
        }

        $path = trim($path, '/');

        $segments = Request::segments();
        $pathSegments = explode('/', $path);


        return !array_diff($segments, $pathSegments);
    }

    /**
     * @param array $item
     * @return bool
     */
    protected function isActive(array $item): bool
    {
        $path = $item['link'] ?? null;

        if (!empty($item['active']) && is_bool($item['active'])) {
            return $item['active'];
        }
        if (empty($path)) {
            return false;
        }
        $path = trim($path, '/');
        if (!($item['exact'] ?? false)) {
            $path = $path;
        }

        $segments = Request::segments();
        $pathSegments = explode('/', $path);

        $countEqualSegments = 0;
        $isActive = false;
        foreach ($segments as $index => $segment){
            if (isset($pathSegments[$index]) && $segment === $pathSegments[$index]){
                $countEqualSegments++;
            } else {
                break;
            }
        }

       return $countEqualSegments > 0 && $countEqualSegments >= sizeof($segments) -1;
    }
    
    /**
     * @param array $items
     * @param int|null $level
     * @return array
     */
    protected function translate(array $items): array
    {
        foreach ($items as &$item) {
            
            if (!empty($item['children'] ?? null)) {
                $item['children'] = $this->translate($item['children']);
            }

            if ($item['key'] ?? null){
                $item['name'] = _p($item['key'], $item['name']);
            }
        }
       
        return $items;
    }

    /**
     * @param array $items
     * @param int|null $level
     * @param bool $isTop
     * @return array
     */
    protected function setActive(array $items, ?int $level = null, $isTop = false): array
    {
        $level = $level ?? 0;
        $top_var_name = config('navigation.top_var_name');
        foreach ($items as &$item) {
            if ($active = !$isTop && $this->isActive($item)) {
                $item['active'] = true;
            }
            if ($activeTop = $isTop && $this->isActiveTop($item)) {
                $item['active'] = true;
            }
            if (!empty($item['children'] ?? null)) {
                $item['children'] = $this->setActive($item['children'], $level + 1, true);
            }

            if (!empty($item[$top_var_name] ?? null)) {


                $item[$top_var_name] = $this->setActive($item[$top_var_name], $level, true);
                $item[$top_var_name] = $this->translate($item[$top_var_name]);
                $item[$top_var_name] = $this->permission($item[$top_var_name]);
                $item[$top_var_name] = $this->existLink($item[$top_var_name]);

                if (($this->top_navs['level'] <= $level) && $active) {
                    $this->top_navs['navs'] = $item[$top_var_name];
                }
            }
        }

        return $items;
    }

    /**
     * @param array $items
     * @param int|null $level
     * @return array
     */
    protected function permission(array $items): array
    {
        foreach ($items as $index=> &$item) {

            if (!empty($item['children'] ?? null)) {
                $item['children'] = $this->permission($item['children']);
            }

            if (!empty($item['link']) ?? null){
                if (!$this->isExistLink($item['link'])){
                    unset($items[$index]);
                }
            }

            if ($item['permissions'] ?? null){

                if (!Auth::check()){
                    unset($items[$index]);
                } else {
                    $hasPermission = Auth::user()->can($item['permissions']);
                    if (!$hasPermission){
                        unset($items[$index]);
                    }
                }
            }

        }

        return $items;
    }

    /**
     * @param array $items
     * @param int|null $level
     * @return array
     */
    protected function existLink(array $items): array
    {
        foreach ($items as $index=> &$item) {
            if (!empty($item['children'] ?? null)) {
                $item['children'] = $this->existLink($item['children']);
            }
            if (!empty($item['link']) ?? null){
                if (!$this->isExistLink($item['link'])){
                    unset($items[$index]);
                }
            }
        }

        return $items;
    }

    /**
     * Is exist link in application
     *
     * @param $link
     * @return bool
     */
    protected function isExistLink($link)
    {
        if (!$this->routes) {
            $this->routes = Route::getRoutes();
        }
        $request = Request::create($link);
        try {
            $this->routes->match($request);
            return true;
        }
        catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e){
            return false;
        }
    }

}
