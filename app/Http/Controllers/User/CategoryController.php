<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.category.index', compact('categories'));
    }

    public function create()
    {
        return view('user.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:income,expense',
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()->route('user.category.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    // FORM EDIT
    public function edit(Category $category)
    {
        // keamanan
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:income,expense',
        ]);

        $category->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()->route('user.category.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    // DELETE
    // ==============================
    public function destroy(Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }
}
