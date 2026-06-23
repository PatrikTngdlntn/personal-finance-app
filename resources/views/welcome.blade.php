<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Finance - Kendalikan Keuangan Pribadi Anda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Import Font (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-bg {
            background: radial-gradient(circle at top center, #f8fafc 0%, #ffffff 100%);
        }
        .perspective-grid {
            perspective: 1200px;
        }
        .mockup-card {
            transform: rotateX(12deg) rotateY(-8deg) rotateZ(3deg) scale(0.95);
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        }
        .mockup-card:hover {
            transform: rotateX(2deg) rotateY(0deg) rotateZ(0deg) scale(1.02);
        }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased selection:bg-indigo-100 selection:text-indigo-900 overflow-x-hidden">

    <!-- NAVIGATION -->
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-md z-50 border-b border-slate-100">
        <div class="max-w-[1200px] mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="#" class="flex items-center gap-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500 to-blue-600 font-black text-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m8 14 3-3 2 2 3-3"/></svg>
                </div>
                <span class="text-xl font-bold text-slate-900 tracking-tight">Personal Finance</span>
            </a>

            <!-- Menu (Desktop) -->
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-500">
                <a href="#" class="text-slate-900">Beranda</a>
                <a href="#fitur" class="hover:text-slate-900 transition">Fitur Utama</a>
                <a href="#tentang" class="hover:text-slate-900 transition">Tentang Kami</a>
            </div>

            <!-- Auth Buttons -->
            <div class="flex items-center gap-3">
                <a href="{{ route('register') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition px-4 py-2">
                    Daftar
                </a>
                <a href="{{ route('login') }}" class="text-sm font-medium bg-slate-900 text-white px-5 py-2 rounded-full hover:bg-indigo-600 transition shadow-sm">
                    Masuk
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="pt-40 pb-20 hero-bg text-center px-4 overflow-hidden">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold text-slate-900 tracking-tight leading-[1.1] mb-6">
                Kendalikan Keuangan Pribadi <br class="hidden md:block" /> Anda Kapan Saja.
            </h1>
            <p class="text-lg text-slate-500 mb-10 max-w-2xl mx-auto leading-relaxed">
                Platform personal finance yang memudahkan Anda untuk melacak pemasukan, mengatur budget bulanan, dan mencapai target tabungan dalam satu dashboard cerdas.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-slate-900 text-white px-8 py-3 rounded-full font-medium hover:bg-indigo-600 transition shadow-lg shadow-indigo-500/20">
                    Mulai Sekarang
                </a>
                <a href="#fitur" class="w-full sm:w-auto bg-white border border-slate-200 text-slate-700 px-8 py-3 rounded-full font-medium hover:bg-slate-50 transition">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>

        <!-- DASHBOARD MOCKUP -->
        <div class="max-w-[1000px] mx-auto mt-20 perspective-grid px-4">
            <!-- Frame Dashboard -->
            <div class="mockup-card relative bg-slate-50 rounded-xl shadow-2xl border border-slate-200 w-full max-w-[1100px] mx-auto overflow-hidden flex" style="height: 600px;">
                
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
                                <p class="text-xs font-bold text-slate-800">User</p>
                                <p class="text-[9px] text-slate-500">user@email.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="flex-1 p-4 md:p-6 overflow-hidden flex flex-col gap-4">
                    
                    <!-- Header -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-slate-800">Halo, User</h2>
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
            
            <!-- Glow effect behind mockup -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-[800px] h-[300px] bg-indigo-500/15 blur-[120px] -z-10 rounded-full"></div>
        </div>
    </section>

    <!-- TRUSTED BY SECTION -->
    <section class="py-12 border-b border-slate-100">
        <div class="max-w-[1200px] mx-auto px-6 text-center">
            <p class="text-xs font-medium text-slate-400 uppercase tracking-widest mb-6">Keamanan Data Anda Adalah Prioritas</p>
            <div class="flex flex-wrap justify-center items-center gap-6 md:gap-12 text-slate-300 font-semibold text-lg md:text-xl">
                <span>🔒 Enkripsi Aman</span>
                <span>📊 Analisis Pintar</span>
                <span>📱 Akses Kapan Saja</span>
                <span>⚡ Cepat & Ringan</span>
            </div>
        </div>
    </section>

    <!-- ABOUT / FEATURES SECTION -->
    <section id="fitur" class="py-24 bg-white">
        <div class="max-w-[1200px] mx-auto px-6">
            <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-semibold rounded-full mb-6">TENTANG FINANCE APP</span>
            
            <h2 class="text-3xl md:text-5xl font-light text-slate-500 leading-tight max-w-4xl mb-16">
                Kami menyederhanakan cara Anda mengelola uang. Membantu Anda <span class="font-medium text-slate-900">melacak saldo wallet, membatasi pengeluaran bulanan, dan merencanakan masa depan</span> dengan lebih baik.
            </h2>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Dark Card (Visual Element) -->
                <div class="bg-slate-900 rounded-2xl p-8 text-white relative overflow-hidden group min-h-[200px]">
                    <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-indigo-500/30 blur-2xl rounded-full transition group-hover:scale-150"></div>
                    <div class="relative z-10 h-full flex flex-col justify-end">
                        <h4 class="font-semibold text-lg mb-1">Mulai Sekarang</h4>
                        <p class="text-sm text-slate-400">Bergabunglah dan capai kemerdekaan finansial.</p>
                    </div>
                </div>

                <!-- Feature Card 1 -->
                <div class="bg-white border border-slate-100 rounded-2xl p-8 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center gap-2 mb-4 text-emerald-500 font-bold">
                        <span>[ 1 ]</span>
                        <h4 class="text-slate-900 font-semibold text-sm">Tracking Transaksi</h4>
                    </div>
                    <p class="text-slate-500 text-sm mt-auto pt-10">
                        Catat setiap pemasukan, pengeluaran, dan transfer antar wallet Anda dengan rapi dan terkategori.
                    </p>
                </div>

                <!-- Feature Card 2 -->
                <div class="bg-white border border-slate-100 rounded-2xl p-8 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center gap-2 mb-4 text-indigo-500 font-bold">
                        <span>[ 2 ]</span>
                        <h4 class="text-slate-900 font-semibold text-sm">Smart Budgeting</h4>
                    </div>
                    <p class="text-slate-500 text-sm mt-auto pt-10">
                        Atur batas anggaran bulanan per kategori. Dapatkan peringatan otomatis sebelum pengeluaran Anda jebol.
                    </p>
                </div>

                <!-- Feature Card 3 -->
                <div class="bg-white border border-slate-100 rounded-2xl p-8 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center gap-2 mb-4 text-blue-500 font-bold">
                        <span>[ 3 ]</span>
                        <h4 class="text-slate-900 font-semibold text-sm">Savings Goal</h4>
                    </div>
                    <p class="text-slate-500 text-sm mt-auto pt-10">
                        Buat target tabungan impian Anda, simpan uang secara bertahap, dan pantau progressnya secara visual.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="border-t border-slate-100 bg-slate-50 py-10 text-center">
        <p class="text-sm text-slate-500">© {{ date('Y') }} Personal Finance. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>
