<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="turbo-visit-control" content="reload">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Web Application Manifest -->
    <link rel="manifest" href="manifest.webmanifest">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    @wireUiScripts

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    @powerGridStyles

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
    {{-- <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        @powerGridScripts
    </body> --}}

<body class="font-sans antialiased">
    <x-notifications />
    <x-flash::message />
    <div x-data="setup()" x-init="$refs.loading.classList.add('hidden');" @resize.window="watchScreen()">
        <div class="flex h-screen antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
            <!-- Loading screen -->
            <div x-ref="loading"
                class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-indigo-800">
                Loading.....
            </div>

            <!-- Sidebar -->
            <div class="flex flex-shrink-0 transition-all">
                <div x-show="isSidebarOpen" @click="isSidebarOpen = false"
                    class="fixed inset-0 z-10 bg-black bg-opacity-50 lg:hidden"></div>
                <div x-show="isSidebarOpen" class="fixed inset-y-0 z-10 w-16 bg-white"></div>

                @livewire('core::navigation')

                <section x-show="currentSidebarTab == 'messagesTab'" class="px-4 py-6">
                    <h2 class="text-xl">Messages</h2>
                </section>

                <section x-show="currentSidebarTab == 'notificationsTab'" class="px-4 py-6">
                    <h2 class="text-xl">Notifications</h2>
                </section>
            </div>
        </div>
        <div class="flex flex-col flex-1">
            <header class="relative flex items-center justify-between flex-shrink-0 p-4">
                @if (isset($header))
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                @endif
                <form action="#" class="flex-1">
                    <!--  -->
                </form>
                <div class="items-center hidden ml-4 sm:flex">
                    <button @click="isSettingsPanelOpen = true"
                        class="p-2 mr-4 text-gray-400 bg-white rounded-lg shadow-md hover:text-gray-600 focus:outline-none focus:ring focus:ring-white focus:ring-offset-gray-100 focus:ring-offset-4">
                        <span class="sr-only">Settings</span>
                        <svg aria-hidden="true" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>

                    <!-- Github link -->
                    <a href="https://github.com/rochi88/lara_lab" target="_blank"
                        class="p-2 text-white bg-black rounded-lg shadow-md hover:text-gray-200 focus:outline-none focus:ring focus:ring-black focus:ring-offset-gray-100 focus:ring-offset-2">
                        <span class="sr-only">github link</span>
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12.026,2c-5.509,0-9.974,4.465-9.974,9.974c0,4.406,2.857,8.145,6.821,9.465 c0.499,0.09,0.679-0.217,0.679-0.481c0-0.237-0.008-0.865-0.011-1.696c-2.775,0.602-3.361-1.338-3.361-1.338 c-0.452-1.152-1.107-1.459-1.107-1.459c-0.905-0.619,0.069-0.605,0.069-0.605c1.002,0.07,1.527,1.028,1.527,1.028 c0.89,1.524,2.336,1.084,2.902,0.829c0.091-0.645,0.351-1.085,0.635-1.334c-2.214-0.251-4.542-1.107-4.542-4.93 c0-1.087,0.389-1.979,1.024-2.675c-0.101-0.253-0.446-1.268,0.099-2.64c0,0,0.837-0.269,2.742,1.021 c0.798-0.221,1.649-0.332,2.496-0.336c0.849,0.004,1.701,0.115,2.496,0.336c1.906-1.291,2.742-1.021,2.742-1.021 c0.545,1.372,0.203,2.387,0.099,2.64c0.64,0.696,1.024,1.587,1.024,2.675c0,3.833-2.33,4.675-4.552,4.922 c0.355,0.308,0.675,0.916,0.675,1.846c0,1.334-0.012,2.41-0.012,2.737c0,0.267,0.178,0.577,0.687,0.479 C19.146,20.115,22,16.379,22,11.974C22,6.465,17.535,2,12.026,2z">
                            </path>
                        </svg>
                    </a>
                </div>

                <!-- Mobile sub header button -->
                <button @click="isSubHeaderOpen = !isSubHeaderOpen"
                    class="p-2 text-gray-400 bg-white rounded-lg shadow-md sm:hidden hover:text-gray-600 focus:outline-none focus:ring focus:ring-white focus:ring-offset-gray-100 focus:ring-offset-4">
                    <span class="sr-only">More</span>

                    <svg aria-hidden="true" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </button>

                <!-- Mobile sub header -->
                <div x-transition:enter="transform transition-transform"
                    x-transition:enter-start="translate-y-full opacity-0"
                    x-transition:enter-end="translate-y-0 opacity-100"
                    x-transition:leave="transform transition-transform"
                    x-transition:leave-start="translate-y-0 opacity-100"
                    x-transition:leave-end="translate-y-full opacity-0" x-show="isSubHeaderOpen"
                    @click.away="isSubHeaderOpen = false"
                    class="absolute flex items-center justify-between p-2 bg-white rounded-md shadow-lg sm:hidden top-16 left-5 right-5">
                    <!-- Seetings button -->
                    <button @click="isSettingsPanelOpen = true; isSubHeaderOpen = false"
                        class="p-2 text-gray-400 bg-white rounded-lg shadow-md hover:text-gray-600 focus:outline-none focus:ring focus:ring-white focus:ring-offset-gray-100 focus:ring-offset-4">
                        <span class="sr-only">Settings</span>
                        <svg aria-hidden="true" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                    <!-- Messages button -->
                    <button @click="isSidebarOpen = true; currentSidebarTab = 'messagesTab'; isSubHeaderOpen = false"
                        class="p-2 text-gray-400 bg-white rounded-lg shadow-md hover:text-gray-600 focus:outline-none focus:ring focus:ring-white focus:ring-offset-gray-100 focus:ring-offset-4">
                        <span class="sr-only">Toggle message panel</span>
                        <svg aria-hidden="true" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </button>
                    <!-- Notifications button -->
                    <button
                        @click="isSidebarOpen = true; currentSidebarTab = 'notificationsTab'; isSubHeaderOpen = false"
                        class="p-2 text-gray-400 bg-white rounded-lg shadow-md hover:text-gray-600 focus:outline-none focus:ring focus:ring-white focus:ring-offset-gray-100 focus:ring-offset-4">
                        <span class="sr-only">Toggle notifications panel</span>
                        <svg aria-hidden="true" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                    <!-- Github link -->
                    <a href="https://github.com/kamona-ui/dashboard-alpine" target="_blank"
                        class="p-2 text-white bg-black rounded-lg shadow-md hover:text-gray-200 focus:outline-none focus:ring focus:ring-black focus:ring-offset-gray-100 focus:ring-offset-2">
                        <span class="sr-only">github link</span>
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12.026,2c-5.509,0-9.974,4.465-9.974,9.974c0,4.406,2.857,8.145,6.821,9.465 c0.499,0.09,0.679-0.217,0.679-0.481c0-0.237-0.008-0.865-0.011-1.696c-2.775,0.602-3.361-1.338-3.361-1.338 c-0.452-1.152-1.107-1.459-1.107-1.459c-0.905-0.619,0.069-0.605,0.069-0.605c1.002,0.07,1.527,1.028,1.527,1.028 c0.89,1.524,2.336,1.084,2.902,0.829c0.091-0.645,0.351-1.085,0.635-1.334c-2.214-0.251-4.542-1.107-4.542-4.93 c0-1.087,0.389-1.979,1.024-2.675c-0.101-0.253-0.446-1.268,0.099-2.64c0,0,0.837-0.269,2.742,1.021 c0.798-0.221,1.649-0.332,2.496-0.336c0.849,0.004,1.701,0.115,2.496,0.336c1.906-1.291,2.742-1.021,2.742-1.021 c0.545,1.372,0.203,2.387,0.099,2.64c0.64,0.696,1.024,1.587,1.024,2.675c0,3.833-2.33,4.675-4.552,4.922 c0.355,0.308,0.675,0.916,0.675,1.846c0,1.334-0.012,2.41-0.012,2.737c0,0.267,0.178,0.577,0.687,0.479 C19.146,20.115,22,16.379,22,11.974C22,6.465,17.535,2,12.026,2z">
                            </path>
                        </svg>
                    </a>
                </div>
            </header>

            <div class="grid grid-cols-2 gap-4 place-content-center h-48">
                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>

    <!-- Panels -->

    <!-- Settings Panel -->
    <!-- Backdrop -->
    <div x-show="isSettingsPanelOpen" class="fixed inset-0 bg-black bg-opacity-50"
        @click="isSettingsPanelOpen = false" aria-hidden="true"></div>
    <!-- Panel -->
    <section x-transition:enter="transform transition-transform duration-300"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition-transform duration-300" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full" x-show="isSettingsPanelOpen"
        class="fixed inset-y-0 right-0 w-64 bg-white border-l border-indigo-100 rounded-l-3xl">
        <div class="px-4 py-8">
            <h2 class="text-lg font-semibold">Settings</h2>
        </div>
    </section>



    <!-- Author links -->
    <div class="fixed flex items-center space-x-4 bottom-20 right-5 sm:bottom-5">
        <a href="https://github.com/rochi88" target="_blank"
            class="transition-transform transform hover:scale-125">
            <span class="sr-only">Github</span>
            <svg aria-hidden="true" class="w-8 h-8 text-black" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12.026,2c-5.509,0-9.974,4.465-9.974,9.974c0,4.406,2.857,8.145,6.821,9.465 c0.499,0.09,0.679-0.217,0.679-0.481c0-0.237-0.008-0.865-0.011-1.696c-2.775,0.602-3.361-1.338-3.361-1.338 c-0.452-1.152-1.107-1.459-1.107-1.459c-0.905-0.619,0.069-0.605,0.069-0.605c1.002,0.07,1.527,1.028,1.527,1.028 c0.89,1.524,2.336,1.084,2.902,0.829c0.091-0.645,0.351-1.085,0.635-1.334c-2.214-0.251-4.542-1.107-4.542-4.93 c0-1.087,0.389-1.979,1.024-2.675c-0.101-0.253-0.446-1.268,0.099-2.64c0,0,0.837-0.269,2.742,1.021 c0.798-0.221,1.649-0.332,2.496-0.336c0.849,0.004,1.701,0.115,2.496,0.336c1.906-1.291,2.742-1.021,2.742-1.021 c0.545,1.372,0.203,2.387,0.099,2.64c0.64,0.696,1.024,1.587,1.024,2.675c0,3.833-2.33,4.675-4.552,4.922 c0.355,0.308,0.675,0.916,0.675,1.846c0,1.334-0.012,2.41-0.012,2.737c0,0.267,0.178,0.577,0.687,0.479 C19.146,20.115,22,16.379,22,11.974C22,6.465,17.535,2,12.026,2z">
                </path>
            </svg>
        </a>
    </div>
    </div>
    </div>

    @stack('modals')

    @livewireScripts
    @powerGridScripts
    <script>
        const setup = () => {
            return {
                isSidebarOpen: false,
                currentSidebarTab: null,
                isSettingsPanelOpen: false,
                isSubHeaderOpen: false,
                watchScreen() {
                    if (window.innerWidth <= 1024) {
                        this.isSidebarOpen = false
                    }
                },
            }
        }
    </script>
</body>

</html>
