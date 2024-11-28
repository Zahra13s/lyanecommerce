@extends('admin.layout.master')

@section('main')
    <div class="main">
        <main class="content">

            <!-- Search Bar -->
            <div class="row mb-3">
                <div class="col-md-4 offset-8">
                    <input type="text" id="searchUser" class="form-control" placeholder="Search User by Name or Email"
                        onkeyup="searchUser()">
                </div>
            </div>

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

                    @foreach ($user as $u)
                        @if ($u->id != auth()->user()->id)
                            <tr class="user-row" data-role="{{ $u->role }}">
                                <th scope="row"></th>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->role }}</td>
                                <td>
                                    <button class="changeRoleButton btn btn-primary" data-user-id="{{ $u->id }}"
                                        role="{{ $u->role }}">
                                        {{ $u->role === 'admin' ? 'Switch to User' : 'Switch to Admin' }}
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
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        const button = $(`button[data-user-id="${userId}"]`);
                        button.attr('role', newRole);
                        location.reload();
                    },
                    error: function(xhr) {
                        const response = JSON.parse(xhr.responseText);
                        alert(`Error: ${response.message || 'Unexpected error occurred'}`);
                    },

                });
            });

            // Filter functionality
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

        // Search functionality
        function searchUser() {
            const searchQuery = document.getElementById('searchUser').value.toLowerCase();
            const userRows = document.querySelectorAll('#userTableBody .user-row');

            userRows.forEach(row => {
                const userName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const userEmail = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                if (userName.includes(searchQuery) || userEmail.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
@endsection
