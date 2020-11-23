<?php
return [
    /*
     |--------------------------------------------------------------------------
     | Top menu var name
     | Will be taken from deepest active menu item.
     |--------------------------------------------------------------------------
     */
    'top_var_name' => 'children_top',
    /*
     |--------------------------------------------------------------------------
     | Nav menus
     |--------------------------------------------------------------------------
     */
    'navs' => [
        'sidebar' => [
            [
                'name' => 'Home',
                'link' => '/home',
                'icon' => 'speed',
                'children_top' => [
                    [
                        'name' => 'Home',
                        'link' => '/home',
                        //                        'key' => 'auth.failed',
                    ],
                    [
                        'name' => 'Home2',
                        'link' => '/home2',
                    ]
                ]
            ],
            [
                'name' => 'Home2',
                'link' => '/home2',
                'icon' => 'speed',
            ],
            [
                'name' => 'Home3',
                'link' => '/home3',
                'icon' => 'speed',
            ],   [
                'name' => 'Permissions',
                'key' => 'navigation::pages.permissions',
                'link' => '/admin/permissions',
                'permissions' => 'manage_permissions',
                'icon' => 'speed',
                'children' => [
                    [
                        'name' => 'Permissions',
                        'link' => '/admin/permissions',
                        'key' => 'navigation::pages.permissions',
                    ],
                    [
                        'name' => 'Roles',
                        'link' => '/admin/roles',
                        'key' => 'navigation::pages.roles',
                    ]
                ],
                'children_top' => [
                    [
                        'name' => 'Permissions',
                        'link' => '/admin/permissions',
                        'key' => 'navigation::pages.permissions',
                    ],
                    [
                        'name' => 'Roles',
                        'link' => '/admin/roles',
                        'key' => 'navigation::pages.roles',
                    ]
                ]
            ],
        ],
        'adminSidebar' => [],
        'guestSidebar' => [],
        'userNavigation' => [
            [
                'name' => 'Logout',
                'link' => '/logout',
                'key' => 'navigation::pages.logout',
                'class'=>'awema-spa-ignore',
            ]
        ],
//        'top_var_name' => [
//            [
//                'name' => 'Wyloguj się',
//                'link' => '/logout',
//            ]
//        ]
    ],

];
