<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Category;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with(['wallet', 'category', 'transferToWallet'])
            ->latest('transaction_date')
            ->paginate(10);

        return view('user.transaction.index', compact('transactions'));
    }

    // ==============================
    // FORM CREATE
    // ==============================
    public function create()
    {
        $wallets = Wallet::where('user_id', Auth::id())->get();
        $categories = Category::where('user_id', Auth::id())->get();

        return view('user.transaction.create', compact('wallets', 'categories'));
    }

    // store untuk semua jenis transaksi (income, expense, transfer)
    public function store(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'type' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',

            // optional
            'category_id' => 'nullable|exists:categories,id',
            'transfer_to_wallet_id' => 'nullable|exists:wallets,id',
            'description' => 'nullable|string'
        ]);


        // 🔁 TRANSFER
        if ($request->type === 'transfer') {

            // validasi tambahan
            if (!$request->transfer_to_wallet_id) {
                return back()->withErrors('Wallet tujuan wajib diisi untuk transfer');
            }

            if ($request->wallet_id == $request->transfer_to_wallet_id) {
                return back()->withErrors('Tidak bisa transfer ke wallet yang sama');
            }

            Transaction::create([
                'user_id' => Auth::id(),
                'wallet_id' => $request->wallet_id,
                'transfer_to_wallet_id' => $request->transfer_to_wallet_id,
                'amount' => $request->amount,
                'type' => 'transfer',
                'category_id' => null,
                'description' => $request->description,
                'transaction_date' => $request->transaction_date,
            ]);
        } else {
            // 💰 INCOME / EXPENSE

            if (!$request->category_id) {
                return back()->withErrors('Kategori wajib diisi');
            }

            Transaction::create([
                'user_id' => Auth::id(),
                'wallet_id' => $request->wallet_id,
                'category_id' => $request->category_id,
                'transfer_to_wallet_id' => null,
                'amount' => $request->amount,
                'type' => $request->type,
                'description' => $request->description,
                'transaction_date' => $request->transaction_date,
            ]);
        }

        return redirect()->route('user.transaction.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    // ==============================
    // FORM EDIT
    // ==============================
    public function edit(Transaction $transaction)
    {
        // keamanan: hanya user sendiri
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $wallets = Wallet::where('user_id', Auth::id())->get();
        $categories = Category::where('user_id', Auth::id())->get();

        return view('user.transaction.edit', compact('transaction', 'wallets', 'categories'));
    }

    // ==============================
    // UPDATE
    // ==============================
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'type' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',

            'category_id' => 'nullable|exists:categories,id',
            'transfer_to_wallet_id' => 'nullable|exists:wallets,id',
            'description' => 'nullable|string'
        ]);

        if ($request->type === 'transfer') {

            if (!$request->transfer_to_wallet_id) {
                return back()->withErrors('Wallet tujuan wajib diisi');
            }

            if ($request->wallet_id == $request->transfer_to_wallet_id) {
                return back()->withErrors('Tidak bisa transfer ke wallet yang sama');
            }

            $transaction->update([
                'wallet_id' => $request->wallet_id,
                'transfer_to_wallet_id' => $request->transfer_to_wallet_id,
                'category_id' => null,
                'amount' => $request->amount,
                'type' => 'transfer',
                'description' => $request->description,
                'transaction_date' => $request->transaction_date,
            ]);
        } else {

            if (!$request->category_id) {
                return back()->withErrors('Kategori wajib diisi');
            }

            $transaction->update([
                'wallet_id' => $request->wallet_id,
                'category_id' => $request->category_id,
                'transfer_to_wallet_id' => null,
                'amount' => $request->amount,
                'type' => $request->type,
                'description' => $request->description,
                'transaction_date' => $request->transaction_date,
            ]);
        }

        return redirect()->route('user.transaction.index')
            ->with('success', 'Transaksi berhasil diupdate');
    }

    // ==============================
    // DELETE
    // ==============================
    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus');
    }
}
