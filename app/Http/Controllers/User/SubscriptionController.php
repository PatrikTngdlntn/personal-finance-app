<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Subscription;
use App\Models\Wallet;

class SubscriptionController extends Controller
{
    // ==============================
    // LIST SUBSCRIPTION
    // ==============================
    public function index()
    {
        $subscriptions = Subscription::where('user_id', Auth::id())
            ->with('wallet')
            ->latest()
            ->paginate(10);

        return view('user.subscription.index', compact('subscriptions'));
    }

    // ==============================
    // FORM CREATE
    // ==============================
    public function create()
    {
        $wallets = Wallet::where('user_id', Auth::id())->get();

        return view('user.subscription.create', compact('wallets'));
    }

    // ==============================
    // STORE
    // ==============================
    public function store(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'billing_cycle' => 'required|in:daily,weekly,monthly,yearly',
            'next_billing' => 'required|date',
        ]);

        // cek wallet milik user
        $wallet = Wallet::findOrFail($request->wallet_id);

        if ($wallet->user_id !== Auth::id()) {
            abort(403);
        }

        Subscription::create([
            'user_id' => Auth::id(),
            'wallet_id' => $request->wallet_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'billing_cycle' => $request->billing_cycle,
            'next_billing' => $request->next_billing,
        ]);

        return redirect()
            ->route('user.subscription.index')
            ->with('success', 'Subscription berhasil ditambahkan');
    }

    // ==============================
    // FORM EDIT
    // ==============================
    public function edit(Subscription $subscription)
    {
        // keamanan
        if ($subscription->user_id !== Auth::id()) {
            abort(403);
        }

        $wallets = Wallet::where('user_id', Auth::id())->get();

        return view('user.subscription.edit', compact(
            'subscription',
            'wallets'
        ));
    }

    // ==============================
    // UPDATE
    // ==============================
    public function update(Request $request, Subscription $subscription)
    {
        // keamanan
        if ($subscription->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'billing_cycle' => 'required|in:daily,weekly,monthly,yearly',
            'next_billing' => 'required|date',
        ]);

        // cek wallet milik user
        $wallet = Wallet::findOrFail($request->wallet_id);

        if ($wallet->user_id !== Auth::id()) {
            abort(403);
        }

        $subscription->update([
            'wallet_id' => $request->wallet_id,
            'name' => $request->name,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'billing_cycle' => $request->billing_cycle,
            'next_billing' => $request->next_billing,
        ]);

        return redirect()
            ->route('user.subscription.index')
            ->with('success', 'Subscription berhasil diupdate');
    }

    // ==============================
    // DELETE
    // ==============================
    public function destroy(Subscription $subscription)
    {
        // keamanan
        if ($subscription->user_id !== Auth::id()) {
            abort(403);
        }

        $subscription->delete();

        return back()->with(
            'success',
            'Subscription berhasil dihapus'
        );
    }

    // pay subscription
    public function pay(Subscription $subscription)
    {
        // keamanan
        if ($subscription->user_id !== Auth::id()) {
            abort(403);
        }

        $wallet = $subscription->wallet;

        // cek wallet
        if (!$wallet) {
            return back()->with(
                'error',
                'Wallet tidak ditemukan'
            );
        }

        // cek saldo
        if ($wallet->initial_balance < $subscription->amount) {

            return back()->with(
                'error',
                'Saldo wallet tidak cukup'
            );
        }

        // potong saldo
        $wallet->decrement(
            'initial_balance',
            $subscription->amount
        );

        // update next billing
        switch ($subscription->billing_cycle) {

            case 'daily':
                $nextBilling = $subscription->next_billing->copy()->addDay();
                break;

            case 'weekly':
                $nextBilling = $subscription->next_billing->copy()->addWeek();
                break;

            case 'monthly':
                $nextBilling = $subscription->next_billing->copy()->addMonth();
                break;

            case 'yearly':
                $nextBilling = $subscription->next_billing->copy()->addYear();
                break;

            default:
                $nextBilling = $subscription->next_billing;
                break;
        }

        $subscription->update([
            'next_billing' => $nextBilling
        ]);

        return back()->with(
            'success',
            'Subscription berhasil dibayar'
        );
    }
}
