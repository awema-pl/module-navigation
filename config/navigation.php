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
                'icon' => 'speed'
            ],
            [
                'name' => 'Home3',
                'link' => '/home3',
                'icon' => 'speed'
            ],
            [
                'name' => 'With Home2',
                'icon' => 'intelligence',

                'children' => [
                    [
                        'name' => 'Home2',
                        'link' => '/home2',
                    ],
                    [
                        'name' => 'Home3',
                        'link' => '/home3',
                    ]
                ]
            ],
            [
                'name' => 'Home4',
                'link' => '/home4',
                'icon' => 'speed',
            ],
            [
                'name' => 'Home44',
                'link' => '/home4/home',
                'icon' => 'speed',
            ],
            [
                'name' => 'Allegro',
                'link' => '/allegro',
                'icon' => 'briefcase',

//                'children' => [
//                    [
//                        'name' => 'Powiązania Allegro',
//                        'link' => '/easy-product-allegro/relations',
//                    ]
//                ]
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
