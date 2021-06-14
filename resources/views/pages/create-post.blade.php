@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create A Post') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="post_text" class="col-md-4 col-form-label text-md-right">{{ __('Post text: ') }}</label>

                            <div class="col-md-6">
                                <textarea id="post_text" row="5" col="200" class="form-control @error('name') is-invalid @enderror" name="post_text" required autofocus>
                                </textarea>


                            </div>
                        </div>

                        <div class="row py-4">
                            <div class="col-lg-6 mx-auto">
                                <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                    <input id="upload" type="file" onchange="readURL(this);" class="form-control border-0" name="image">
                                    <label id="upload-label" for="image" class="font-weight-light text-muted">{{ __('Add a photo')}}</label>
                                    <div class="input-group-append">
                                        <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">{{ __('Choose file') }}</small></label>
                                    </div>
                                </div>

                                <!-- Uploaded image area-->
                                <p class="font-italic text-white text-center">{{ __('The image uploaded will be rendered inside the box below.') }}</p>
                                <div class="image-area mt-4"><img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"></div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" href="{{ route('dashboard') }}">
                                    {{ __('Make a post') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class=" container py-5"> -->

<!-- For demo purpose -->
<!-- <header class="text-white text-center">
        <h1 class="display-4">Bootstrap image upload</h1>
        <p class="lead mb-0">Build a simple image upload button using Bootstrap 4.</p>
        <p class="mb-5 font-weight-light">Snippet by
            <a href="https://bootstrapious.com" class="text-white">
                <u>Bootstrapious</u>
            </a>
        </p>
        <img src="https://res.cloudinary.com/mhmd/image/upload/v1564991372/image_pxlho1.svg" alt="" width="150" class="mb-4">
    </header> -->


<!-- <div class="row py-4">
        <div class="col-lg-6 mx-auto"> -->

<!-- Upload image input -->
<!-- <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                <input id="upload" type="file" onchange="readURL(this);" class="form-control border-0">
                <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose file</label>
                <div class="input-group-append">
                    <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                </div>
            </div> -->

<!-- Uploaded image area-->
<!-- <p class="font-italic text-white text-center">The image uploaded will be rendered inside the box below.</p>
            <div class="image-area mt-4"><img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"></div>

        </div>
    </div> -->
<!-- </div> -->

@endsection