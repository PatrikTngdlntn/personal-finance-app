<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\SavingTransaction;
use App\Models\SubscriptionHistory;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Subscription;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year  = $request->year ?? now()->year;

        $transactions = Transaction::where('user_id', Auth::id())
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->with(['category', 'wallet'])
            ->latest('transaction_date')
            ->get();

        $income = $transactions
            ->where('type', 'income')
            ->sum('amount');

        $expense = $transactions
            ->where('type', 'expense')
            ->sum('amount');

        $subscriptionExpense = SubscriptionHistory::where('user_id', Auth::id())
            ->whereMonth('paid_at', $month)
            ->whereYear('paid_at', $year)
            ->sum('amount');

        $subscriptions = SubscriptionHistory::where('user_id', Auth::id())
            ->whereMonth('paid_at', $month)
            ->whereYear('paid_at', $year)
            ->latest('paid_at')
            ->get();

        $savingExpense = SavingTransaction::whereHas('savingAccount', function ($q) {
            $q->where('user_id', Auth::id());
        })
            ->where('type', 'deposit')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $balance =
            $income
            - $expense
            - $subscriptionExpense
            - $savingExpense;
        $categorySummary = Transaction::selectRaw('
                category_id,
                SUM(amount) as total
            ')
            ->where('user_id', Auth::id())
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->groupBy('category_id')
            ->with('category')
            ->get();
        $savingSummary = SavingTransaction::selectRaw('
        savings_id,
        SUM(amount) as total')
            ->whereHas('savingAccount', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->where('type', 'deposit')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->groupBy('savings_id')
            ->with('savingAccount')
            ->get();



        return view(
            'user.report.index',
            compact(
                'transactions',
                'income',
                'expense',
                'balance',
                'categorySummary',
                'subscriptionExpense',
                'subscriptions',
                'savingExpense',
                'savingSummary',
                'month',
                'year'
            )
        );
    }

    public function exportExcel(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year  = $request->year ?? now()->year;

        $transactions = Transaction::where('user_id', Auth::id())
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->with(['category', 'wallet'])
            ->latest('transaction_date')
            ->get();

        return Excel::download(new ReportExport($transactions), "report-{$month}-{$year}.xlsx");
    }
}
