<?php

return [

    'sidebar_links' => [
        [
            'name' => 'My account',
            'route' => 'dashboard',
        ],
        [
            'name' => 'Track Order',
            'route' => 'orders'
        ],
        [
            'name' => 'Order History',
            'route' => 'orders.history'
        ],
        [
            'name' => 'Wishlist',
            'route' => 'wishlist',
        ],
        [
            'name' => 'Billing information',
            'route' => 'billing-information'
        ],
        [
            'name' => 'Account management',
            'route' => 'auth.profile'
        ]
    ],

    'invoice_status' => [
        'pending' => [
            'class' => 'bg-yellow-500',
            'text' => 'Pending'
        ],
        'paid' => [
            'class' => 'bg-green-500',
            'text' => 'Paid'
        ],
        'in_transit' => [
            'class' => 'bg-blue-500',
            'text' => 'In Transit'
        ],
        'delivered' => [
            'class' => 'bg-green-500',
            'text' => 'Delivered'
        ],

        'cancelled' => [
            'class' => 'bg-red-500',
            'text' => 'Cancelled'
        ],
    ]

];


?>
