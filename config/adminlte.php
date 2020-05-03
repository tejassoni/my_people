<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => 'MyPeople',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-logo
    |
    */

    'logo' => '<b>Welcome to</b> MyPeople',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image-xl',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'AdminLTE',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Extra Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_header' => 'container-fluid',
    'classes_content' => 'container-fluid',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand-md',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#66-control-sidebar-right-sidebar
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => 'register',

    'password_reset_url' => 'password/reset',

    'password_email_url' => 'password/email',

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-laravel-mix
    |
    */

    'enabled_laravel_mix' => false,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-menu
    |
    */

    'menu' => [
        [
            'text' => 'search',
            'search' => true,
            'topnav' => true,
        ],
        [
            'text'    => 'User Management',
            'icon'    => 'fas fa-fw fa-user',
            'submenu' => [
                [
                    'text' => 'User List',
                    'url'  => '#',
                    'icon'    => 'fas fa-fw fa-th-list',
                ],
                [
                    'text' => 'User Add',
                    'url'  => '#',
                    'icon'    => 'fas fa-fw fa-plus-circle',
                ],
            ],
        ],
        [
            'text'    => 'Role Management',
            'icon'    => 'fas fa-fw fa-users',
            'submenu' => [
                [
                    'text' => 'Role List',
                    'url'  => '/admin/role_list',
                    'icon'    => 'fas fa-fw fa-th-list',
                ],
                [
                    'text' => 'Role Add',
                    'url'  => '/admin/role_add',
                    'icon'    => 'fas fa-fw fa-plus-circle',
                ],
            ],
        ],
        ['header' => 'Masters'],
        [
            'text'    => 'Ear Master',
            'icon'    => 'fas fa-fw fa-assistive-listening-systems',
            'submenu' => [
                [
                    'text' => 'Ear List',
                    'url'  => '/admin/ear_list',
                    'icon'    => 'fas fa-fw fa-th-list',
                ],
                [
                    'text' => 'Ear Add',
                    'url'  => '/admin/ear_add',
                    'icon'    => 'fas fa-fw fa-plus-circle',
                ],
            ],
        ],
        [
            'text'    => 'Eye Master',
            'icon'    => 'fas fa-fw fa-eye',
            'submenu' => [
                [
                    'text' => 'Eye List',
                    'url'  => '/admin/eye_list',
                    'icon'    => 'fas fa-fw fa-th-list',
                ],
                [
                    'text' => 'Eye Add',
                    'url'  => '/admin/eye_add',
                    'icon'    => 'fas fa-fw fa-plus-circle',
                ],
            ],
        ],
        [
            'text'    => 'Eye Brow Master',
            'icon'    => 'fas fa-fw fa-eye-slash',
            'submenu' => [
                [
                    'text' => 'Eye Brow List',
                    'url'  => '/admin/eyebrow_list',
                    'icon'    => 'fas fa-fw fa-th-list',
                ],
                [
                    'text' => 'Eye Brow Add',
                    'url'  => '/admin/eyebrow_add',
                    'icon'    => 'fas fa-fw fa-plus-circle',
                ],
            ],
        ],
        [
            'text'    => 'Hair Master',
            'icon'    => 'fas fa-fw fa-leaf',
            'submenu' => [
                [
                    'text' => 'Hair List',
                    'url'  => '/admin/hair_list',
                    'icon'    => 'fas fa-fw fa-th-list',
                ],
                [
                    'text' => 'Hair Add',
                    'url'  => '/admin/hair_add',
                    'icon'    => 'fas fa-fw fa-plus-circle',
                ],
            ],
        ],
        [
            'text'    => 'Jaw Master',
            'icon'    => 'fas fa-fw fa-smile',
            'submenu' => [
                [
                    'text' => 'Jaw List',
                    'url'  => '/admin/jaw_list',
                    'icon'    => 'fas fa-fw fa-th-list',
                ],
                [
                    'text' => 'Jaw Add',
                    'url'  => '/admin/jaw_add',
                    'icon'    => 'fas fa-fw fa-plus-circle',
                ],
            ],
        ],
        [
            'text'    => 'Lips Master',
            'icon'    => 'fas fa-fw fa-anchor',
            'submenu' => [
                [
                    'text' => 'Lips List',
                    'url'  => '/admin/lip_list',
                    'icon'    => 'fas fa-fw fa-th-list',
                ],
                [
                    'text' => 'Lips Add',
                    'url'  => '/admin/lip_add',
                    'icon'    => 'fas fa-fw fa-plus-circle',
                ],
            ],
        ],
        [
            'text'    => 'Nose Master',
            'icon'    => 'fas fa-fw fa-fire',
            'submenu' => [
                [
                    'text' => 'Nose List',
                    'url'  => '/admin/nose_list',
                    'icon'    => 'fas fa-fw fa-th-list',
                ],
                [
                    'text' => 'Nose Add',
                    'url'  => '/admin/nose_add',
                    'icon'    => 'fas fa-fw fa-plus-circle',
                ],
            ],
        ],
        [
            'text'    => 'Skin Master',
            'icon'    => 'fas fa-fw fa-fire',
            'submenu' => [
                [
                    'text' => 'Skin List',
                    'url'  => '/admin/skin_list',
                    'icon'    => 'fas fa-fw fa-th-list',
                ],
                [
                    'text' => 'Skin Add',
                    'url'  => '/admin/skin_add',
                    'icon'    => 'fas fa-fw fa-plus-circle',
                ],
            ],
        ],
        ['header' => 'labels'],
        [
            'text'       => 'important',
            'icon_color' => 'red',
        ],
        [
            'text'       => 'warning',
            'icon_color' => 'yellow',
        ],
        [
            'text'       => 'information',
            'icon_color' => 'aqua',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-plugins
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        [
            'name' => 'Select2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        [
            'name' => 'Pace',
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
];
