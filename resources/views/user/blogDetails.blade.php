@extends('user.layouts.master')

@section('main')
    <style>
        #imageContainer {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        #imageContainer img:first-child {
            grid-column: span 3;
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        #imageContainer .small-image {
            grid-column: auto;
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .shrink-row {
            grid-column: span 3;
            display: flex;
            gap: 15px;
            justify-content: space-between;
        }

        .shrink-row img {
            flex: 1;
            max-width: calc(33.333% - 10px);
            height: auto;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
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
                <div class="col-md-6">
                    <div id="imageContainer"></div>
                </div>
                <div class="col-md-6 card p-3">
                    <h1>{{ $blog->title }}</h1>
                    <small><strong>by {{ $blog->author_name }}</strong></small>
                    <div class="row">
                        <div class="col-6">
                            {{ $blog->updated_at->format('F d, Y (D)') }}
                        </div>
                        <div class="col-6 text-end my-2">
                            <form action="{{ route('createFavourite') }}" method="post">
                                @csrf
                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                <button type="submit" style="background-color: transparent; border:none;">
                                    <i data-feather="heart" class="me-2"></i>
                                </button>
                            </form>
                            <form action="{{ route('createSave') }}" method="post">
                                @csrf
                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                <button type="submit" style="background-color: transparent; border:none;">
                                    <i data-feather="save" class="me-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <p>{{ $blog->text }}</p>

                    <div class="row">
                        <form action="{{ route('createComment') }}" method="POST">
                            @csrf
                            <div class="col d-flex px-2">
                                <input type="hidden" value="{{ $blog->id }}" name="blog_id">
                                <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                                <input type="text" name="comment" class="form-control me-2" placeholder="Add Comment">
                                <button type="submit" class="btn btn-warning"><i data-feather="send"></i></button>
                            </div>
                        </form>
                    </div>

                    <div class="row p-2">
                        <h5>Comments</h3>
                            <hr>
                            <div class="col">
                                @foreach ($comments as $c)
                                    <div class="card p-3 mt-3">
                                        <div class="card p-3 me-5">
                                            <div class="row pb-3">
                                                <div class="col">
                                                    <strong>{{ $c->user_name }}</strong>
                                                </div>
                                                <div class="col text-end">
                                                    {{ $c->updated_at->format('M d, Y') }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">{{ $c->comment }}</div>
                                            </div>
                                        </div>
                                        @if ($c->reply != null)
                                            <div class="card mb-3 p-3 ms-5 mt-1">
                                                <div class="row">
                                                    <div class="col">
                                                        <strong>{{$c->admin_name}}</strong>
                                                    </div>
                                                    <div class="col text-end">
                                                        {{ $c->updated_at->format('M d, Y') }}
                                                    </div>
                                                </div>
                                                <div class="row text-end">
                                                    <p>{{ $c->reply }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                            </div>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- End Blog Section -->
    <script>
        let images = {!! json_encode($blog->image) !!};
        images = JSON.parse(images);

        const container = document.getElementById("imageContainer");
        const basePath = "{{ asset('blogs') }}/";

        images.forEach((image, index) => {
            const img = document.createElement("img");
            img.src = basePath + image;

            if (index === 0) {
                img.classList.add("large-image");
                container.appendChild(img);
            } else {
                let shrinkRow = document.querySelector(".shrink-row");

                if (!shrinkRow) {
                    shrinkRow = document.createElement("div");
                    shrinkRow.classList.add("shrink-row");
                    container.appendChild(shrinkRow);
                }

                img.classList.add("small-image");
                shrinkRow.appendChild(img);
            }
        });
    </script>
@endsection
