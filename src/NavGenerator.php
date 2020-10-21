<?php


namespace AwemaPL\Navigation;

use Illuminate\Support\Facades\Request;

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

    /**
     * @return array
     */
    public function getNavs(): array
    {
        $navs = config('navigation.navs', []);
        foreach ($navs as &$nav) {
            $nav = $this->setActive($nav);
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
            $this->getNavs();
        }
        return $this->top_navs['navs'];
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
        foreach ($segments as $index => $segment){
            if (isset($pathSegments[$index]) && $segment === $pathSegments[$index]){
                return true;
            }
        }

        return false;

//        return Request::is($path);
    }

    /**
     * @param array $items
     * @param int|null $level
     * @return array
     */
    protected function setActive(array $items, ?int $level = null): array
    {
        $level = $level ?? 0;
        $top_var_name = config('navigation.top_var_name');
        foreach ($items as &$item) {
            if ($active = $this->isActive($item)) {
                $item['active'] = true;
            }
            if (!empty($item['children'] ?? null)) {
                $item['children'] = $this->setActive($item['children'], $level + 1);
            }
            if (!empty($item[$top_var_name] ?? null)) {
                $item[$top_var_name] = $this->setActive($item[$top_var_name]);
                if (($this->top_navs['level'] <= $level) && $active) {
                    $this->top_navs['navs'] = $item[$top_var_name];
                }
            }
        }

        return $items;
    }
}
