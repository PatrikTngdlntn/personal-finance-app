<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Saving;

class SavingController extends Controller
{
    // lihat semua tabungan user
    public function index()
    {
        $savings = Saving::where('user_id', Auth::id())->latest()->paginate(10);


        return view('user.saving.index', compact('savings'));
    }

    // membuat saving baru
    public function create()
    {
        return view('user.saving.create');
    }
    // simpan saving baru
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1',
            'target_date'   => 'nullable|date',
        ]);

        Saving::create([
            'user_id'       => Auth::id(),
            'name'          => $request->name,
            'target_amount' => $request->target_amount,
            'saved_amount'  => 0,
            'target_date'   => $request->target_date,
        ]);

        return redirect()
            ->route('user.saving.index')
            ->with('success', 'Target tabungan berhasil dibuat');
    }

    // DETAIL SAVING
    public function show(Saving $saving)
    {
        // keamanan
        if ($saving->user_id !== Auth::id()) {
            abort(403);
        }

        $saving->load('transactions');

        return view('user.saving.show', compact('saving'));
    }

    // FORM EDIT
    public function edit(Saving $saving)
    {
        // keamanan
        if ($saving->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.saving.edit', compact('saving'));
    }
    // UPDATE SAVING
    public function update(Request $request, Saving $saving)
    {
        // keamanan
        if ($saving->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:' . $saving->saved_amount,
            'target_date'   => 'nullable|date',
        ]);

        $saving->update([
            'name'          => $request->name,
            'target_amount' => $request->target_amount,
            'target_date'   => $request->target_date,
        ]);

        return redirect()
            ->route('user.saving.index')
            ->with('success', 'Target tabungan berhasil diupdate');
    }

    // menghapus saving
    public function destroy(Saving $saving)
    {
        // keamanan
        if ($saving->user_id !== Auth::id()) {
            abort(403);
        }

        // tidak boleh hapus jika masih ada saldo
        if ($saving->saved_amount > 0) {

            return back()->with(
                'error',
                'Tabungan tidak dapat dihapus karena masih memiliki saldo'
            );
        }

        $saving->delete();

        return redirect()
            ->route('user.saving.index')
            ->with('success', 'Target tabungan berhasil dihapus');
    }
}
