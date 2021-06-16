<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $likeData = Like::where('likes.user_id', '=', auth()->id())
            ->where('likes.post_id', '=', $id)
            ->get();

        if ($likeData->isEmpty()) {
            $create = new Like;
            $create->user_id = auth()->id();
            $create->post_id = $id;
            $create->like = true;
            $create->save();
        } elseif (!$likeData->isEmpty()) {
            $hasFalse = Like::where('likes.user_id', '=', auth()->id())
                ->where('likes.post_id', '=', $id)
                ->where('likes.like', '=', true)
                ->get();
            if ($hasFalse->isEmpty()) {
                Like::where('likes.user_id', '=', auth()->id())
                    ->where('likes.post_id', '=', $id)
                    ->update(['like' => true]);
            } elseif (!$hasFalse->isEmpty()) {
                Like::where('likes.user_id', '=', auth()->id())
                    ->where('likes.post_id', '=', $id)
                    ->update(['like' => false]);
            }
        }

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
