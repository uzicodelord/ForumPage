<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Category $category)
    {
        $posts = $category->posts()->orderBy('created_at', 'desc')->paginate(10);
        $category->name = ucwords(str_replace('-', ' ', $category->name));
        return view('categories.index',compact('posts','category') );
    }

}
