<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
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
    public function create(Request $request)
    {
        $request->validate([
            'username' => 'required|max:50|lowercase',
            'description' => 'required',
            'photo' => 'required|file|mimes:jpeg,png,jpg,avif',
            'category' => 'required',
            'type' => 'required'
        ], [
            'type' => [
                'required' => 'The location field is required.'
            ]
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

        try {
            $res = $post->save();
            return $res;
        } catch (\Throwable $err) {
            return $err;
        }
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
    public function show(Post $post, $condition, $value)
    {
        $posts = $condition == 'id' ? $post->find($value) : $post->where($condition, $value)->get();
        return $posts;
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
            'username' => 'required|max:50|lowercase',
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

        try {
            $res = $post->save();
            if ($res) {
                return [
                    'data' => $post->find($id),
                    'res' => $res,
                ];
            }
        } catch (\Throwable $err) {
            return $err;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $post = Post::find($request->id);
            Storage::delete('public/post/' . $post->foto);
            $res = $post->delete();
            return $res;
        } catch (\Throwable $err) {
            throw $err;
        }
    }
}
