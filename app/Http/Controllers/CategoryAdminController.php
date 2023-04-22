<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function create()
    {
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);

        $category = new Category();
        $category->name = str_replace(' ', '-', strtolower($request->input('name')));
        $category->save();

        return redirect()->back()->with('success', 'Category created successfully.');
    }
}
