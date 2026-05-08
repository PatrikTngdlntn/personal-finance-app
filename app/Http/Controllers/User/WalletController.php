<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::id())->get();

        return view('user.wallet.index', compact('wallets'));
    }

    // ➕ Form create
    public function create()
    {
        return view('user.wallet.create');
    }

    // 💾 Simpan wallet baru
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'initial_balance' => 'required|numeric|min:0',
            'type'            => 'required|in:cash,bank,e-wallet',
            'currency'        => 'nullable|string|max:10',
        ]);

        Wallet::create([
            'user_id'         => Auth::id(),
            'name'            => $request->name,
            'type'            => $request->type,
            'currency'        => $request->currency ?? 'IDR',
            'initial_balance' => $request->initial_balance,
        ]);

        return redirect()->route('user.wallet.index')
            ->with('success', 'Wallet berhasil ditambahkan');
    }

    // ✏️ Form edit
    public function edit(int $id)
    {
        $wallet = Wallet::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.wallet.edit', compact('wallet'));
    }

    // 🔄 Update wallet
    public function update(Request $request, int $id)
    {
        $wallet = Wallet::where('user_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:255',
            'initial_balance' => 'required|numeric|min:0',
            'type'            => 'required|in:cash,bank,e-wallet',
            'currency'        => 'nullable|string|max:10',
        ]);

        $wallet->update([
            'name'            => $request->name,
            'type'            => $request->type,
            'currency'        => $request->currency ?? $wallet->currency,
            'initial_balance' => $request->initial_balance,
        ]);

        return redirect()->route('user.wallet.index')
            ->with('success', 'Wallet berhasil diupdate');
    }

    // ❌ Hapus wallet
    public function destroy(int $id)
    {
        $wallet = Wallet::where('user_id', Auth::id())
            ->findOrFail($id);

        $wallet->delete();

        return redirect()->route('user.wallet.index')
            ->with('success', 'Wallet berhasil dihapus');
    }
}
