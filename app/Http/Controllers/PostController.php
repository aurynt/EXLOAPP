<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        $category = Category::all();
        $data = [
            'category' => $category,
            'posts' => $posts
        ];
        return view('post', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|max:50',
            'description' => 'required',
            'photo' => 'required|file|mimes:jpeg,png,jpg,avif',
            'category' => 'required',
        ]);

        $file = $request->file('photo');
        if ($file !== null) {
            $name = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/post/', $name);
        }
        $post = new Post();

        $post->username = $request->username;
        $post->description = $request->description;
        $post->foto = $name;
        $post->coordinat = $request->coordinat;
        $post->radius = $request->radius;
        $post->type = $request->type;
        $post->category = $request->category;

        $res = $post->save();

        if ($res) {
            return redirect('/');
        }
        return redirect()->back()->withInput();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $posts = Post::find($id);
        $category = Category::all();
        $data = [
            'category' => $category,
            'posts' => $posts
        ];
        return view('edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|max:50',
            'description' => 'required',
            'category' => 'required',
        ]);

        $file = $request->file('photo');
        $id = $request->id;
        $post = Post::find($id);

        if ($file) {
            Storage::delete('public/post/' . $post->foto);
            $name = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('storage/post/', $name);
        }

        $post->username = $request->username;
        $post->description = $request->description;
        $post->foto = $file !== null ? $name : $post->foto;
        $post->coordinat = $request->coordinat;
        $post->radius = $request->radius;
        $post->type = $request->type;
        $post->category = $request->category;

        $res = $post->save();

        if ($res) {
            return redirect()->back();
        }
        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Request $request)
    {
        $post = Post::find($request->id);
        Storage::delete('public/post/' . $post->foto);
        $res = $post->delete();
        if ($res) {
            return redirect()->back();
        }
        return redirect()->back();
    }
}
