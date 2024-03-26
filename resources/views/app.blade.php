<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="shopify-api-key" content="{{ config('shopify.shopify_api_key') }}" />
       
        <title>app_name</title>
       
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="https://cdn.shopify.com/shopifycloud/app-bridge.js"></script>

        <!-- Scripts -->
     
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased" id="app">
    
     
        {{-- @if(config('shopify.appbridge_enabled'))
            <script src="https://unpkg.com/@shopify/app-bridge{{'@'.config('shopify.appbridge_version') }}"></script>
            <script src="https://unpkg.com/@shopify/app-bridge-utils{{'@'.config('shopify.appbridge_version')}}"></script>
            <script
             
            >
                var AppBridge = window['app-bridge'];
                var actions = AppBridge.actions;
                var utils = window['app-bridge-utils'];
                var createApp = AppBridge.default;
                var app = createApp({
                    apiKey: "{{ config('shopify.shopify_api_key') }}",
                    shopOrigin: "{{ $shopDomain ?? auth()->user()->store_name }}",
                    host: "{{ \Request::get('host') }}",
                    forceRedirect: true,
                });
            </script>

        @endif --}}

    </body>
</html>