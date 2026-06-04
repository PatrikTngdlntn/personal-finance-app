<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Dashboard' }} — Personal Finance</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

    <div x-data="{ open: false }" class="h-screen flex overflow-hidden">

        {{-- OVERLAY MOBILE --}}
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/40 z-40 md:hidden" @click="open = false">
        </div>

        {{-- SIDEBAR --}}
        <aside
            class="fixed md:relative inset-y-0 left-0 z-50
            w-64 bg-white border-r border-gray-200
            flex flex-col
            transform transition-transform duration-300
            md:translate-x-0
            shadow-xl md:shadow-none"
            :class="open ? 'translate-x-0' : '-translate-x-full'">

            {{-- TOP --}}
            <div class="flex-1 overflow-y-auto">

                {{-- LOGO --}}
                <div class="px-6 py-6 flex justify-center border-b border-gray-100">

                    <img src="{{ asset('assets/logo-finance.png') }}" alt="Finance Logo" class="w-36 object-contain">

                </div>

                {{-- MENU --}}
                <nav class="p-4 space-y-2">

                    {{-- DASHBOARD --}}
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->routeIs('user.dashboard') || request()->routeIs('admin.dashboard')
                            ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10l9-7 9 7v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V12H9v8a2 2 0 01-2 2H3V10z" />
                        </svg>

                        Dashboard
                    </a>

                    {{-- WALLET --}}
                    @if (auth()->user()->role === 'user')
                        <a href="{{ route('user.wallet.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                            {{ request()->routeIs('user.wallet.*')
                                ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm'
                                : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12V7a2 2 0 00-2-2H5a2 2 0 00-2 2v5m18 0v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5m18 0H3" />
                            </svg>

                            Wallets
                        </a>
                    @endif

                    {{-- TRANSACTIONS --}}
                    <a href="{{ route('user.transaction.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->routeIs('user.transaction.*')
                            ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                        </svg>

                        Transactions
                    </a>

                    {{-- CATEGORY --}}
                    <a href="{{ route('user.category.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->routeIs('user.category.*')
                            ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h5l5 5-5 5H7V7z" />
                        </svg>

                        Categories
                    </a>

                    {{-- BUDGET --}}
                    <a href="{{ route('user.budget.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->routeIs('user.budget.*')
                            ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-6m4 6V7m4 10v-3M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>

                        Budgets
                    </a>
                    {{-- SAVING-TRANSACTION --}}
                    <a href="{{ route('user.saving-transaction.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->routeIs('user.saving-transaction.*')
                            ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-6m4 6V7m4 10v-3M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>

                        Saving Transactions
                    </a>
                    {{-- </nav>
            </div> --}}

                    {{-- SAVING --}}
                    <a href="{{ route('user.saving.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->routeIs('user.saving.*')
                            ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-6m4 6V7m4 10v-3M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>

                        Target Tabungan
                    </a>

                    {{-- SUBSCRIPTIONS --}}
                    <a href="{{ route('user.subscription.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                        {{ request()->routeIs('user.subscription.*')
                            ? 'bg-indigo-50 text-indigo-600 font-semibold shadow-sm'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a5 5 0 00-10 0v2M5 9h14l-1 10a2 2 0 01-2 2H8a2 2 0 01-2-2L5 9z" />
                        </svg>

                        Subscriptions
                    </a>
                </nav>
            </div>
           
            {{-- LOGOUT --}}
            <div class="p-4 border-t border-gray-100 bg-white">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2
                        bg-red-50 hover:bg-red-100
                        text-red-500 hover:text-red-600
                        py-3 rounded-xl
                        transition-all duration-200 text-sm font-medium">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>

                        Logout
                    </button>

                </form>
            </div>

        </aside>

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- TOPBAR --}}
            <header
                class="h-16 bg-white border-b border-gray-200
                flex items-center justify-between
                px-6 sticky top-0 z-30">

                {{-- MOBILE BUTTON --}}
                <button @click="open = !open" class="md:hidden text-gray-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- TITLE --}}
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ $title ?? 'Dashboard' }}
                </h2>

                {{-- USER --}}
                <div class="flex items-center gap-3">

                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-medium text-gray-700">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-xs text-gray-400">
                            {{ ucfirst(auth()->user()->role) }}
                        </p>
                    </div>

                    <img src="{{ auth()->user()->avatar ??
                        'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=4f46e5&color=fff' }}"
                        alt="Avatar" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow">
                </div>

            </header>

            {{-- CONTENT --}}
            <main class="flex-1 overflow-y-auto p-6">

                <div class="max-w-7xl mx-auto">

                    {{ $slot }}

                </div>

            </main>

        </div>

    </div>

    {{-- ALPINE --}}
    <script src="//unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>

</html>
