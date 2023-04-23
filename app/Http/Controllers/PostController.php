<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', ['categories' => $categories]);
    }


    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->user_id = auth()->user()->id;
        $post->category_id = $request->category_id;
        $post->save();
        $user = User::find(Auth::user()->id);
        $user->points += 10;
        $user->updateRank();
        $user->save();
        return redirect()->route('forum.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if (!session()->has('viewed_post_' . $post->id)) {
            $post->increment('views_count');
            session()->put('viewed_post_' . $post->id, true);
        }
        $replies = $post->replies()->orderBy('created_at', 'asc')->paginate(10);
        return view('posts.show', compact('post', 'replies'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            return redirect()->route('posts.show', $post)->with('error', 'You do not have permission to edit this post.');
        }

        return view('posts.edit', compact('post'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            return redirect()->route('posts.show', $post)->with('error', 'You do not have permission to edit this post.');
        }

        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();

        return redirect()->route('posts.show', $post);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Check if the authenticated user is the owner of the post
        if(auth()->user()->id !== $post->user_id) {
            return redirect()->back()->with('error', 'You are not authorized to delete this post.');
        }

        // Delete the post
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function vote(Post $post, Request $request)
    {
        $key = 'voted_posts.'.$post->id;

        if ($request->session()->has($key)) {
            return redirect()->back()->with('error', 'You have already voted on this post.');
        }

        if ($request->input('vote') === 'upvote') {
            $post->increment('upvotes');
        } else if ($request->input('vote') === 'downvote') {
            $post->increment('downvotes');
        }

        $request->session()->put($key, true);

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $posts = Post::where('title', 'like', "%$query%")
            ->orWhere('content', 'like', "%$query%")
            ->get();

        return view('posts.search', compact('posts', 'query'));
    }



}
