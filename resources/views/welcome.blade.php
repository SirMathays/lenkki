<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
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

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > * {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .content {
                position: relative;
                width: 500px;
                text-align: center;
            }

            @media (max-width: 500px) {
                .content {
                    width: 100%;
                }
            }

            .changelog {
                position: absolute;
                width: 100%;
                margin-top: 35px;
                top: 100%;
                left: 0;
                text-align: left;
                border-top: 1px #636b6f solid;
            }

            .changelog-content {
                padding: 0 10px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <svg width="165px" viewBox="0 0 82 55" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M72.319099,12.262806 C72.319099,12.262806 69.974149,7.588172 68.765679,6.103634 C67.557229,4.6191 65.354869,1.332826 64.956009,2.116282 C64.557159,2.899738 62.454349,7.655929 60.341489,9.616324 C58.228629,11.576716 55.992059,14.301496 52.855019,14.311094 C49.717989,14.320694 47.924519,13.046763 47.924519,13.046763 C47.924519,13.046763 43.349979,9.414754 42.308101,8.750059 C41.266223,8.085363 39.410308,10.811736 37.97062,12.790647 C36.691124,14.69167 32.648712,20.945679 32.11986,21.775939 C31.591007,22.606199 28.084038,28.347789 26.445751,29.897379 C24.807468,31.446969 18.62731,36.391319 15.862577,37.546609 C13.097842,38.701909 9.179297,40.189949 8.207148,40.565739 C7.311821,41.000229 2.753912,43.065679 2.272362,45.158629 C1.790807,47.251579 1.556338,50.171389 5.283013,51.883819 C9.009686,53.596239 21.929483,52.366669 23.464526,52.153389 C24.999572,51.940089 26.63725,51.746409 28.900111,50.988309 C31.162972,50.230219 68.077799,36.704869 68.077799,36.704869 C68.077799,36.704869 73.780489,34.731829 75.322209,33.736899 C76.863929,32.741949 79.176089,31.105029 79.236189,28.968529 C79.296289,26.832039 78.930509,25.919249 78.616569,25.232439 C78.302619,24.545629 76.678639,21.531049 76.483629,21.601249 C76.288629,21.671449 71.147289,22.802529 67.792539,22.770529 C66.241279,22.923879 63.033499,21.921119 60.822659,22.900079 C59.051049,23.980039 58.552009,26.570109 58.448149,26.847869 C58.344279,27.125629 57.735119,29.225439 57.059849,29.482679 C56.384589,29.739909 56.141719,29.940459 54.615939,29.895919 C53.090159,29.851319 51.288439,29.279829 48.717589,30.180639 C45.603359,31.714149 44.396139,33.912349 42.709823,35.959659 C40.095093,38.675619 36.407557,41.493689 32.94847,42.933099 C27.610915,44.991819 19.489646,46.887389 13.514651,47.904959" id="path23" stroke="#636b6f" stroke-width="3.5"></path>
                        </g>
                    </svg>
                </div>

                <div class="links">
                    <p>Lenkki v{{ env('APP_VERSION') }}</p>
                </div>

                <div class="changelog">
                    <div class="changelog-content">
                        <h1>Changelog</h1>
                        @parsedown(file_get_contents(base_path('/changelog.md')))
                    </div>
                </div>
            </div>
            
        </div>
    </body>
</html>
