<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <div x-data="{ open: false }" class="flex min-h-screen">

        <!-- OVERLAY (MOBILE) -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/30 z-40 md:hidden" @click="open = false">
        </div>

        <aside
            class="fixed md:static z-50 w-64 bg-white border-r min-h-screen flex flex-col p-5
            transform transition-transform duration-300
            -translate-x-full md:translate-x-0 md:shadow-none shadow-lg"
            :class="open ? 'translate-x-0' : ''">

            <!-- TOP MENU -->
            <div>
                <h1 class="text-xl font-bold text-indigo-600 mb-8">
                    FinanceApp
                </h1>

                <nav class="space-y-2 text-sm">

                    <!-- DASHBOARD -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg transition
       {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">

                        <!-- ICON -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10l9-7 9 7v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V12H9v8a2 2 0 01-2 2H3V10z" />
                        </svg>

                        Dashboard
                    </a>

                    <!-- TRANSACTIONS -->
                    <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a4 4 0 10-8 0v2M5 9h14l-1 10H6L5 9z" />
                        </svg>

                        Transactions
                    </a>

                    <!-- WALLETS -->
                    <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12V7a2 2 0 00-2-2H5a2 2 0 00-2 2v5m18 0v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5m18 0H3" />
                        </svg>

                        Wallets
                    </a>

                    <!-- CATEGORIES -->
                    <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M3 11l9-9 9 9M5 10v10h14V10" />
                        </svg>

                        Categories
                    </a>

                </nav>
            </div>

            <!-- LOGOUT (BOTTOM LEFT) -->
            <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                @csrf
                <button class="text-red-500 text-sm hover:underline">
                    Logout
                </button>
            </form>

        </aside>

        <!-- MAIN -->
        <div class="flex-1 flex flex-col">

            <!-- TOPBAR -->
            <header class="bg-white border-b px-6 py-4 flex justify-between items-center">

                <!-- HAMBURGER -->
                <button @click="open = !open" class="md:hidden text-gray-600">
                    ☰
                </button>

                <h2 class="font-semibold text-lg">
                    Dashboard
                </h2>

                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600">
                        {{ auth()->user()->name }}
                    </span>

                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . auth()->user()->name }}"
                        class="w-8 h-8 rounded-full">
                </div>

            </header>

            <!-- CONTENT -->
            <main class="p-6">
                {{ $slot }}
            </main>

        </div>

    </div>

    <!-- ALPINE JS -->
    <script src="//unpkg.com/alpinejs" defer></script>

</body>

</html>
