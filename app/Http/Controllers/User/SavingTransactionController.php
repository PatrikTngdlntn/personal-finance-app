<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Saving;
use App\Models\Wallet;
use App\Models\SavingTransaction;

class SavingTransactionController extends Controller
{
    // ==========================================
    // LIST TRANSAKSI TABUNGAN
    // ==========================================
    public function index()
    {
        $transactions = SavingTransaction::where('user_id', Auth::id())
            ->with([
                'savingAccount',
                'wallet'
            ])
            ->latest()
            ->paginate(10);

        return view('user.saving-transaction.index', compact(
            'transactions'
        ));
    }

    // ==========================================
    // FORM CREATE
    // ==========================================
    public function create()
    {
        $savings = Saving::where('user_id', Auth::id())
            ->get();

        $wallets = Wallet::where('user_id', Auth::id())
            ->get();

        return view('user.saving-transaction.create', compact(
            'savings',
            'wallets'
        ));
    }

    // ==========================================
    // STORE
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'savings_id' => 'required|exists:savings,id',
            'wallet_id' => 'required|exists:wallets,id',
            'type' => 'required|in:deposit,withdraw',
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            $saving = Saving::findOrFail($request->savings_id);

            $wallet = Wallet::findOrFail($request->wallet_id);

            // ==========================================
            // KEAMANAN
            // ==========================================
            if (
                $saving->user_id !== Auth::id() ||
                $wallet->user_id !== Auth::id()
            ) {
                abort(403);
            }

            // ==========================================
            // DEPOSIT
            // ==========================================
            if ($request->type === 'deposit') {

                if ($wallet->initial_balance < $request->amount) {

                    return back()
                        ->withErrors([
                            'amount' => 'Saldo wallet tidak cukup'
                        ])
                        ->withInput();
                }

                // kurangi wallet
                $wallet->decrement(
                    'initial_balance',
                    $request->amount
                );

                // tambah saving
                $saving->increment(
                    'saved_amount',
                    $request->amount
                );
            }

            // ==========================================
            // WITHDRAW
            // ==========================================
            if ($request->type === 'withdraw') {

                if ($saving->saved_amount < $request->amount) {

                    return back()
                        ->withErrors([
                            'amount' => 'Saldo tabungan tidak cukup'
                        ])
                        ->withInput();
                }

                // kurangi saving
                $saving->decrement(
                    'saved_amount',
                    $request->amount
                );

                // tambah wallet
                $wallet->increment(
                    'initial_balance',
                    $request->amount
                );
            }

            // ==========================================
            // SIMPAN TRANSAKSI
            // ==========================================
            SavingTransaction::create([
                'user_id' => Auth::id(),
                'savings_id' => $request->savings_id,
                'wallet_id' => $request->wallet_id,
                'type' => $request->type,
                'amount' => $request->amount,
                'transaction_date' => $request->transaction_date,
                'description' => $request->description,
            ]);

            DB::commit();

            return redirect()
                ->route('user.saving-transaction.index')
                ->with(
                    'success',
                    'Transaksi tabungan berhasil dibuat'
                );
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with(
                    'error',
                    'Terjadi kesalahan: ' . $e->getMessage()
                );
        }
    }

    // ==========================================
    // FORM EDIT
    // ==========================================
    public function edit(SavingTransaction $savingTransaction)
    {
        if ($savingTransaction->user_id !== Auth::id()) {
            abort(403);
        }

        $wallets = Wallet::where('user_id', Auth::id())
            ->get();

        $savings = Saving::where('user_id', Auth::id())
            ->get();

        return view('user.saving-transaction.edit', compact(
            'savingTransaction',
            'wallets',
            'savings'
        ));
    }

    // ==========================================
    // UPDATE
    // ==========================================
    public function update(
        Request $request,
        SavingTransaction $savingTransaction
    ) {
        if ($savingTransaction->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'savings_id' => 'required|exists:savings,id',
            'wallet_id' => 'required|exists:wallets,id',
            'type' => 'required|in:deposit,withdraw',
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            // ==========================================
            // KEMBALIKAN SALDO LAMA
            // ==========================================

            $oldWallet = Wallet::find($savingTransaction->wallet_id);

            $oldSaving = Saving::find($savingTransaction->savings_id);

            if ($savingTransaction->type === 'deposit') {

                // balikin ke wallet
                $oldWallet?->increment(
                    'balance',
                    $savingTransaction->amount
                );

                // kurangi saving
                $oldSaving?->decrement(
                    'saved_amount',
                    $savingTransaction->amount
                );
            }

            if ($savingTransaction->type === 'withdraw') {

                // kurangi wallet
                $oldWallet?->decrement(
                    'initial_balance',
                    $savingTransaction->amount
                );

                // balikin saving
                $oldSaving?->increment(
                    'saved_amount',
                    $savingTransaction->amount
                );
            }

            // ==========================================
            // DATA BARU
            // ==========================================

            $newSaving = Saving::findOrFail($request->savings_id);

            $newWallet = Wallet::findOrFail($request->wallet_id);

            // keamanan
            if (
                $newSaving->user_id !== Auth::id() ||
                $newWallet->user_id !== Auth::id()
            ) {
                abort(403);
            }

            // ==========================================
            // APPLY TRANSAKSI BARU
            // ==========================================

            if ($request->type === 'deposit') {

                if ($newWallet->initial_balance < $request->amount) {

                    return back()
                        ->withErrors([
                            'amount' => 'Saldo wallet tidak cukup'
                        ])
                        ->withInput();
                }

                $newWallet->decrement(
                    'initial_balance',
                    $request->amount
                );

                $newSaving->increment(
                    'saved_amount',
                    $request->amount
                );
            }

            if ($request->type === 'withdraw') {

                if ($newSaving->saved_amount < $request->amount) {

                    return back()
                        ->withErrors([
                            'amount' => 'Saldo tabungan tidak cukup'
                        ])
                        ->withInput();
                }

                $newSaving->decrement(
                    'saved_amount',
                    $request->amount
                );

                $newWallet->increment(
                    'initial_balance',
                    $request->amount
                );
            }

            // ==========================================
            // UPDATE TRANSAKSI
            // ==========================================

            $savingTransaction->update([
                'savings_id' => $request->savings_id,
                'wallet_id' => $request->wallet_id,
                'type' => $request->type,
                'amount' => $request->amount,
                'transaction_date' => $request->transaction_date,
                'description' => $request->description,
            ]);

            DB::commit();

            return redirect()
                ->route('user.saving-transaction.index')
                ->with(
                    'success',
                    'Transaksi tabungan berhasil diupdate'
                );
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with(
                    'error',
                    'Terjadi kesalahan: ' . $e->getMessage()
                );
        }
    }

    // ==========================================
    // DELETE
    // ==========================================
    public function destroy(SavingTransaction $savingTransaction)
    {
        if ($savingTransaction->user_id !== Auth::id()) {
            abort(403);
        }

        DB::beginTransaction();

        try {

            $wallet = Wallet::find(
                $savingTransaction->wallet_id
            );

            $saving = Saving::find(
                $savingTransaction->savings_id
            );

            // ==========================================
            // BALIKKAN SALDO
            // ==========================================

            if ($savingTransaction->type === 'deposit') {

                // balikin ke wallet
                $wallet?->increment(
                    'initial_balance',
                    $savingTransaction->amount
                );

                // kurangi saving
                $saving?->decrement(
                    'saved_amount',
                    $savingTransaction->amount
                );
            }

            if ($savingTransaction->type === 'withdraw') {

                // kurangi wallet
                $wallet?->decrement(
                    'initial_balance',
                    $savingTransaction->amount
                );

                // balikin saving
                $saving?->increment(
                    'saved_amount',
                    $savingTransaction->amount
                );
            }

            // ==========================================
            // HAPUS TRANSAKSI
            // ==========================================

            $savingTransaction->delete();

            DB::commit();

            return back()->with(
                'success',
                'Transaksi tabungan berhasil dihapus'
            );
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                'Terjadi kesalahan: ' . $e->getMessage()
            );
        }
    }
}
