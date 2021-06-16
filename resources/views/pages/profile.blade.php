@extends('layouts.app')

@section('content')

<!------ Include the above in your HEAD tag ---------->

<div class="container emp-profile">
    <form method="post">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                    @if (auth()->user()->photo_name !== null)
                    <span class="userimage"><img style="width: 120px;" src="{{asset('/storage/images/users/'.auth()->user()->photo_name)}}" alt=""></span>
                    @elseif( auth()->user()->photo_name == null)
                    <i class="fa fa-user fa-5x" style="font-size:120px;" aria-hidden="true"></i>
                    @endif



                    <div class="col mt-2">
                        <a type="submit" class="profile-edit-btn btn btn-light" name="btnAddMore" href="{{ route('edit-profile') }}">
                            {{ __('Edit Profile') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="profile-head">
                    <h5>
                        {{ auth()->user()->name }}
                    </h5>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
        <div class="row justify-content-end">

            <div class="col-md-8 ">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>User Id</label>
                            </div>
                            <div class="col-md-6">
                                <p>{{ auth()->user()->id }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Name</label>
                            </div>
                            <div class="col-md-6">
                                <p>{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Email</label>
                            </div>
                            <div class="col-md-6">
                                <p>{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

@endsection