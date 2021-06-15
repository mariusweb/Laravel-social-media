@extends('layouts.app')

@section('content')

<div class="container">
    <a type="button" href="{{ route('create-post') }}" class=" btn btn-light">{{ __('Create new post')}}</a>
    <ul class="timeline">
        @foreach ($post['posts'] as $postOnly)
        <li>
            <!-- begin timeline-time -->
            <div class="timeline-time">
                <span class="date">today</span>
                <span class="time">{{$postOnly->created_at}}</span>
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
                    <span class="userimage"><img src="{{asset('/storage/images/users/'.$postOnly->photo)}}" alt=""></span>
                    <span class="username"><a href="javascript:;">{{$postOnly->name}}</a> <small></small></span>
                </div>


                <div class="timeline-content">
                    <p>
                        {{$postOnly->post_text}}
                    </p>
                    <p class="m-t-20">
                        <img src="{{asset('/storage/images/users/'.$postOnly->image_name)}}" alt="">
                    </p>
                </div>
                <div class="timeline-likes">
                    <div class="stats-right">
                        <span class="stats-text">21 Comments</span>
                    </div>
                    <div class="stats">
                        <span class="fa-stack fa-fw stats-icon">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa fa-thumbs-up fa-stack-1x fa-inverse"></i>
                        </span>
                        <span class="stats-total">4.3k</span>
                    </div>
                </div>
                <div class="timeline-footer">
                    <a href="javascript:;" class="m-r-15 text-inverse-lighter"><i class="fa fa-thumbs-up fa-fw fa-lg m-r-3"></i> Like</a>
                    <a href="{{ route('comment.show', 1) }}" class="m-r-15 text-inverse-lighter"><i class="fa fa-comments fa-fw fa-lg m-r-3"></i> Comment</a>
                    <a href="javascript:;" class="m-r-15 text-inverse-lighter"><i class="fa fa-share fa-fw fa-lg m-r-3"></i> Share</a>
                </div>
                <div class="timeline-comment-box">
                    <div class="user"><img src="https://bootdey.com/img/Content/avatar/avatar6.png"></div>
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
                                <input type="text" name="comment" class="form-control rounded-corner" placeholder="Write a comment...">
                                <input type="hidden" name="post_id" value="1">
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