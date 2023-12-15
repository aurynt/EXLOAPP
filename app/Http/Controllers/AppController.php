<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = $request->query('search') ? Post::with('categories')->where('category', $request->query('search'))->get() : Post::with('categories')->get();
        $category = Category::all();
        $data = [
            'category' => $category,
            'posts' => $posts,
            'query' => $request->query('search') ?? null
        ];
        return view('home', $data);
    }
    public function location()
    {
        $posts = Post::with('categories')->get();
        $data = [
            'posts' => $posts,
        ];
        return view('location', $data);
    }

    public function search(Request $request)
    {
        $posts = Post::with('categories')->where('category', $request->search)->get();
        return redirect()->to('/')->with('results', $posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function profile($username)
    {
        $posts = Post::with('categories')->where('username', $username)->get();
        $category = Category::all();
        $data = [
            'posts' => $posts,
            'category' => $category,
        ];
        return view('profile', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function account($username)
    {
        $posts = Post::where('username', $username)->get();
        $category = Category::all();
        $data = [
            'category' => $category,
            'posts' => $posts
        ];
        return view('account', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
