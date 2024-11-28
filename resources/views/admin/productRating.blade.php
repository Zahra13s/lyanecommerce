@extends('admin.layout.master')
@section('main')
    <div class="p-3">
        <table class="table mb-1">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">User</th>
                    <th scope="col">Rating</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php $i = 0; ?>
                @foreach ($ratings as $r)
                    <tr class="user-row">
                        <td scope="row">{{ ++$i }}</td>
                        <td>{{ $r->name }}</td>
                        <td>{{ $r->category}}</td>
                        <td>{{ $r->username }}</td>
                        <td>@for ($i = 1; $i <= 5; $i++)
                            <i data-feather="star"
                               class="{{ $i <= $r->rating ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
