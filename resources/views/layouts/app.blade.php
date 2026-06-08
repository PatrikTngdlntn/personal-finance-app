<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Dashboard' }} - Personal Finance</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 antialiased">
    <div x-data="{ open: false }" class="min-h-screen">
        <div x-show="open" x-transition.opacity class="fixed inset-0 z-40 bg-slate-950/40 lg:hidden"
            @click="open = false">
        </div>

        <aside
            class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white/95 shadow-xl shadow-slate-200/60 transition-transform duration-300 lg:translate-x-0 lg:shadow-none"
            :class="open ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex h-full flex-col">
                <div class="border-b border-slate-100 px-6 py-6">
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                        class="flex items-center gap-3">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500 to-blue-600 text-2xl font-black text-white shadow-lg shadow-indigo-200">
                            F
                        </div>
                        <div>
                            <p class="text-lg font-bold leading-tight text-slate-950">FinanceApp</p>
                            <p class="text-sm text-slate-500">Personal Finance</p>
                        </div>
                    </a>
                </div>

                <nav class="flex-1 space-y-2 overflow-y-auto px-4 py-5 text-sm font-medium">
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                        class="flex items-center gap-3 rounded-lg px-4 py-3 transition
                        {{ request()->routeIs('user.dashboard') || request()->routeIs('admin.dashboard')
                            ? 'bg-blue-50 text-blue-600 shadow-sm'
                            : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m3 11 9-8 9 8" />
                            <path d="M5 10v10h14V10" />
                            <path d="M9 20v-6h6v6" />
                        </svg>
                        Dashboard
                    </a>

                    @if (auth()->user()->role === 'user')
                        <a href="{{ route('user.wallet.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition
                            {{ request()->routeIs('user.wallet.*')
                                ? 'bg-blue-50 text-blue-600 shadow-sm'
                                : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M19 7V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-1" />
                                <path d="M16 12h6v5h-6a2.5 2.5 0 0 1 0-5Z" />
                            </svg>
                            Wallets
                        </a>

                        <a href="{{ route('user.transaction.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition
                            {{ request()->routeIs('user.transaction.*')
                                ? 'bg-blue-50 text-blue-600 shadow-sm'
                                : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M8 7h12" />
                                <path d="M8 12h12" />
                                <path d="M8 17h12" />
                                <path d="M4 7h.01" />
                                <path d="M4 12h.01" />
                                <path d="M4 17h.01" />
                            </svg>
                            Transactions
                        </a>

                        <a href="{{ route('user.category.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition
                            {{ request()->routeIs('user.category.*')
                                ? 'bg-blue-50 text-blue-600 shadow-sm'
                                : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M7 7h.01" />
                                <path d="M3 11 11 3h7l3 3v7l-8 8Z" />
                            </svg>
                            Categories
                        </a>

                        <a href="{{ route('user.budget.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition
                            {{ request()->routeIs('user.budget.*')
                                ? 'bg-blue-50 text-blue-600 shadow-sm'
                                : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M3 3v18h18" />
                                <path d="M8 17V9" />
                                <path d="M13 17V5" />
                                <path d="M18 17v-6" />
                            </svg>
                            Budget
                        </a>

                        <a href="{{ route('user.saving.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition
                            {{ request()->routeIs('user.saving.*') && !request()->routeIs('user.saving-transaction.*')
                                ? 'bg-blue-50 text-blue-600 shadow-sm'
                                : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="9" />
                                <circle cx="12" cy="12" r="5" />
                                <path d="m15 9 4-4" />
                                <path d="M15 5h4v4" />
                            </svg>
                            Savings
                        </a>

                        <a href="{{ route('user.subscription.index') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition
                            {{ request()->routeIs('user.subscription.*')
                                ? 'bg-blue-50 text-blue-600 shadow-sm'
                                : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M6 7h12l2 13H4Z" />
                                <path d="M9 7a3 3 0 0 1 6 0" />
                            </svg>
                            Subscription
                        </a>

                        <a href="{{ route('user.receipt.create') }}"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 transition
                            {{ request()->routeIs('user.receipt.*')
                                ? 'bg-blue-50 text-blue-600 shadow-sm'
                                : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M7 3h10v18l-2-1-2 1-2-1-2 1-2-1Z" />
                                <path d="M9 8h6" />
                                <path d="M9 12h6" />
                                <path d="M9 16h4" />
                            </svg>
                            OCR Receipt
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 rounded-lg px-4 py-3 text-slate-600 transition hover:bg-slate-100 hover:text-slate-950">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M4 19V5" />
                                <path d="M8 19v-8" />
                                <path d="M12 19V8" />
                                <path d="M16 19v-5" />
                                <path d="M20 19V4" />
                            </svg>
                            Reports
                        </a>
                    @endif

                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 rounded-lg px-4 py-3 transition
                        {{ request()->routeIs('profile.*')
                            ? 'bg-blue-50 text-blue-600 shadow-sm'
                            : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            <path
                                d="M19.4 15a1.7 1.7 0 0 0 .34 1.87l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06A1.7 1.7 0 0 0 15 19.4a1.7 1.7 0 0 0-1 .6 1.7 1.7 0 0 0-.4 1.1V21a2 2 0 1 1-4 0v-.09A1.7 1.7 0 0 0 8.6 19.4a1.7 1.7 0 0 0-1.87.34l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-.6-1 1.7 1.7 0 0 0-1.1-.4H3a2 2 0 1 1 0-4h.09A1.7 1.7 0 0 0 4.6 8.6a1.7 1.7 0 0 0-.34-1.87l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-.6 1.7 1.7 0 0 0 .4-1.1V3a2 2 0 1 1 4 0v.09A1.7 1.7 0 0 0 15.4 4.6a1.7 1.7 0 0 0 1.87-.34l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.7 1.7 0 0 0 19.4 9c.14.35.35.69.6 1 .3.28.7.4 1.1.4H21a2 2 0 1 1 0 4h-.09a1.7 1.7 0 0 0-1.51.6Z" />
                        </svg>
                        Settings
                    </a>
                </nav>

                <div class="border-t border-slate-100 p-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ auth()->user()->avatar
                            ? asset('storage/' . auth()->user()->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2563eb&color=fff' }}"
                            alt="Avatar" class="h-11 w-11 rounded-full object-cover">
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" title="Logout"
                                class="rounded-lg p-2 text-slate-500 transition hover:bg-red-50 hover:text-red-600">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <path d="m16 17 5-5-5-5" />
                                    <path d="M21 12H9" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <button type="button" @click="open = true"
            class="fixed left-4 top-4 z-30 rounded-lg border border-slate-200 bg-white p-3 text-slate-700 shadow-sm lg:hidden">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 6h16" />
                <path d="M4 12h16" />
                <path d="M4 18h16" />
            </svg>
        </button>

        <main class="min-h-screen lg:pl-72">
            <div class="mx-auto max-w-[1560px] px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>
