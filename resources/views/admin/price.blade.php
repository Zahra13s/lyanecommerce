@extends('admin.layout.master')
@section('main')
    <div class="p-3">

        <div class="text-end">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPrice">
                Add Price
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="createPrice" tabindex="-1" aria-labelledby="createPriceLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPriceLabel">Add Today's Price</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('addPrice') }}" method="POST">
                            @csrf
                            <input type="text" name="price" placeholder="Add Price" class="form-control">
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
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Steel Price</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php $i = 0; ?>
                @foreach ($data as $d)
                    <tr class="user-row">
                        <th scope="row">{{ ++$i }}</th>
                        <td>{{ $d->updated_at->format('d - m - Y (D)') }}</td>
                        <td>{{ $d->updated_at->format('h:i:s A') }}</td>
                        <td>{{ $d->price }}</td>
                        <td>{{ $d->price + 5000 }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPrice-{{ $d->id }}">
                                <i data-id="{{ $d->id }}" data-feather="edit"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="editPrice-{{ $d->id }}" tabindex="-1" aria-labelledby="editPriceLabel-{{ $d->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editPriceLabel-{{ $d->id }}">Edit Today's Price</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('updatePrice') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $d->id }}">
                                                <input type="text" name="price" placeholder="Add Price" class="form-control">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
@endsection
