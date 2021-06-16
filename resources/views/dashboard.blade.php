@extends('layouts.app')

@section('content')

<div class="container">
    <div class="d-flex justify-content-between">
        <a type="button" href="{{ route('create-post') }}" class=" btn btn-light">{{ __('Create new post')}}</a>
        <!-- Search form -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('search') }}" class="form-inline d-flex justify-content-center md-form form-sm">
            @csrf
            <input name="search" class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Search" required aria-label="Search">
            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>

    <ul class="timeline">
        @foreach ($post['posts'] as $postOnly)
        <li>
            <!-- begin timeline-time -->
            <div class="timeline-time">
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

                    </div>
                    <div class="stats">
                        <span class="fa-stack fa-fw stats-icon">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa fa-thumbs-up fa-stack-1x fa-inverse"></i>
                        </span>
                        @if (array_key_exists('likes', $post))
                        @foreach ($post['likes'] as $likeOnly)
                        @if ($likeOnly->id == $postOnly->id && $likeOnly->likes > 0)
                        <span class="stats-total">{{$likeOnly->likes}}</span>
                        @endif
                        @endforeach
                        @else
                        <span class="stats-total">0</span>
                        @endif
                    </div>
                </div>
                <div class="timeline-footer">
                    <form action="POST"></form>
                    <a href="{{ route('like.show', $postOnly->id) }}" class="m-r-15 text-inverse-lighter"><i class="fa fa-thumbs-up fa-fw fa-lg m-r-3" value="{{$postOnly->id}}"></i> Like</a>
                    <a href="{{ route('comment.show', $postOnly->id) }}" class="m-r-15 text-inverse-lighter"><i class="fa fa-comments fa-fw fa-lg m-r-3"></i>{{$postOnly->comments}} Comments</a>
                </div>
                <div class="timeline-comment-box">
                    <div class="user">
                        @if (auth()->user()->photo_name !== null)
                        <span class="userimage"><img src="{{asset('/storage/images/users/'.auth()->user()->photo_name)}}" alt=""></span>
                        @elseif( auth()->user()->photo_name == null)
                        <i class="fa fa-user fa-5x" style="font-size:50px;" aria-hidden="true"></i>
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
                                <input type="text" name="comment" required class="form-control rounded-corner" placeholder="Write a comment...">
                                <input type="hidden" name="post_id" value="{{$postOnly->id}}">
                                <input type="hidden" name="type" value="dashboard">
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
        <li>
            <!-- begin timeline-icon -->
            <div class="timeline-icon">
                <a href="javascript:;">&nbsp;</a>
            </div>
            <!-- end timeline-icon -->
            <!-- begin timeline-body -->
            <div class="timeline-body">
                Loading...
            </div>
            <!-- begin timeline-body -->
        </li>
    </ul>
</div>
@endsection