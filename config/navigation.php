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
                'name' => 'Home1',
                'link' => '/home',
                'icon' => 'speed'
            ],
            [
                'name' => 'Home2',
                'link' => '/home2',
                'icon' => 'intelligence',

                'children' => [
                    [
                        'name' => 'Home3',
                        'link' => '/home3',
                    ]
                ]
            ],
            [
                'name' => 'Allegro',
                'link' => '/',
                'icon' => 'briefcase',

                'children' => [
                    [
                        'name' => 'Powiązania Allegro',
                        'link' => '/easy-product-allegro/relations',
                    ]
                ]
            ]
        ],
        'top' => [
            [
                'name' => 'a',
                'link' => '/',
            ]
        ]

    ]
];
