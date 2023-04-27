<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index(Request $request)
    {
        $query = $request->input('q');
        $posts = Post::where('title', 'LIKE', "%$query%")
            ->orWhere('content', 'LIKE', "%$query%")
            ->get();
        $categories = Category::where('name', 'LIKE', "%$query%")->get();
        foreach ($categories as $category) {
            $category->name = ucwords(str_replace('-', ' ', $category->name));
        }
        $users = User::where('name', 'LIKE', "%$query%")->get();

        $results = [
            'posts' => $posts,
            'categories' => $categories,
            'users' => $users,
        ];

        return response()->json($results);
    }

}
