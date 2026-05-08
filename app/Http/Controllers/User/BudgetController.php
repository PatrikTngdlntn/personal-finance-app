<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Budget;
use App\Models\Category;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::where('user_id', Auth::id())
            ->with('category')
            ->latest()
            ->get();

        return view('user.budget.index', compact('budgets'));
    }

    // FORM CREATE
    public function create()
    {
        // hanya category expense
        $categories = Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->get();

        return view('user.budget.create', compact('categories'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'limit_amount' => 'required|numeric|min:1',
            'period' => 'required|in:monthly,weekly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // category milik user
        $category = Category::where('id', $request->category_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$category) {
            abort(403);
        }

        // category harus expense
        if ($category->type !== 'expense') {
            return back()->withErrors([
                'category_id' => 'Budget hanya untuk kategori expense'
            ]);
        }

        Budget::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'limit_amount' => $request->limit_amount,
            'period' => $request->period,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()
            ->route('user.budget.index')
            ->with('success', 'Budget berhasil ditambahkan');
    }

    // FORM EDIT
    public function edit(Budget $budget)
    {
        // keamanan
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->get();

        return view('user.budget.edit', compact('budget', 'categories'));
    }

    // UPDATE
    public function update(Request $request, Budget $budget)
    {
        // keamanan
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'limit_amount' => 'required|numeric|min:1',
            'period' => 'required|in:monthly,weekly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // validasi ownership category
        $category = Category::where('id', $request->category_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$category) {
            abort(403);
        }

        // hanya expense
        if ($category->type !== 'expense') {
            return back()->withErrors([
                'category_id' => 'Budget hanya untuk kategori expense'
            ]);
        }

        $budget->update([
            'category_id' => $request->category_id,
            'limit_amount' => $request->limit_amount,
            'period' => $request->period,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()
            ->route('user.budget.index')
            ->with('success', 'Budget berhasil diupdate');
    }

    // ==============================
    // DELETE
    // ==============================
    public function destroy(Budget $budget)
    {
        // keamanan
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $budget->delete();

        return back()->with('success', 'Budget berhasil dihapus');
    }
}
