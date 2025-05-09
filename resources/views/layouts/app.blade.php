<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/theme.css', 'resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="icon-circle-gauge" viewBox="0 0 24 24">
            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0-18 0" />
            <!-- Cambia este path por el del ícono que necesites -->
        </symbol>
        <symbol id="icon-panel-bottom-close" viewBox="0 0 24 24">
            <path d="M3 3h18v6H3z M3 15h18v6H3z" />
        </symbol>
        <symbol id="icon-disc-3" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/>
            <circle cx="12" cy="12" r="4"/>
        </symbol>
        <symbol id="icon-square-activity" viewBox="0 0 24 24">
            <rect x="3" y="3" width="18" height="18" rx="2"/>
            <path d="M7 12l3 3 4-6 3 4"/>
        </symbol>
        <symbol id="icon-album" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/>
            <circle cx="12" cy="12" r="2"/>
        </symbol>
        <!-- Agrega más <symbol> según los íconos que uses -->
    </svg>
    <div
        class="page-loader bg-background fixed inset-0 z-[100] flex items-center justify-center transition-opacity opacity-0 hidden">
        <div class="loader-spinner !w-14"></div>
    </div>
    <div
        class="enigma min-h-screen bg-[color-mix(in_oklch,_var(--color-background),_var(--color-foreground)_3%)] dark:bg-background before:bg-noise dark:before:bg-foreground/[.01] before:fixed before:inset-0 before:opacity-20 after:bg-accent after:bg-contain after:fixed after:inset-0 after:blur-xl after:opacity-[.25]">
        {{-- Sidebar --}}
        @include('partials.sidebar')
        <div
            class="content h-screen transition-[margin,width] duration-200 pt-32 pb-8 px-7 z-10 relative group before:absolute before:bottom-4 before:top-27 before:-ml-px before:right-4 before:opacity-[.07] before:left-4 xl:before:left-0 before:bg-foreground before:rounded-4xl after:absolute after:bottom-4 after:top-27 after:-ml-px after:right-4 after:left-4 xl:after:left-0 after:bg-[color-mix(in_oklch,_var(--color-background),_var(--color-foreground)_2%)] after:rounded-4xl after:border after:border-foreground/[.15] dark:after:opacity-[.59] xl:ml-[320px] [&amp;.content--compact]:xl:ml-[--size-sidebar] content--compact">
            <div
                class="relative h-full [--color-nav-foreground:var(--color-background)] dark:[--color-nav-foreground:var(--color-foreground)]">
                <div class="h-full overflow-x-hidden">
                    <div
                        class="content__scroll-area relative z-20 -mr-7 h-full overflow-y-auto pl-4 pr-11 transition-[margin] duration-200 xl:pl-0">
                        @include('layouts.navigation')
                        <!-- Page Content -->
                        <div class="-mt-5">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/vendor/dom.js') }}"></script>
    <script src="{{ asset('js/vendor/simplebar.js') }}"></script>
    <script src="{{ asset('js/vendor/enigma.js') }}"></script>

</body>

</html>
