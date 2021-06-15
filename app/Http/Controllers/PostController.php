<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allPosts = [
            'posts' => Post::leftJoin('users', 'posts.user_id', '=', 'users.id')
                ->leftJoin('likes', 'posts.id', '=', 'likes.id')
                ->leftJoin('comments', 'posts.user_id', '=', 'users.id')
                ->select(
                    'posts.id',
                    'posts.post_text',
                    'posts.image_name',
                    'posts.created_at',
                    'users.name as name',
                    'users.photo_name as photo',
                    DB::raw("count(likes.id) as likes"),
                    DB::raw("count(comments.id) as comments"),
                )
                ->groupBy('posts.id')
                ->get(),
        ];
        return view('dashboard', ['post' => $allPosts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'post_text' => 'required|string',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $save = new Post;
        if ($request->hasfile('image')) {
            $name = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('public/images/posts', $name);
            $save->image_name = $name;
            $save->image = $path;
        }

        $save->user_id = $request->user()->id;
        $save->post_text = $request->post_text;
        $save->save();
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
