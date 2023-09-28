<?php


return
[
    [
        'icon'=>'nav-icon fas fa-tachometer-alt',
        'route'=>'dashboard',
        'title'=>'Dashboard',
        'active'=>'dashboard',
    ],

    [
        'icon'=>'fas fa-tags nav-icon',
        'route'=>'categories.index',
        'title'=>'Categories',
        'badge'=>'New',
        'active'=>'categories.*',
      //  'ability' => 'categories.view',

    ],

    [
    'icon'=>'fas fa-box nav-icon',
    'route'=>'products.index',
    'title'=>'Products',
    'badge'=>'New',
    'active'=>'products.*',
  //  'ability' => 'products.view',

     ],

    [
        'icon'=>'fas fa-receipt nav-icon',
        'route'=>'brands.index',
        'title'=>'Brands',
        'active'=>'brands.*',
      //  'ability' => 'brands.view',

    ],

    [
        "icon"=> "fas fa-user nav-icon",
        'route'=>'roles.index',
        'title'=>'Roles',
        'active'=>'Roles.*',
      //  'ability' => 'roles.view',

    ],

    [
        'icon' => 'fas fa-shopping-cart nav-icon',
        'route'=>'orders.index',
        'title'=>'Orders',
        'active'=>'Orders.*',
      //  'ability' => 'orders.view',

    ],



];