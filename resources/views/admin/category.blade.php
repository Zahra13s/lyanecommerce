@extends('admin.layout.master')
@section('main')
    <div class="p-3">

        <div class="row">
            <div class="col-6 offset-6 d-flex justify-content-center" >
                <div class="pe-3">
                    <input type="text" id="searchProduct" class="form-control" placeholder="Search Category by Name"
                        onkeyup="searchProduct()">
                </div>

                <div class="text-end">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Category
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('addCategory') }}" method="POST">
                            @csrf
                            <input type="text" name="category" placeholder="Add Category" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <table class="table mb-5">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Product Counts</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php $i = 0; ?>
                @foreach ($data as $category)
                    <tr class="user-row">
                        <th scope="row">{{ ++$i }}</th>
                        <td>{{ $category->category }}</td>
                        <td>{{ $categoryProductCounts[$category->id] ?? 0 }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editCategory-{{ $category->id }}">
                                <i data-id="{{ $category->id }}" data-feather="edit"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="editCategory-{{ $category->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('updateCategory') }}" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{ $category->id }}" name="id">
                                                <input type="text" name="category" placeholder="Edit Category Name"
                                                    class="form-control" value="{{ $category->category }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <script>
        function searchProduct() {
            // Get the value of the search input field
            const searchQuery = document.getElementById('searchProduct').value.toLowerCase();

            // Get all category rows in the table
            const categoryRows = document.querySelectorAll('#userTableBody .user-row');

            // Loop through each category row
            categoryRows.forEach(row => {
                // Get the category name from the current row (second column)
                const categoryName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

                // If the category name contains the search query, display the row, otherwise hide it
                if (categoryName.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
@endsection
