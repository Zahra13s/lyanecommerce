@extends('admin.layout.master')
@section('main')
    <div class="p-3">

        <div class="text-end">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Product
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('addBlog') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex flex-column align-items-center">
                                <h6>Choose Images</h6>
                                <div class="d-flex flex-wrap justify-content-center" id="imagePreviewContainer">
                                    <img src="{{ asset('default/product_default.jpg') }}" class="img-thumbnail w-50"
                                        alt="">
                                </div>
                            </div>

                            <div id="inputFileContainer">
                                <input type="file" name="images[]" class="form-control mt-3" multiple
                                    onchange="loadFiles(event)">
                            </div>
                            <button type="button" id="add" class="btn btn-secondary mt-2">Add More Images</button>

                            <input type="text" name="title" class="form-control mt-3" placeholder="Blog Title"
                                required>
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

        <table class="table mb-5">
            <thead>
                <tr>
                    <th class="col">#</th>
                    <th class="col-2">Image</th>
                    <th class="col">Title</th>
                    <th class="col">Texts</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php $i = 0; ?>
                @foreach ($blogs as $b)
                    <tr class="user-row">
                        <th scope="row">{{ ++$i }}</th>
                        <td>
                            <div class="d-flex flex-column" id="imageContainer">

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
                                    img.style.width = "50%"
                                    img.style.marginTop = "15px"
                                    img.src = basePath + images[i]; // Concatenate base path with the image name
                                    container.appendChild(img);
                                }
                            </script>

                        </td>
                        <td>{{ $b->title }}</td>
                        <td>{{ $b->text }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <script>
        function loadFiles(event) {
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const files = event.target.files; // Get the selected files

            // Loop through each selected file
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.className = 'img-thumbnail w-25 m-2'; // Adjust size and margin as needed
                    imagePreviewContainer.appendChild(imgElement);
                };

                reader.readAsDataURL(file); // Read the file as a data URL
            }
        }

        function addMoreInputs() {
            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'images[]'; // Ensure this matches your backend expectation
            newInput.className = 'form-control mt-3';
            newInput.multiple = true; // Allow multiple file selection
            newInput.onchange = loadFiles; // Load the file preview
            inputFileContainer.appendChild(newInput);
        }

        let addButton = document.querySelector("#add");
        let inputFileContainer = document.querySelector("#inputFileContainer");
        addButton.addEventListener("click", addMoreInputs);
    </script>
@endsection
