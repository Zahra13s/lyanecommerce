@extends('admin.layout.master')

@section('main')
    <div class="p-3">
        <table class="table mb-5">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Blog</th>
                    <th scope="col">User</th>
                    <th scope="col">Comment</th>
                    <th scope="col">Reply</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                @foreach ($comments as $b)
                    <tr>
                        <td>#</td>
                        <td>{{ $b->title }}</td>
                        <td>{{ $b->username }}</td>
                        <td>{{ $b->comment }}</td>
                        <td>
                            @if($b->reply != null)
                                {{ $b->reply }}
                            @else
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$b->id}}">
                                    <i data-feather="corner-up-left"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{$b->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Reply</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>{{ $b->username }}</strong></p>
                                                <p>{{ $b->comment }}</p>
                                                <form action="{{ route('Reply') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="comment_id" value="{{ $b->id }}">
                                                    <input type="text" name="reply" placeholder="Reply" class="form-control">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Reply</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
