@extends('admin.layout.master')

@section('main')
    <div class="p-3">
        <table class="table mb-5">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order Code</th>
                    <th scope="col">Username</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                @foreach ($orderDisplay as $o)
                    <tr>
                        <td>#</td>
                        <td>{{ $o->order_code }}</td>
                        <td>{{ $o->username }}</td>
                        <td>
                            <a href="{{ route('orderDetails', $o->order_code) }}">
                                <i data-feather="arrow-right"></i> View Order Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
