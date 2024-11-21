@extends('admin.layout.master')
@section('main')
    <div class="p-3">

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
                @foreach ($orderDisplay as $o)
                    <tr>
                        <td>#</td>
                        <td>{{ $o->order_code }}</td>
                        <td>{{ $o->username }}</td>
                        <td><i data-feather="arrow-right"></i></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
