<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <?php
    
        
    ?>
    <script>
        window.Laravel = {
            userId: @json(auth()->id()), // Laravel'den oturum açmış kullanıcının ID'sini Vue'ya aktar
            statusMessage: "{{ __('şuan çevrimiçisiniz') }}",
            blocktitle: "{{ __('ME-Chat') }}",
            logoutLink: "{{ route('logout') }}",
            sendMessageUserID: @json(isset($userId) ? $userId : null),
            userName:@json(isset(Auth::user()->name) ? Auth::user()->name : null),
        };
    </script>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
    <link href="/assets/general.css" rel="stylesheet">
</head>
<body>
    <div id="app-top">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
