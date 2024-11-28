@extends('user.layouts.master')
@section('main')
    <div class="p-3">
        <div class="row mb-5" style="height:50vw; overflow:scroll;">
            <!-- User Profile Details -->
            <div class="col-4 offset-1 p-3 card">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset(auth()->user()->image ? 'uploads/profile_images/' . auth()->user()->image : 'admin/img/avatars/avatar-2.jpg') }}"
                    width="250px" style="aspect-ratio:1/1; object-position:center;" alt="User Profile Picture" class="rounded-3">
                </div>
                <h3 class="mt-3 text-center">{{ auth()->user()->name }}</h3>
                <hr>
                <ul style="list-style: none; padding:0px;">
                    <li class="mt-3"><strong>Phone No.:</strong>
                        @if (auth()->user()->phone_no)
                            {{ auth()->user()->phone_no }}
                        @else
                            Update it please
                        @endif
                    </li>
                    <li class="mt-3"><strong>Address:</strong>
                        @if (auth()->user()->address)
                            {{ auth()->user()->address }}
                        @else
                            Update it please
                        @endif
                    </li>
                </ul>
                <hr>
                <!-- Profile Update Form -->
                <form action="{{ route('userUpdateProfile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="image" class="form-control mt-3">
                    <input type="text" name="phone" class="form-control mt-3" placeholder="Phone Number">
                    <input type="text" name="address" class="form-control mt-3" placeholder="Address">
                    <button type="submit" class="btn btn-primary mt-2">Update Profile</button>
                </form>
            </div>

            <!-- Favorites and Saved Items Section -->
            <div class="col-6">
                <div class="row mb-4">
                    <div class="col-2 offset-10 d-flex justify-content-evenly">
                        <a href="{{ route('userProfilePage', ['tab' => 'favorites']) }}"
                            class="{{ $activeTab == 'favorites' ? 'text-primary' : '' }}">
                            <i data-feather="heart"></i>
                        </a>
                        <a href="{{ route('userProfilePage', ['tab' => 'saved']) }}"
                            class="{{ $activeTab == 'saved' ? 'text-primary' : '' }}">
                            <i data-feather="save"></i>
                        </a>
                    </div>
                </div>
                <div class="row">
                    @if ($activeTab == 'favorites')
                        <h4>Favorites</h4>
                        @forelse ($blogFavorites as $b)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-6 mb-4 mb-md-0 mt-3">
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
                                        {{-- <span>on <a href="#">{{ $b->updated_at->format('M d, Y') }}</a></span> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <p>No favorites yet!</p>
                        @endforelse
                    @elseif ($activeTab == 'saved')
                        <h4>Saved Items</h4>
                        @forelse ($blogSavedItems as $b)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-6 mb-4 mb-md-0 mt-3">
                            <div class="post-entry card p-3 rounded-3">
                                <a href="#" class="post-thumbnail">

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
                                        {{-- <span>on <a href="#">{{ $b->updated_at->format('M d, Y') }}</a></span> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <p>No saved items yet!</p>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
