<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // =====================================
        // 1. WALLET
        // =====================================

        $wallets = Wallet::where('user_id', $userId)
            ->with(['transactions'])
            ->get();

        $totalBalance = $wallets->sum(function ($wallet) {
            return $wallet->balance;
        });

        // =====================================
        // 2. SUMMARY TRANSAKSI
        // =====================================

        $income = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $expense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $previousStartOfMonth = Carbon::now()->subMonthNoOverflow()->startOfMonth();
        $previousEndOfMonth = Carbon::now()->subMonthNoOverflow()->endOfMonth();

        $previousIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$previousStartOfMonth, $previousEndOfMonth])
            ->sum('amount');

        $previousExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$previousStartOfMonth, $previousEndOfMonth])
            ->sum('amount');

        $incomeTrend = $previousIncome > 0
            ? round((($income - $previousIncome) / $previousIncome) * 100, 1)
            : ($income > 0 ? 100 : 0);

        $expenseTrend = $previousExpense > 0
            ? round((($expense - $previousExpense) / $previousExpense) * 100, 1)
            : ($expense > 0 ? 100 : 0);

        // =====================================
        // 3. TRANSAKSI TERBARU
        // =====================================

        $recentTransactions = Transaction::where('user_id', $userId)
            ->with(['wallet', 'category'])
            ->latest('transaction_date')
            ->limit(10)
            ->get();

        // =====================================
        // 4. EXPENSE BY CATEGORY
        // =====================================

        $expenseByCategory = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        // =====================================
        // 5. BUDGET
        // =====================================

        $budgetStatus = Budget::where('user_id', $userId)
            ->with('category')
            ->get()
            ->map(function ($budget) use ($userId) {

                $spent = Transaction::where('user_id', $userId)
                    ->where('type', 'expense')
                    ->where('category_id', $budget->category_id)
                    ->whereMonth('transaction_date', now()->month)
                    ->whereYear('transaction_date', now()->year)
                    ->sum('amount');

                $percentage = 0;

                if ($budget->limit_amount > 0) {
                    $percentage = ($spent / $budget->limit_amount) * 100;
                }

                $percentage = min(round($percentage), 100);

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

        // =====================================
        // 6. SAVING
        // =====================================

        $savings = Saving::where('user_id', $userId)
            ->get()
            ->map(function ($saving) {

                $saving->progress =
                    $saving->target_amount > 0
                    ? min(
                        round(
                            ($saving->saved_amount / $saving->target_amount) * 100,
                            1
                        ),
                        100
                    )
                    : 0;

                return $saving;
            });

        // =====================================
        // 7. SUBSCRIPTION
        // =====================================

        $upcomingSubscriptions = Subscription::where('user_id', $userId)
            ->whereBetween('next_billing', [
                Carbon::today(),
                Carbon::today()->addDays(30)
            ])
            ->orderBy('next_billing')
            ->get();

        // =====================================
        // 8. CHART CASH FLOW
        // =====================================

        $chartLabels = [];
        $incomeChartData = [];
        $expenseChartData = [];

        for ($i = 5; $i >= 0; $i--) {

            $month = now()->subMonths($i);

            $chartLabels[] = $month->translatedFormat('M');

            $incomeChartData[] = Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereMonth('transaction_date', $month->month)
                ->whereYear('transaction_date', $month->year)
                ->sum('amount');

            $expenseChartData[] = Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereMonth('transaction_date', $month->month)
                ->whereYear('transaction_date', $month->year)
                ->sum('amount');
        }

        // =====================================
        // 9. CHART EXPENSE CATEGORY
        // =====================================

        $categoryLabels = $expenseByCategory
            ->pluck('category.name')
            ->map(fn($name) => $name ?? 'Tanpa Kategori')
            ->values();

        $categoryTotals = $expenseByCategory
            ->pluck('total')
            ->values();

        // =====================================
        // RETURN VIEW
        // =====================================

        return view('user.dashboard', compact(
            'wallets',
            'totalBalance',
            'income',
            'expense',
            'recentTransactions',
            'expenseByCategory',
            'budgetStatus',
            'savings',
            'upcomingSubscriptions',

            'chartLabels',
            'incomeChartData',
            'expenseChartData',
            'categoryLabels',
            'categoryTotals',
            'incomeTrend',
            'expenseTrend'
        ));
    }
}
