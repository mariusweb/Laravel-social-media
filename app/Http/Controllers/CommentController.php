<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class CommentController extends Controller
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
        $request->validate([
            'comment' => 'required|string',
            'post_id' => 'required|integer',
        ]);
        $newComment = new Comment;
        $newComment->post_id = $request->post_id;
        $newComment->post_text = $request->comment;
        $newComment->user_id = $request->user()->id;
        $newComment->save();

        $postWithComments = [
            'post' => Post::leftJoin('users', 'posts.user_id', '=', 'users.id')
                ->select(
                    'posts.id',
                    'posts.post_text',
                    'posts.image_name',
                    'posts.created_at',
                    'users.name as name',
                    'users.photo_name as photo',
                )->where('posts.id', $request->post_id)
                ->get(),
            'postLikes' => Like::where('post_id', $request->post_id)->count(),
            'comments' => Comment::leftJoin('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.post_text', 'users.name as name', 'users.photo_name as photo')
                ->where('comments.post_id', $request->post_id)
                ->get(),
            'commentsCount' => Comment::where('comments.post_id', $request->post_id)
                ->count(),
        ];

        return view('pages.comment', ['post' => $postWithComments]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $postWithComments = [
            'post' => Post::leftJoin('users', 'posts.user_id', '=', 'users.id')
                ->select(
                    'posts.id',
                    'posts.post_text',
                    'posts.image_name',
                    'posts.created_at',
                    'users.name as name',
                    'users.photo_name as photo',
                )->where('posts.id', $id)
                ->get(),
            'postLikes' => Like::where('post_id', $id)->count(),
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
