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
    <div class="blog-section">
        <div class="container">

            <div class="row">
                @foreach ($blogs as $b)
                    <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
                        <div class="post-entry card p-3 rounded-3">
                            <a href="#" class="post-thumbnail">
                                <div class="d-flex flex-wrap" id="imageContainer">

                                </div>

                                <script>
                                    let images = {!! json_encode($b->image) !!};
                                    images = JSON.parse(images);

                                    // Assuming there's a container div in your HTML with the ID "imageContainer"
                                    const container = document.getElementById("imageContainer");

                                    // Set the base path for images using Laravel's asset function
                                    const basePath = "{{ asset('blogs') }}/";

                                    for (let i = 0; i < images.length; i++) {
                                        console.log(images[i]);

                                        let img = document.createElement("img");
                                        img.style.width = "45%"
                                        img.style.aspectRatio = "1 / 1";
                                        img.style.margin = "2px"
                                        img.src = basePath + images[i]; // Concatenate base path with the image name
                                        container.appendChild(img);
                                    }
                                </script>

                            </a>
                            <div card-body class="post-content-entry p-3">
                                <div class="d-flex justiy-content-end bg-danger  my-2">
                                   <form action="{{route('createFavourite')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="blog_id" value="{{$b -> id}}">
                                    <button type="submit"  style="background-color: transparent; border:none;"> <i data-feather="heart" class="me-2"></i></button>
                                   </form>
                                   <form action="{{route('createSave')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="blog_id" value="{{$b -> id}}">
                                    <button type="submit" style="background-color: transparent; border:none;"> <i data-feather="save" class="me-2"></i></button>
                                   </form>


                                </div>
                                <h2><a href="#">{{ $b->title }}</a></h2>
                                <p class="card-text">
                                    {{ Str::words($b->text, 10, '...') }}
                                    <a href="{{ route('blogDetails', $b->id) }}" style="text-decoration: underline">Read
                                        More</a>
                                </p>
                                <div class="meta">
                                    <span>by <a href="#">{{ $b->author_name }}</a></span> <span>on <a
                                            href="#">{{ $b->updated_at->format('M d, Y') }}</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- End Blog Section -->

    <!-- Start Testimonial Slider -->
    <div class="testimonial-section before-footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto text-center">
                    <h2 class="section-title">Testimonials</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="testimonial-slider-wrap text-center">

                        <div id="testimonial-nav">
                            <span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
                            <span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
                        </div>

                        <div class="testimonial-slider">

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio
                                                    quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate
                                                    velit imperdiet dolor tempor tristique. Pellentesque habitant morbi
                                                    tristique senectus et netus et malesuada fames ac turpis egestas.
                                                    Integer convallis volutpat dui quis scelerisque.&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="{{ asset('user/images/person-1.png') }}" alt="Maria Jones"
                                                        class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Maria Jones</h3>
                                                <span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio
                                                    quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate
                                                    velit imperdiet dolor tempor tristique. Pellentesque habitant morbi
                                                    tristique senectus et netus et malesuada fames ac turpis egestas.
                                                    Integer convallis volutpat dui quis scelerisque.&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="{{ asset('user/images/person-1.png') }}" alt="Maria Jones"
                                                        class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Maria Jones</h3>
                                                <span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio
                                                    quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate
                                                    velit imperdiet dolor tempor tristique. Pellentesque habitant morbi
                                                    tristique senectus et netus et malesuada fames ac turpis egestas.
                                                    Integer convallis volutpat dui quis scelerisque.&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="{{ asset('user/images/person-1.png') }}" alt="Maria Jones"
                                                        class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Maria Jones</h3>
                                                <span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonial Slider -->
@endsection
