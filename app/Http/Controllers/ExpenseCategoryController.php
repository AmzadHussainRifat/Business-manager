<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('settings.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:expense_categories,name',
        ]);

        if (strtolower($validated['name']) === 'other') {
            return back()->withErrors(['name' => '"Other" is a built-in option and cannot be added.']);
        }

        ExpenseCategory::create($validated);

        return redirect()->route('settings.categories.index')->with('success', 'Category added.');
    }

    public function destroy(ExpenseCategory $category)
    {
        $category->delete();
        return redirect()->route('settings.categories.index')->with('success', 'Category removed.');
    }
}