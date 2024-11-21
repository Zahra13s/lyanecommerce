@extends('admin.layout.master')
@section('main')
    <div class="p-3">
        <div class="row">
            <!-- User Profile Details -->
            <div class="col-4 offset-1 text-center">
                <img src="{{ asset(auth()->user()->image ? 'uploads/profile_images/' . auth()->user()->image : 'admin/img/avatars/avatar-2.jpg') }}"
                     width="250px"
                     alt="User Profile Picture"
                     class="rounded-circle">
                <h3 class="mt-3">{{ auth()->user()->name }}</h3>
                <h5>{{ auth()->user()->role }}</h5>

                <!-- Profile Update Form -->
                <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="image" class="form-control">
                    <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                    <input type="text" name="address" class="form-control" placeholder="Address">
                    <button type="submit" class="btn btn-primary mt-2">Update Profile</button>
                </form>


            </div>

            <!-- Placeholder for additional content -->
            <div class="col-6 d-flex align-items-center justify-content-center">
                <p class="text-muted">Additional content or statistics here...</p>
            </div>
        </div>
    </div>
@endsection
