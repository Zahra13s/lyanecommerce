@extends('user.layouts.master')
@section('main')

    <!-- Start Why Choose Us Section -->
    <div class="why-choose-section">
        <div class="container mb-5">
            <div class="row justify-content-between align-items-center">
                <table class="table">
                    <thead>
                        <th scope="col">Order Code</th>
                        <th scope="col">Confirm</th>
                        <th scope="col">Details</th>
                    </thead>
                    <tbody>
                        @foreach ($orders as $o)
                       <tr>
                         {{-- <td>{{$o->id}}</td> --}}
                         <td>{{$o->order_code}}</td>
                         <td>
                            @if ($o->checked == 0)
                            <small class="text-danger">Denied</small>
                        @else
                            <small class="text-success">Confirmed</small>
                        @endif

                        </td>
                         <td><a href="{{route('orderHistoryDetails', $o->order_code)}}"><i data-feather="arrow-right-circle"></i></a></td>
                       </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Why Choose Us Section -->
@endsection
