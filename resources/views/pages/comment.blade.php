@extends('layouts.app')

@section('content')

<div class="container">
    <ul class="timeline">
        @foreach ($post['post'] as $postOnly)
        @if ($postOnly->user_id == auth()->id())
        <a type="button" href="{{ route('post.show', $postOnly->id) }}" class="mb-2 btn btn-light">{{ __('Edit post')}}</a>
        <form method="POST" action="{{ route('post.destroy', $postOnly->id) }}">
            @method('DELETE')
            @csrf
            <button type="submit" class=" btn btn-light">{{ __('Delete')}}</button>
        </form>
        @endif
        <li>
            <!-- begin timeline-time -->

            <div class="timeline-time">
                <span class="date">today</span>
                <span class="time">{{$postOnly->created_at->format('Y-m-d h:i')}}</span>
            </div>
            <!-- end timeline-time -->
            <!-- begin timeline-icon -->
            <div class="timeline-icon">
                <a href="javascript:;">&nbsp;</a>
            </div>
            <!-- end timeline-icon -->
            <!-- begin timeline-body -->
            <div class="timeline-body">
                <div class="timeline-header">
                    @if ($postOnly->photo !== null)
                    <span class="userimage"><img src="{{asset('/storage/images/users/'.$postOnly->photo)}}" alt=""></span>
                    @elseif( $postOnly->photo == null)
                    <i class="fa fa-user fa-5x" style="font-size:50px;" aria-hidden="true"></i>
                    @endif
                    <span class="username"><a href="javascript:;">{{$postOnly->name}}</a> <small></small></span>
                </div>


                <div class="timeline-content">
                    <p>
                        {{$postOnly->post_text}}
                    </p>
                    <p class="m-t-20">
                        <img src="{{asset('/storage/images/posts/'.$postOnly->image_name)}}" alt="">
                    </p>
                </div>
                <div class="timeline-likes">
                    <div class="stats-right">

                        <span class="stats-text">{{$post['commentsCount']}} Comments</span>

                    </div>
                    <div class="stats">
                        <span class="fa-stack fa-fw stats-icon">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa fa-thumbs-up fa-stack-1x fa-inverse"></i>
                        </span>

                        <span class="stats-total">{{$post['postLikes']}}</span>

                    </div>
                </div>
                <div class="timeline-footer">
                    @if (array_key_exists('userLiked', $post))
                    @foreach ($post['userLiked'] as $userLike)
                    @if ($userLike->count() > 0)
                    <a href="{{ route('like.show', $postOnly->id) }}" class="m-r-15 text-inverse-lighter"><i class="fa fa-thumbs-up fa-fw fa-lg m-r-3"></i> Dislike</a>
                    @elseif( $userLike->like == false || $userLike->count() == 0 )
                    <a href="{{ route('like.show', $postOnly->id) }}" class="m-r-15 text-inverse-lighter"><i class="fa fa-thumbs-up fa-fw fa-lg m-r-3"></i> Like</a>
                    @endif
                    @endforeach
                    @elseif(!array_key_exists('userLiked', $post))
                    <a href="{{ route('like.show', $postOnly->id) }}" class="m-r-15 text-inverse-lighter"><i class="fa fa-thumbs-up fa-fw fa-lg m-r-3"></i> Like</a>
                    @endif
                </div>
                <div class="timeline-comment-box">

                    <div class="user">
                        @if (auth()->user()->photo_name !== null)
                        <span class="userimage"><img src="{{asset('/storage/images/users/'.auth()->user()->photo_name)}}" alt=""></span>
                        @elseif( auth()->user()->photo_name == null)
                        <i class="fa fa-user fa-5x" style="font-size:40px;" aria-hidden="true"></i>
                        @endif
                    </div>
                    <div class="input">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form method="POST" action="{{ route('comment.store') }}">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="comment" class="form-control rounded-corner" required placeholder="Write a comment...">
                                <input type="hidden" name="post_id" value="{{$postOnly->id}}">
                                <input type="hidden" name="type" value="pages.comment">
                                <span class="input-group-btn p-l-10">
                                    <button type="submit" class="btn btn-primary f-s-12 rounded-corner">{{ __('Comment')}}</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end timeline-body -->
        </li>
        @endforeach
        @foreach ($post['comments'] as $comment)
        <li>
            <!-- begin timeline-icon -->
            <!-- <div class="timeline-icon">
                <a href="javascript:;">&nbsp;</a>
            </div> -->
            <!-- end timeline-icon -->
            <!-- begin timeline-body -->
            <div class="timeline-body">
                <div class="timeline-header">
                    @if ($comment->photo !== null)
                    <span class="userimage"><img src="{{asset('/storage/images/users/'.$comment->photo)}}" alt=""></span>
                    @elseif( $comment->photo == null)
                    <i class="fa fa-user fa-5x" style="font-size:50px;" aria-hidden="true"></i>
                    @endif

                    <span class="username"><a href="javascript:;">{{$comment->name}}</a> <small></small></span>
                </div>


                <div class="timeline-content">
                    <p>
                        {{$comment->post_text}}
                    </p>
                </div>
            </div>
            <!-- begin timeline-body -->
        </li>
        @endforeach
    </ul>
</div>

@endsection