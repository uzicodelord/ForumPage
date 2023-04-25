<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all();
        $messages = Message::with('user')->orderBy('created_at', 'asc')->get();
        $upvotedpost = Post::orderBy('upvotes', 'desc')->first();

        $categoryIcons = [
            'General Discussion' => 'fa fa-comments',
            'Announcements' => 'fa fa-bullhorn',
            'Applications Rank & Awards' => 'fa fa-trophy',
            'Technical Support' => 'fa fa-wrench',
        ];

        foreach ($categories as $category) {
            $category->name = ucwords(str_replace('-', ' ', $category->name));
        }

        $specialCategories = $categories->whereIn('name', array_keys($categoryIcons));
        $categories = $categories->whereNotIn('name', array_keys($categoryIcons));

        return view('forum.index', compact('posts', 'categories', 'specialCategories', 'messages', 'upvotedpost', 'categoryIcons'));
    }







    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = auth()->user()->id;
        $post->category_id = $request->input('category_id');
        $post->save();

        return redirect()->route('forum.index');
    }
}
