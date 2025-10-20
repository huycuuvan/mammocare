<?php

//Rules for frontend URL
$rules = [
    ['pattern' => '', 'route' => 'site/index'],
    ['pattern' => 'lien-he', 'route' => 'site/contact', 'suffix' => '.html'],
    ['pattern' => 'gallery/<page:\d+>', 'route' => 'site/gallery','defaults' => ['page' => 1]],
    ['pattern' => '<name>-album<id:\d+>', 'route' => 'site/album',  'suffix' => '.html'],
    ['pattern' => 'video/<page:\d+>', 'route' => 'site/video', 'defaults' => ['page' => 1]],
//    ['pattern' => 'thanks', 'route' => 'site/thanks', 'suffix' => '.html'],

    // ['pattern' => 'san-pham', 'route' => 'site/all-product', 'suffix' => '.html'],
    ['pattern' => '<name>-p<id:\d+>', 'route' => 'site/product', 'suffix' => '.html'],
    ['pattern' => '<name>-a<id:\d+>', 'route' => 'site/page', 'suffix' => '.html'],
    ['pattern' => '<name>-l<id:\d+>/<page:\d+>', 'route' => 'site/list-news', 'defaults' => ['page' => 1]],
    ['pattern' => '<name>-n<id:\d+>', 'route' => 'site/news', 'suffix' => '.html'],
    ['pattern' => '<name>-c<id:\d+>/<page:\d+>', 'route' => 'site/list-product', 'defaults' => ['page' => 1]],
    ['pattern' => 'hot-rooms/<page:\d+>', 'route' => 'site/list-hot-product', 'defaults' => ['page' => 1]],
    ['pattern' => '<name>-lp<id:\d+>/<page:\d+>', 'route' => 'site/list-place', 'defaults' => ['page' => 1]],
    ['pattern' => '<name>-o<id:\d+>', 'route' => 'site/agency', 'suffix' => '.html'],
    ['pattern' => 'all-products/<page:\d+>', 'route' => 'site/list-product', 'defaults' => ['page' => 1]],
    ['pattern' => 'search', 'route' => 'site/search-news', 'suffix' => '.html'],
    ['pattern' => 'search', 'route' => 'site/search', 'suffix' => '.html'],
    ['pattern' => 'agency', 'route' => 'site/list-agency', 'defaults' => ['page' => 1]],
    ['pattern' => 'bac-si', 'route' => 'site/team', 'defaults' => ['page' => 1]],
    ['pattern' => '<name>-bs<id:\d+>', 'route' => 'site/detail', 'suffix' => '.html'],
    ['pattern' => '<name>-d<id:\d+>/<page:\d+>', 'route' => 'site/list-doctor', 'defaults' => ['page' => 1]],

    ['pattern' => 'shopping-cart', 'route' => 'site/shopping-cart', 'suffix' => '.html'],
    ['pattern' => 'add-cart', 'route' => 'site/addtocart', 'suffix' => '.html'],
    ['pattern' => 'shopping-checkout', 'route' => 'site/shopping-order', 'suffix' => '.html'],
    ['pattern' => 'cart-<type>-ca<id:\d+>', 'route' => 'site/cart', 'suffix' => '.html'],
    ['pattern' => 'check-room', 'route' => 'site/check-room', 'suffix' => '.html'],
    ['pattern' => 'get-list', 'route' => 'site/get-list', 'suffix' => '.html'],
    ['pattern' => 'thanks', 'route' => 'site/shopping-thanks', 'suffix' => '.html'],
    ['pattern' => 'booking', 'route' => 'site/booking', 'suffix' => '.html'],
    ['pattern' => 'faq', 'route' => 'site/faq', 'suffix' => '.html'],
    ['pattern' => 'book-doctor', 'route' => 'site/book-doctor'],

    ['pattern' => 'member-signup', 'route' => 'site/signup', 'suffix' => '.html'],
    ['pattern' => 'member-login', 'route' => 'site/login', 'suffix' => '.html'],
    ['pattern' => 'member-active', 'route' => 'site/active-account', 'suffix' => '.html'],
    ['pattern' => 'request-password-reset', 'route' => 'site/request-password-reset', 'suffix' => '.html'],
    ['pattern' => 'reset-password', 'route' => 'site/reset-password', 'suffix' => '.html'],
    ['pattern' => 'request-verification-reset', 'route' => 'site/request-verification-email', 'suffix' => '.html'],
    ['pattern' => 'account-information', 'route' => 'site/member-information', 'suffix' => '.html'],
    ['pattern' => 'account-change-password', 'route' => 'site/member-change-password', 'suffix' => '.html'],


    ['pattern' => 'crews', 'route' => 'site/list-profile', 'defaults' => ['page' => 1]],
    ['pattern' => '<name>-cr<id:\d+>', 'route' => 'site/view-profile', 'suffix' => '.html'],
    ['pattern' => '<name>-lc<id:\d+>/<page:\d+>', 'route' => 'site/list-profiles', 'defaults' => ['page' => 1]],

];

return $rules;
