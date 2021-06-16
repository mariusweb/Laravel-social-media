<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
                ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
                ->select(
                    'posts.id',
                    'posts.post_text',
                    'posts.image_name',
                    'posts.created_at',
                    'users.name as name',
                    'users.photo_name as photo',
                    Comment::raw("count(comments.id) as comments"),
                )
                ->groupBy('posts.id')
                ->orderBy('posts.created_at', 'desc')
                ->get(),
            'likes' => Post::leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                ->where('likes.like', '=', true)
                ->select(
                    'posts.id',
                    'posts.user_id',
                    Like::raw("COUNT(likes.id) as likes"),
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
        $editPost = Post::select('posts.id', 'posts.post_text', 'posts.image_name')
            ->where('posts.id', '=', $id)
            ->get();
        return view('pages.edit-post', ['post' => $editPost]);
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
        $request->validate([
            'post_text' => 'required|string',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $save = Post::find($id);
        if ($request->hasfile('image')) {
            $name = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('public/images/posts', $name);
            $save->image_name = $name;
            $save->image = $path;
        }

        $save->user_id = $request->user()->id;
        $save->post_text = $request->post_text;
        $save->save();


        $postWithComments = [
            'post' => Post::leftJoin('users', 'posts.user_id', '=', 'users.id')
                ->select(
                    'posts.id',
                    'posts.post_text',
                    'posts.user_id',
                    'posts.image_name',
                    'posts.created_at',
                    'users.name as name',
                    'users.photo_name as photo',
                )->where('posts.id', $id)
                ->get(),
            'postLikes' => Like::where('likes.post_id', $id)->where('likes.like', '=', true)->count(),
            'comments' => Comment::leftJoin('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.post_text', 'users.name as name', 'users.photo_name as photo')
                ->where('comments.post_id', $id)
                ->orderBy('comments.created_at', 'desc')
                ->get(),
            'commentsCount' => Comment::where('comments.post_id', $id)
                ->count(),

        ];

        return view('pages.comment', ['post' => $postWithComments]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $commets = Comment::where('comments.post_id', '=', $id)->get();
        // $commets->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

        // $likes = Like::where('likes.post_id', '=', $id)->get();
        // $likes->foreign('likes.post_id')->references('id')->on('posts')->onDelete('cascade');


        $table = Post::find($id);

        if (Storage::exists('images/posts' . $table->image_name)) {
            // unlink(storage_path('images/posts'.$table->image_name));
            Storage::delete('images/posts' . $table->image_name);
        }


        // $table->foreignId('post_id')->constrained()->onDelete('cascade');
        Post::destroy($id);

        $allPosts = [
            'posts' => Post::leftJoin('users', 'posts.user_id', '=', 'users.id')
                ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
                ->select(
                    'posts.id',
                    'posts.post_text',
                    'posts.image_name',
                    'posts.created_at',
                    'users.name as name',
                    'users.photo_name as photo',
                    Comment::raw("count(comments.id) as comments"),
                )
                ->groupBy('posts.id')
                ->orderBy('posts.created_at', 'desc')
                ->get(),
            'likes' => Post::leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                ->where('likes.like', '=', true)
                ->select(
                    'posts.id',
                    'posts.user_id',
                    Like::raw("COUNT(likes.id) as likes"),
                )
                ->groupBy('posts.id')
                ->get(),
        ];
        return view('dashboard', ['post' => $allPosts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);
        $searchKey = $request->get('search');
        $allPosts = [
            'posts' => Post::leftJoin('users', 'posts.user_id', '=', 'users.id')
                ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
                ->select(
                    'posts.id',
                    'posts.post_text',
                    'posts.image_name',
                    'posts.created_at',
                    'users.name as name',
                    'users.photo_name as photo',
                    Comment::raw("count(comments.id) as comments"),
                )
                ->groupBy('posts.id')
                ->orderBy('posts.created_at', 'desc')
                ->orWhere(
                    function ($queryName) use ($searchKey) {
                        $queryName->where('users.name', 'LIKE', '%' . $searchKey . '%');
                    }
                )->orWhere(
                    function ($queryLink) use ($searchKey) {
                        $queryLink->where('posts.post_text', 'LIKE', '%' . $searchKey . '%');
                    }
                )->get(),
            'likes' => Post::leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                ->where('likes.like', '=', true)
                // ->where('posts.id', '=', 'likes.post_id')
                ->select(
                    'posts.id',
                    'posts.user_id',
                    Like::raw("COUNT(likes.id) as likes"),
                )
                ->groupBy('posts.id')
                ->get(),

        ];
        return view('dashboard', ['post' => $allPosts]);
    }
}
