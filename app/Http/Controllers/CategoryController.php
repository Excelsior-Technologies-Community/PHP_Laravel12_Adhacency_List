<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $categories = $query->whereNull('parent_id')->with('children')->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        return redirect('/categories')->with('success', 'Category Added Successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        
        $breadcrumbs = $category->ancestorsAndSelf()->pluck('name')->implode(' > ');
        
        $categories = Category::where('id', '!=', $id)->get(); 

        return view('categories.edit', compact('category', 'categories', 'breadcrumbs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $category = Category::findOrFail($id);

        if ($request->parent_id) {
            $descendants = $category->descendants()->pluck('id')->toArray();
            if (in_array($request->parent_id, $descendants) || $id == $request->parent_id) {
                return back()->with('error', 'Invalid move: cannot move into its own sub-category!');
            }
        }

        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        return redirect('/categories')->with('success', 'Category Updated Successfully!');
    }

    public function move(Request $request)
    {
        $category = Category::findOrFail($request->id);
        
        if ($request->parent_id) {
            $descendants = $category->descendants()->pluck('id')->toArray();
            if (in_array($request->parent_id, $descendants) || $category->id == $request->parent_id) {
                return response()->json(['success' => false, 'message' => 'Invalid Move']);
            }
        }

        $category->parent_id = $request->parent_id;
        $category->save();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return back()->with('success', 'Category Moved to Trash!');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->get();

        return view('categories.trash', compact('categories'));
    }

    public function restore($id)
    {
        Category::withTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Category Restored Successfully!');
    }

    public function toggle($id)
    {
        $cat = Category::findOrFail($id);

        $cat->status = !$cat->status;
        $cat->save();

        return back()->with('success', 'Status Updated Successfully!');
    }
}