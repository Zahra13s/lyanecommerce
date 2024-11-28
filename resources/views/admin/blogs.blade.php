@extends('admin.layout.master')

@section('main')
    <div class="p-3">
        <!-- Add Blog Button -->
        <div class="text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Blogs
            </button>
        </div>

        <!-- Modal for Adding Blog -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Blog</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('addBlog') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex flex-column align-items-center">
                                <h6>Choose Images</h6>
                                <img src="{{ asset('deafult/product_default.jpg') }}" class="img-thumbnail w-50 sample"
                                    id="sample" alt="Default Image" style="display: block;">
                                <div class="d-flex flex-wrap justify-content-center" id="imagePreviewContainer"></div>
                            </div>

                            <div id="inputFileContainer">
                                <input type="file" name="images[]" class="form-control mt-3" multiple onchange="loadFiles(event)">
                            </div>
                            <button type="button" id="add" class="btn btn-secondary mt-2" onclick="addMoreInputs()">Add More Images</button>

                            <input type="text" name="title" class="form-control mt-3" placeholder="Blog Title" required>
                            <textarea name="text" class="form-control mt-3" placeholder="Blog Text" cols="30" rows="10" required></textarea>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display Blogs -->
        <div class="container mt-3">
            <div class="row">
                @foreach ($blogs as $b)
                    <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
                        <div class="post-entry card p-3 rounded-3">
                            <a href="#" class="post-thumbnail">
                                <div class="d-flex flex-wrap" id="imageContainer-{{ $b->id }}"></div>
                            </a>
                            <div class="d-flex justify-content-end my-2">
                                <button type="button" style="background:none; border:none; cursor:pointer;"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal{{ $b->id }}">
                                    <i data-feather="edit"></i>
                                </button>

                                <!-- Modal for Editing Blog -->
                                <div class="modal fade" id="exampleModal{{ $b->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Blog</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('updateBlog', ['id' => $b->id]) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('POST')

                                                    <div class="d-flex flex-column align-items-center">
                                                        <h6>Choose Images</h6>
                                                        <img src="{{ asset('deafult/product_default.jpg') }}" class="img-thumbnail w-50 sample" id="sample-{{ $b->id }}" alt="">
                                                        <div class="d-flex flex-wrap justify-content-center" id="imagePreviewContainer-{{ $b->id }}"></div>
                                                    </div>

                                                    <div id="inputFileContainer-{{ $b->id }}">
                                                        <input type="file" name="images[]" class="form-control mt-3" multiple onchange="loadFiles(event, {{ $b->id }})">
                                                    </div>
                                                    <button type="button" id="add{{ $b->id }}" class="btn btn-secondary mt-2" onclick="addMoreInputs({{ $b->id }})">Add More Images</button>

                                                    <input type="text" name="title" class="form-control mt-3" value="{{ $b->title }}" required>
                                                    <textarea name="text" class="form-control mt-3" cols="30" rows="10" required>{{ $b->text }}</textarea>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('deleteBlog', ['id' => $b->id]) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:none; border:none; cursor:pointer;">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="card-body post-content-entry p-3">
                                <h2><a href="#">{{ $b->title }}</a></h2>
                                <p class="card-text">
                                    {{ Str::words($b->text, 25, '...') }}
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

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const blogs = @json($blogs);
            blogs.forEach(blog => {
                const images = JSON.parse(blog.image || "[]");
                const container = document.getElementById(`imageContainer-${blog.id}`);
                const basePath = "{{ asset('blogs') }}/";

                if (container && images.length) {
                    images.forEach(image => {
                        const img = document.createElement("img");
                        img.style.width = "45%";
                        img.style.aspectRatio = "1 / 1";
                        img.style.margin = "2px";
                        img.src = basePath + image;
                        container.appendChild(img);
                    });
                }
            });
        });

        function loadFiles(event, modalId = '') {
            const imagePreviewContainer = document.querySelector(`#imagePreviewContainer-${modalId}`) || document.querySelector("#imagePreviewContainer");
            const files = event.target.files;

            if (modalId) {
                document.querySelector(`#sample-${modalId}`).style.display = 'none';
            } else {
                document.querySelector("#sample").style.display = 'none';
            }

            if (imagePreviewContainer) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.className = 'img-thumbnail w-25 m-2';
                        imagePreviewContainer.appendChild(imgElement);
                    };

                    reader.readAsDataURL(file);
                }
            } else {
                console.error('Image preview container not found!');
            }
        }

        function addMoreInputs(modalId = '') {
            const inputFileContainer = document.querySelector(`#inputFileContainer-${modalId}`) || document.querySelector("#inputFileContainer");
            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'images[]';
            newInput.className = 'form-control mt-3';
            newInput.multiple = true;
            newInput.onchange = (event) => loadFiles(event, modalId);
            inputFileContainer.appendChild(newInput);
        }
    </script>
@endsection
