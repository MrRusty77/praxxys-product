<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        
    </head>
    <body>

        <div id="app" class="w-full h-full" ></div>

        <script>
            window.auth_user = {{ !!Auth::check(); }};
            @if (Auth::check())
                window.user = {
                    username: '{{ Auth::user()->username }}',
                    first_name: '{{ Auth::user()->first_name }}',
                    last_name: '{{ Auth::user()->last_name }}',
                    tocken: null,
                };
            @endif
        </script>

        <script src="{{ mix('js/app.js') }}" defer></script>
        <script>
            const asset_url = '{{ asset("") }}';
        </script>
    </body>
</html>
