<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik global untuk admin
        $totalUsers       = User::where('role', 'user')->count();
        $totalTransactions = Transaction::count();
        $totalWallets     = Wallet::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTransactions',
            'totalWallets'
        ));
    }
}
