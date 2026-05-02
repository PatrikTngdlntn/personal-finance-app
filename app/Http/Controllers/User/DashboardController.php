<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        // 1. Wallet
        $wallets = Wallet::where('user_id', $userId)->get();
        $totalBalance = $wallets->sum('balance');

        // 2. Summary transaksi
        $income = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $expense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // 3. Transaksi terbaru
        $recentTransactions = Transaction::where('user_id', $userId)
            ->with(['wallet', 'category'])
            ->latest('transaction_date')
            ->take(10)
            ->get();

        // 4. Chart kategori (AMAN)
        $expenseByCategory = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->with('category')
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->get();

        // 5. Default kosong (biar tidak error)
        $budgetStatus = [];
        $savings = [];
        $upcomingSubscriptions = [];

        return view('user.dashboard', compact(
            'wallets',
            'totalBalance',
            'income',
            'expense',
            'recentTransactions',
            'expenseByCategory',
            'budgetStatus',
            'savings',
            'upcomingSubscriptions'
        ));
    }
}
