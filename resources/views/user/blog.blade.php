@extends('user.layouts.master')

@section('main')
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Blog</h1>
                        <p class="mb-4">Explore our latest updates, tips, and inspirations on calligraphy and decor. Stay
                            inspired with creative ideas for your special moments!</p>
                        <p><a href="" class="btn btn-secondary me-2">Shop Now</a><a href="#"
                                class="btn btn-white-outline">Explore</a></p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="hero-img-wrap">
                        <img src="{{ asset('user/images/couch.png') }}" style="width:80%; margin-left:75px;"
                            class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <!-- Start Blog Section -->
    <div class="blog-section  ">
        <div class="container">

            <div class="row">
                <script>
                    let images, container, basePath, img;
                </script>

                @foreach ($blogs as $b)
                    <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 mt-3">
                        <div class="post-entry card p-3 rounded-3">
                            <a href="#" class="post-thumbnail">
                                <!-- Unique ID for each image container -->
                                <div class="d-flex flex-wrap" id="imageContainer-{{ $b->id }}"></div>

                                <script>
                                    if ({{ $b->id }}) {
                                        images = {!! json_encode($b->image) !!};
                                        images = JSON.parse(images);

                                        container = document.getElementById("imageContainer-{{ $b->id }}");

                                        basePath = "{{ asset('blogs') }}/";

                                        for (let i = 0; i < images.length; i++) {
                                            img = document.createElement("img");
                                            img.style.width = "45%";
                                            img.style.aspectRatio = "1 / 1";
                                            img.style.margin = "2px";
                                            img.src = basePath + images[i];
                                            container.appendChild(img);
                                        }
                                    }
                                </script>
                            </a>
                            <div card-body class="post-content-entry p-3">
                                <div class="d-flex justify-content-end my-2">
                                    <form action="{{ route('createFavourite') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="blog_id" value="{{ $b->id }}">
                                        <button type="submit" style="background-color: transparent; border:none;">
                                            <i data-feather="heart" class="me-2"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('createSave') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="blog_id" value="{{ $b->id }}">
                                        <button type="submit" style="background-color: transparent; border:none;">
                                            <i data-feather="save" class="me-2"></i>
                                        </button>
                                    </form>
                                </div>
                                <h2><a href="#">{{ $b->title }}</a></h2>
                                <p class="card-text">
                                    {{ Str::words($b->text, 10, '...') }}
                                    <a href="{{ route('blogDetails', $b->id) }}" style="text-decoration: underline">Read More</a>
                                </p>
                                <div class="meta">
                                    <span>by <a href="#">{{ $b->author_name }}</a></span>
                                    <span>on <a href="#">{{ $b->updated_at->format('M d, Y') }}</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    <!-- End Blog Section -->
@endsection
