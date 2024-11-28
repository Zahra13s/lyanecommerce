@extends('admin.layout.master')
@section('main')
    <div class="p-3">
        <div class="row mb-5">
            <!-- User Profile Details -->
            <div class="col-4 offset-1 p-3">
                <img src="{{ asset(auth()->user()->image ? 'uploads/profile_images/' . auth()->user()->image : 'deafult/profile.svg') }}"
                    width="250px" alt="User Profile Picture" class="rounded-circle">
                <h3 class="mt-3">{{ auth()->user()->name }}</h3>
                <h5>{{ auth()->user()->role }}</h5>
                <ul style="list-style: none; padding:0px;">
                    <li class="mt-3"><strong>Phone No.:</strong>
                        @if (auth()->user()->phone_no)
                            {{ auth()->user()->phone_no }}
                        @else
                            Update it please
                        @endif
                    </li>
                    <li class="mt-3"><strong>Address:</strong>
                        @if (auth()->user()->address)
                            {{ auth()->user()->address }}
                        @else
                            Update it please
                        @endif

                    </li>
                </ul>
            </div>

            <div class="col-6 d-flex align-items-center justify-content-center">
                               <!-- Profile Update Form -->
                               <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="image" class="form-control mt-3">
                                <input type="text" name="phone" class="form-control mt-3" placeholder="Phone Number">
                                <input type="text" name="address" class="form-control mt-3" placeholder="Address">
                                <button type="submit" class="btn btn-primary mt-2">Update Profile</button>
                            </form>
            </div>
        </div>
    </div>
@endsection
