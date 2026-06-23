<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Personal Finance</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .dashboard-scale { transform: scale(0.65); transform-origin: top center; }
    </style>
</head>
<body class="min-h-screen bg-white text-slate-800 antialiased flex">

    <!-- LEFT PANEL: Form Area (White) 50% width -->
    <div class="w-full lg:w-1/2 flex flex-col justify-between p-8 md:p-12 h-screen overflow-y-auto border-r border-slate-100">
        <!-- Logo -->
        <div class="flex items-center gap-2 mb-8">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500 to-blue-600 font-black text-white shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m8 14 3-3 2 2 3-3"/></svg>
            </div>
            <span class="text-xl font-bold text-slate-900 tracking-tight">Personal Finance</span>
        </div>

        <!-- Form Container -->
        <div class="w-full max-w-sm mx-auto my-auto">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Create Account</h1>
                <p class="text-sm text-slate-500">Sign up to manage your personal finances.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100">
                    <ul class="text-red-700 text-sm font-medium space-y-1 pl-4 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- AVATAR -->
                <div x-data="{ imageUrl: null }" class="flex items-center gap-3">
                    <img :src="imageUrl || 'https://ui-avatars.com/api/?name=User&background=eff6ff&color=4f46e5'"
                        class="w-12 h-12 rounded-full border border-slate-200 object-cover shadow-sm bg-white">
                    <input type="file" name="avatar" accept="image/*"
                        @change="const file = $event.target.files[0]; if(file){ imageUrl = URL.createObjectURL(file); }"
                        class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 transition cursor-pointer">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full bg-white border border-slate-200 text-slate-900 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm" placeholder="John Doe">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-white border border-slate-200 text-slate-900 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm" placeholder="name@company.com">
                </div>

                <div x-data="{ showPassword: false }">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                            class="w-full bg-white border border-slate-200 text-slate-900 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm" placeholder="••••••••">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 font-bold hover:text-indigo-600">
                            <span x-show="!showPassword">SHOW</span><span x-show="showPassword">HIDE</span>
                        </button>
                    </div>
                </div>

                <div x-data="{ showConfirmPassword: false }">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Confirm Password</label>
                    <div class="relative">
                        <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required
                            class="w-full bg-white border border-slate-200 text-slate-900 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition shadow-sm" placeholder="••••••••">
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 font-bold hover:text-indigo-600">
                            <span x-show="!showConfirmPassword">SHOW</span><span x-show="showConfirmPassword">HIDE</span>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/20 transition shadow-md mt-4">
                    Register
                </button>
            </form>

            <p class="text-sm text-center mt-6 text-slate-500">
                Already Have An Account? 
                <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Log In.</a>
            </p>
            
            <div class="mt-4 text-center">
                <a href="/" class="text-xs font-medium text-slate-400 hover:text-slate-600 underline">Back to Landing Page</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-between items-center text-xs text-slate-400 mt-10">
            <p>Copyright © {{ date('Y') }} Personal Finance.</p>
            <a href="#" class="hover:text-slate-600">Privacy Policy</a>
        </div>
    </div>

    <!-- RIGHT PANEL: Dashboard Mockup (Blue) 50% width -->
    <div class="hidden lg:flex lg:w-1/2 bg-blue-600 m-4 rounded-3xl relative overflow-hidden flex-col items-center justify-start">
        <!-- Abstract Background Shapes inside blue panel -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-blue-500/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-indigo-500/30 rounded-full blur-3xl translate-y-1/3 -translate-x-1/4"></div>
        </div>

        <!-- Text Content -->
        <div class="relative z-10 w-full px-12 pt-16 pb-6 text-center">
            <h2 class="text-4xl xl:text-5xl font-bold text-white mb-4 leading-tight">
                Effortlessly manage your <br> personal finances.
            </h2>
            <p class="text-blue-100 text-base xl:text-lg font-medium">
                Sign up to access your financial dashboard and track your wealth.
            </p>
        </div>

        <!-- Dashboard Mockup -->
        <div class="relative z-10 w-full flex-1 overflow-hidden pointer-events-none mt-4 px-8 flex justify-center">
            <div class="dashboard-scale w-[1100px]">
                <!-- Frame Dashboard (Sama persis dengan dashboard utama) -->
                <div class="bg-slate-50 rounded-xl shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)] border border-slate-200 w-full overflow-hidden flex" style="height: 680px;">
                    
                    <!-- Sidebar -->
                    <div class="hidden md:flex w-56 bg-white border-r border-slate-200 flex-col h-full flex-shrink-0 z-10">
                        <div class="p-4 flex items-center gap-2 border-b border-slate-100">
                            <div class="w-8 h-8 bg-blue-600 rounded text-white flex items-center justify-center font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m8 14 3-3 2 2 3-3"/></svg>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-slate-800 leading-tight">Personal Finance</p>
                                <p class="text-[10px] text-slate-500">App</p>
                            </div>
                        </div>
                        <div class="p-3 flex-1 space-y-1 overflow-hidden">
                            <!-- Nav items -->
                            <div class="flex items-center gap-3 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-medium">
                                <span class="text-base">🏠</span> Dashboard
                            </div>
                            <div class="flex items-center gap-3 px-3 py-2 text-slate-600 rounded-lg text-xs">
                                <span class="text-base text-slate-400">💳</span> Wallets
                            </div>
                            <div class="flex items-center gap-3 px-3 py-2 text-slate-600 rounded-lg text-xs">
                                <span class="text-base text-slate-400">📋</span> Transactions
                            </div>
                            <div class="flex items-center gap-3 px-3 py-2 text-slate-600 rounded-lg text-xs">
                                <span class="text-base text-slate-400">🏷️</span> Categories
                            </div>
                            <div class="flex items-center gap-3 px-3 py-2 text-slate-600 rounded-lg text-xs">
                                <span class="text-base text-slate-400">📊</span> Budget
                            </div>
                            <div class="flex items-center gap-3 px-3 py-2 text-slate-600 rounded-lg text-xs">
                                <span class="text-base text-slate-400">🎯</span> Savings
                            </div>
                            <div class="flex items-center gap-3 px-3 py-2 text-slate-600 rounded-lg text-xs">
                                <span class="text-base text-slate-400">🔁</span> Subscription
                            </div>
                            <div class="flex items-center gap-3 px-3 py-2 text-slate-600 rounded-lg text-xs">
                                <span class="text-base text-slate-400">🧾</span> OCR Receipt
                            </div>
                            <div class="flex items-center gap-3 px-3 py-2 text-slate-600 rounded-lg text-xs">
                                <span class="text-base text-slate-400">📈</span> Reports
                            </div>
                            <div class="flex items-center gap-3 px-3 py-2 text-slate-600 rounded-lg text-xs">
                                <span class="text-base text-slate-400">⚙️</span> Settings
                            </div>
                        </div>
                        <div class="p-4 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <!-- Stiker / Icon sesuai permintaan -->
                                <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm">👤</div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">patrik</p>
                                    <p class="text-[9px] text-slate-500">patrik12@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Area -->
                    <div class="flex-1 p-4 md:p-6 overflow-hidden flex flex-col gap-4">
                        
                        <!-- Header -->
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl md:text-2xl font-bold text-slate-800">Halo, patrik</h2>
                                <p class="text-[10px] md:text-xs text-slate-500">Ringkasan keuanganmu hari ini.</p>
                            </div>
                            <div class="hidden sm:flex gap-2">
                                <div class="border border-slate-200 bg-white text-slate-600 px-3 py-1.5 rounded text-xs flex items-center gap-1 shadow-sm">
                                    📅 09 Jun 2026
                                </div>
                                <div class="bg-blue-600 text-white px-3 py-1.5 rounded text-xs font-medium flex items-center gap-1 shadow-sm">
                                    📥 Export
                                </div>
                            </div>
                        </div>

                        <!-- 4 Summary Cards -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <div class="bg-white p-3 rounded-lg border border-slate-200 shadow-sm flex flex-col">
                                <div class="flex items-center gap-2 text-slate-500 text-[10px] mb-1">
                                    <div class="w-6 h-6 bg-blue-50 text-blue-500 rounded flex items-center justify-center">💼</div>
                                    Total Balance
                                </div>
                                <h3 class="text-sm md:text-lg font-bold text-slate-800">Rp 5.400.002</h3>
                                <p class="text-[9px] text-green-500 mt-auto pt-1">2 wallet aktif</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-slate-200 shadow-sm flex flex-col">
                                <div class="flex items-center gap-2 text-slate-500 text-[10px] mb-1">
                                    <div class="w-6 h-6 bg-green-50 text-green-500 rounded flex items-center justify-center">📈</div>
                                    Income Bulan Ini
                                </div>
                                <h3 class="text-sm md:text-lg font-bold text-slate-800">Rp 500.000</h3>
                                <p class="text-[9px] text-green-500 mt-auto pt-1">+100,0% dari bulan lalu</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-slate-200 shadow-sm flex flex-col">
                                <div class="flex items-center gap-2 text-slate-500 text-[10px] mb-1">
                                    <div class="w-6 h-6 bg-red-50 text-red-500 rounded flex items-center justify-center">📉</div>
                                    Expense Bulan Ini
                                </div>
                                <h3 class="text-sm md:text-lg font-bold text-slate-800">Rp 449.998</h3>
                                <p class="text-[9px] text-red-500 mt-auto pt-1">+100,0% dari bulan lalu</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-slate-200 shadow-sm flex flex-col">
                                <div class="flex items-center gap-2 text-slate-500 text-[10px] mb-1">
                                    <div class="w-6 h-6 bg-purple-50 text-purple-500 rounded flex items-center justify-center">🎯</div>
                                    Saving Goal
                                </div>
                                <h3 class="text-sm md:text-lg font-bold text-slate-800">4%</h3>
                                <p class="text-[9px] text-slate-500 mt-auto pt-1">0 dari 2 goal tercapai</p>
                                <div class="w-full bg-slate-100 h-1 mt-1.5 rounded-full"><div class="bg-purple-500 h-1 rounded-full" style="width: 4%"></div></div>
                            </div>
                        </div>

                        <!-- Middle Area: Charts -->
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3 flex-1 min-h-[140px]">
                            <!-- Line Chart -->
                            <div class="md:col-span-3 bg-white p-3 rounded-lg border border-slate-200 shadow-sm flex flex-col">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-800">Cash Flow 6 Bulan Terakhir</h4>
                                        <p class="text-[9px] text-slate-500">Perbandingan Income vs Expense</p>
                                    </div>
                                    <span class="text-[9px] border px-1.5 py-0.5 rounded text-slate-500">6 Bulan Terakhir</span>
                                </div>
                                <div class="flex-1 relative mt-2 border-l border-b border-slate-100 pb-1 pl-1 flex items-end opacity-70">
                                    <svg viewBox="0 0 100 100" class="w-full h-full" preserveAspectRatio="none">
                                        <polyline points="0,95 20,95 40,95 60,95 80,85 100,10" fill="none" stroke="#22c55e" stroke-width="1.5"/>
                                        <polyline points="0,95 20,95 40,95 60,95 80,95 100,20" fill="none" stroke="#ef4444" stroke-width="1.5"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Doughnut Chart -->
                            <div class="md:col-span-2 bg-white p-3 rounded-lg border border-slate-200 shadow-sm flex items-center gap-3">
                                <div class="flex-1">
                                    <h4 class="text-xs font-bold text-slate-800">Pengeluaran per Kategori</h4>
                                    <p class="text-[9px] text-slate-500 mb-2">Bulan Ini</p>
                                    <div class="w-20 h-20 md:w-24 md:h-24 rounded-full border-[6px] md:border-[8px] border-blue-500 border-l-green-500 mx-auto flex items-center justify-center shadow-inner">
                                        <div class="text-center">
                                            <p class="text-[8px] text-slate-500">Total</p>
                                            <p class="text-[9px] md:text-[10px] font-bold">Rp 449.998</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-1 text-[9px] space-y-2 hidden sm:block">
                                    <div class="flex justify-between items-center border-b border-slate-50 pb-1">
                                        <span class="flex items-center gap-1"><span class="w-2 h-2 bg-blue-500 rounded-full"></span> Belanja Bulanan</span>
                                        <span class="font-bold">55,6%</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="flex items-center gap-1"><span class="w-2 h-2 bg-green-500 rounded-full"></span> service motor</span>
                                        <span class="font-bold">44,4%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Area: Lists & Progress -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 hidden sm:grid">
                            <!-- Transaksi Terbaru -->
                            <div class="bg-white p-3 rounded-lg border border-slate-200 shadow-sm flex flex-col">
                                <h4 class="text-xs font-bold text-slate-800 mb-2 flex justify-between">Transaksi Terbaru <span class="font-normal text-[9px] border px-1.5 rounded text-slate-400">Lihat Semua</span></h4>
                                <div class="space-y-2 flex-1">
                                    <div class="flex justify-between items-center pb-2 border-b border-slate-50">
                                        <div class="flex gap-2 items-center">
                                            <div class="w-5 h-5 bg-red-100 text-red-500 rounded-full flex items-center justify-center text-[10px]">↓</div>
                                            <div><p class="text-[9px] font-bold text-slate-700">belanja dapur dan...</p><p class="text-[8px] text-slate-400">Expense - BNI</p></div>
                                        </div>
                                        <p class="text-[9px] font-bold text-red-500">-Rp 250.000</p>
                                    </div>
                                    <div class="flex justify-between items-center pb-2 border-b border-slate-50">
                                        <div class="flex gap-2 items-center">
                                            <div class="w-5 h-5 bg-green-100 text-green-500 rounded-full flex items-center justify-center text-[10px]">↑</div>
                                            <div><p class="text-[9px] font-bold text-slate-700">freelance web</p><p class="text-[8px] text-slate-400">Income - BNI</p></div>
                                        </div>
                                        <p class="text-[9px] font-bold text-green-500">+Rp 500.000</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Budget -->
                            <div class="bg-white p-3 rounded-lg border border-slate-200 shadow-sm">
                                <h4 class="text-xs font-bold text-slate-800 mb-2 flex justify-between">Budget Bulan Ini <span class="font-normal text-[9px] border px-1.5 rounded text-slate-400">Lihat Semua</span></h4>
                                <div class="mb-2">
                                    <div class="flex justify-between text-[9px] mb-1">
                                        <span class="font-medium text-slate-700 flex items-center gap-1"><span class="text-[8px]">📊</span> Belanja Bulanan</span>
                                        <span class="text-slate-700">50%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full mb-0.5"><div class="bg-green-500 h-1.5 rounded-full" style="width: 50%"></div></div>
                                    <p class="text-[8px] text-slate-400">Rp 250.000 / Rp 500.000</p>
                                </div>
                            </div>
                            <!-- Savings -->
                            <div class="bg-white p-3 rounded-lg border border-slate-200 shadow-sm">
                                <h4 class="text-xs font-bold text-slate-800 mb-2 flex justify-between">Saving Goals <span class="font-normal text-[9px] border px-1.5 rounded text-slate-400">Lihat Semua</span></h4>
                                <div class="mb-3">
                                    <div class="flex justify-between text-[9px] mb-1">
                                        <span class="font-medium text-slate-700 flex items-center gap-1"><span class="text-blue-500 text-[8px]">🛡️</span> Dana Darurat</span>
                                        <span class="text-slate-700">7%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full mb-0.5"><div class="bg-blue-500 h-1.5 rounded-full" style="width: 7%"></div></div>
                                    <p class="text-[8px] text-slate-400">Rp 350.000 / Rp 5.000.000</p>
                                </div>
                                <div>
                                    <div class="flex justify-between text-[9px] mb-1">
                                        <span class="font-medium text-slate-700 flex items-center gap-1"><span class="text-green-500 text-[8px]">💰</span> Tabungan</span>
                                        <span class="text-slate-700">1.5%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full mb-0.5"><div class="bg-green-500 h-1.5 rounded-full" style="width: 1.5%"></div></div>
                                    <p class="text-[8px] text-slate-400">Rp 300.000 / Rp 20.000.000</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
