@extends('admin.layout.master')

@section('main')
    <div class="main">
        <main class="content">

            <!-- Filter Options -->
            <div class="filter-options text-end shadow-sm">
                <button class="btn filter-btn" data-role="all">All</button>
                <button class="btn filter-btn" data-role="user">Users</button>
                <button class="btn filter-btn" data-role="admin">Admins</button>
            </div>

            <!-- Table to Display Users -->
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th>Change Role</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    <?php $i = 0; ?>
                    @foreach ($user as $u)
                        @if ($u->id != auth()->user()->id)
                            <tr class="user-row" data-role="{{ $u->role }}">
                                <th scope="row">{{ ++$i }}</th>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->role }}</td>
                                <td>
                                    <button class="changeRoleButton btn" data-user-id="{{ $u->id }}"
                                        role="{{ $u->role }}">
                                        <i data-feather="repeat"></i>
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $user->links('pagination::bootstrap-5') }}
            </div>
        </main>
    </div>

    <!-- Ensure jQuery is properly loaded -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.changeRoleButton').on('click', function() {
                const userId = $(this).data('user-id');
                const currentRole = $(this).attr('role');

                const newRole = currentRole === 'admin' ? 'user' : 'admin';

                $.ajax({
                    url: '{{ route('updateRole') }}',
                    type: 'POST',
                    data: {
                        user_id: userId,
                        role: newRole,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $(`button[data-user-id="${userId}"]`).attr('role', newRole);
                        alert('Role updated successfully!');
                    },
                    error: function(xhr) {
                        alert('Failed to update role: ' + xhr.responseText);
                    }
                });
            });

            $('.filter-btn').on('click', function() {
                const role = $(this).data('role');

                $('.filter-btn').removeClass('active');

                $(this).addClass('active');

                if (role === 'all') {
                    $('.user-row').show();
                } else {
                    $('.user-row').hide();
                    $(`.user-row[data-role="${role}"]`).show();
                }
            });
        });
    </script>
@endsection
