<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset_version(mix('css/app.css')) }}" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="https://lenkki.muutamatmeista.com/storage/logo/apple-touch-icon.png?v=wAO8vA4Jpl">
    <link rel="icon" type="image/png" sizes="32x32" href="https://lenkki.muutamatmeista.com/storage/logo/favicon-32x32.png?v=wAO8vA4Jpl">
    <link rel="icon" type="image/png" sizes="16x16" href="https://lenkki.muutamatmeista.com/storage/logo/favicon-16x16.png?v=wAO8vA4Jpl">
    <link rel="manifest" href="https://lenkki.muutamatmeista.com/storage/logo/manifest.json?v=wAO8vA4Jpp">
    <link rel="mask-icon" href="https://lenkki.muutamatmeista.com/storage/logo/safari-pinned-tab.svg?v=wAO8vA4Jpl" color="#4a90e2">
    <link rel="shortcut icon" href="https://lenkki.muutamatmeista.com/storage/logo/favicon.ico?v=wAO8vA4Jpk">
    <meta name="apple-mobile-web-app-title" content="Lenkki">
    <meta name="application-name" content="Lenkki">
    <meta name="msapplication-config" content="https://lenkki.muutamatmeista.com/storage/logo/browserconfig.xml?v=wAO8vA4Jpk">
    <meta name="theme-color" content="#4a90e2">
</head>

<body>
    <div id="app">
        @auth
            <activity-modal :id="activeActivity" v-if="activeActivity" @close="activeActivity = false"></activity-modal>
            <award-modal v-if="unseenAwards" @close="unseenAwards = false"></award-modal>
        @endauth

        @include('parts.nav')

        @yield('content')

        @if(empty($hideButton))
            <a href="{{ route('newActivity') }}" class="button shadow circle-button nav-button"><i class="fa fa-plus"></i></a>
        @endif

        <footer>Toteutus: Matti Suoraniemi</footer>
    </div>

    <!-- Scripts -->
    @auth
        <script src="{{ asset(asset_version('js/manifest.js')) }}"></script>
        <script src="{{ asset(asset_version('js/vendor.js')) }}"></script>
        <script src="{{ asset(asset_version('js/app.js')) }}"></script>
    @endauth
</body>
</html>
