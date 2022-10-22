<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" :class="{ 'dark': darkMode }" x-data="{ darkMode: $persist(false) }">

<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ config('app.meta.description') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="turbo-visit-control" content="reload">
    <meta name="turbo-cache-control" content="no-cache">

    <title>@stack('pagetitle')</title>

    <!-- Web Application Manifest -->
    <link rel="manifest" href="manifest.webmanifest">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <script>
        if (localStorage._x_darkMode === 'true' || (!('_x_darkMode' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add("dark")
        } else {
            document.documentElement.classList.remove("dark")
        }
    </script>

    <!-- styles -->
    @livewireStyles
    @wireUiScripts
    @powerGridStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-gray-900 font-sans selection:bg-purple-100 antialiased @stack('body:classes')">
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>
    @livewireScripts
    @powerGridScripts
</body>

</html>
