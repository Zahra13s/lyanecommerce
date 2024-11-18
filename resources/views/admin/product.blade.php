@extends('admin.layout.master')
@section('main')
    <div class="p-3">

        <div class="row">
            <div class="col-4 offset-8 d-flex justify-content-between">
                <div class="">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search"
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">Search</button>
                        </div>
                    </div>
                </div>

                <div class="">
                    <div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Add Product
                        </button>
                    </div>
                </div>
            </div>
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
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('deafult/product_default.jpg') }}" class="img-thumbnail w-50" alt=""
                                id="output">
                        </div>
                        <form action="{{ route('addProduct') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="image" class="form-control mt-3" onchange="loadFile(event)">
                            <input type="text" name="name" class="form-control mt-3" placeholder="Product Name">
                            <select name="category" id="" class="form-control mt-3">
                                <option value="">Choose one</option>
                                @foreach ($data as $d)
                                    <option value="{{ $d->id }}">{{ $d->category }}</option>
                                @endforeach
                            </select>
                            <textarea name="description" class="form-control mt-3" placeholder="Description" id="" cols="30"
                                rows="10"></textarea>

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
                    <th class="col">#</th>
                    <th class="col-2">Image</th>
                    <th class="col">Name</th>
                    <th class="col">Category</th>
                    <th class="col-4">Description</th>
                    <th class="col">Edit</th>
                    <th class="col">Delete</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php $i = 0; ?>
                @foreach ($product as $p)
                    <tr class="user-row">
                        <th scope="row">{{ ++$i }}</th>
                        <td>
                            @if ($p->image)
                                <img src="{{ asset('products/' . $p->image) }}" alt="" class="w-100 img-thumbnail">
                            @else
                                <img src="{{ asset('deafult/product_default.jpg') }}" alt=""
                                    class="w-100 img-thumbnail">
                            @endif
                        </td>

                        <td>{{ $p->name }}</td>
                        <td>{{ $p->category }}</td>
                        <td>{{ $p->description }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editProduct-{{ $p->id }}">
                                <i data-id="{{ $p->id }}" data-feather="edit"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="editProduct-{{ $p->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ asset('products/' . $p->image) }}"
                                                    class="img-thumbnail w-50" alt="" id="output">
                                            </div>
                                            <form action="{{ route('updateProduct') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                                <input type="file" name="image" class="form-control mt-3"
                                                    onchange="loadFile(event)">
                                                <input type="text" name="name" class="form-control mt-3"
                                                    value="{{ $p->name }}" placeholder="Product Name">
                                                <select name="category" class="form-control mt-3">
                                                    <option value="">Choose one</option>
                                                    @foreach ($data as $d)
                                                        <option value="{{ $d->id }}"
                                                            {{ $d->id == $p->category_id ? 'selected' : '' }}>
                                                            {{ $d->category }}</option>
                                                    @endforeach
                                                </select>
                                                <textarea name="description" class="form-control mt-3" placeholder="Description" cols="30" rows="10">{{ $p->description }}</textarea>
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
                        <td>
                            <!-- Form for deleting the product -->
                            <form id="delete-product-{{ $p->id }}" action="{{ route('deleteProduct', $p->id) }}"
                                method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <!-- Delete Button with Feather Icon -->
                                <button type="submit" class="btn btn-danger" title="Delete">
                                    <i data-feather="trash-2"></i> <!-- Feather Icon -->
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            {{ $product->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
