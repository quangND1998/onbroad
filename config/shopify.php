<?php

return [
    'shopify_api_key' => env('SHOPIFY_API_KEY', 'ae6f9e6a0e594f6ad31f53873450dc18'),
    'shopify_api_secret' => env('SHOPIFY_API_SECRET', 'cba83bb499368eceecd6e2d2722bfc9e'),
    'shopify_api_version' => '2022-07',
    'app_embedded' => env('APP_EMBEDDED', false),
    'appbridge_enabled' => (bool) env('SHOPIFY_APPBRIDGE_ENABLED', true),
    'appbridge_version' => env('SHOPIFY_APPBRIDGE_VERSION', 'latest'),
    'api_scopes' => [
        'write_orders',
        'write_fulfillments',
        'write_customers',
        'write_products',
        // 'read_third_party_fulfillment_orders',
        // 'write_third_party_fulfillment_orders',
        // 'write_assigned_fulfillment_orders',
        // 'read_assigned_fulfillment_orders',
        // 'read_merchant_managed_fulfillment_orders',
        // 'write_merchant_managed_fulfillment_orders'
    ],
];
