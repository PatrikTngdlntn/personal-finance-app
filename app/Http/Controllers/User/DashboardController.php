<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Budget;
use App\Models\Saving;
use App\Models\Subscription;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        // 1. Wallet
        $wallets = Wallet::where('user_id', $userId)
            ->with(['transactions'])
            ->get();

        $totalBalance = $wallets->sum(function ($wallet) {
            return $wallet->balance;
        });

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
            ->limit(10)
            ->get();

        // 4. Expense by category
        $expenseByCategory = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        // 5. Budget
        $budgetStatus = Budget::where('user_id', Auth::id())
            ->with('category')
            ->get()
            ->map(function ($budget) {

                $spent = Transaction::where('user_id', Auth::id())
                    ->where('type', 'expense')
                    ->where('category_id', $budget->category_id)
                    ->whereMonth('transaction_date', now()->month)
                    ->whereYear('transaction_date', now()->year)
                    ->sum('amount');

                $percentage = 0;

                if ($budget->limit_amount > 0) {
                    $percentage = ($spent / $budget->limit_amount) * 100;
                }

                // maksimal 100% biar bar tidak overflow
                $percentage = min(round($percentage), 100);

                // status
                $status = 'safe';

                if ($percentage >= 100) {
                    $status = 'exceeded';
                } elseif ($percentage >= 80) {
                    $status = 'warning';
                }

                $budget->spent = $spent;
                $budget->percentage = $percentage;
                $budget->status = $status;

                return $budget;
            });
        // 6. Saving
        $savings = Saving::where('user_id', $userId)
            ->get()
            ->map(function ($saving) {
                $saving->progress = $saving->target_amount > 0
                    ? min(round(($saving->saved_amount / $saving->target_amount) * 100, 1), 100)
                    : 0;
                return $saving;
            });

        // 7. Subscription
        $upcomingSubscriptions = Subscription::where('user_id', $userId)
            ->whereBetween('next_billing', [
                Carbon::today(),
                Carbon::today()->addDays(30)
            ])
            ->orderBy('next_billing')
            ->get();

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
