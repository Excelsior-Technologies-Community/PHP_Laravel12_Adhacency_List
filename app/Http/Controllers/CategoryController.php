<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Show tree + search
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $categories = $query->whereNull('parent_id')->with('children')->get();

        return view('categories.index', compact('categories'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }

    // Store
    public function store(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        return redirect('/categories')
            ->with('success', '✅ Category Added Successfully!');
    }

    // Delete (Soft Delete)
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return back()->with('success', '🗑 Category Moved to Trash!');
    }

    // Trash list
    public function trash()
    {
        $categories = Category::onlyTrashed()->get();

        return view('categories.trash', compact('categories'));
    }

    // Restore
    public function restore($id)
    {
        Category::withTrashed()->findOrFail($id)->restore();

        return back()->with('success', '♻️ Category Restored Successfully!');
    }

    // Toggle status
    public function toggle($id)
    {
        $cat = Category::findOrFail($id);

        $cat->status = !$cat->status;
        $cat->save();

        return back()->with('success', '🔄 Status Updated Successfully!');
    }
}