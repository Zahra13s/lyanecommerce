<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link rel="shortcut icon" href="{{ asset('admin/img/icons/icon-48x48.png') }}" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>AdminKit Demo - Bootstrap 5 Admin Template</title>

    <link href="{{ asset('admin/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstrap JS with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    {{-- sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.html">
                    <span class="align-middle">AdminKit</span>
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        User Management
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('Admindashboard') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('Admindashboard') }}">
                            <i class="align-middle" data-feather="sliders"></i> <span
                                class="align-middle">Dashboard</span>
                        </a>
                    </li>

                    @if (auth()->user()->role == 'superadmin')
                        <li class="sidebar-item {{ request()->routeIs('AddAdminsPage') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('AddAdminsPage') }}">
                                <i class="align-middle" data-feather="users"></i> <span class="align-middle">Manage
                                    Admins</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-header">
                        Products Management
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('pricePage') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('pricePage') }}">
                            <i class="align-middle" data-feather="tag"></i> <span class="align-middle">Update Price
                            </span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('categoriesPage') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('categoriesPage') }}">
                            <i class="align-middle" data-feather="server"></i> <span class="align-middle">Add
                                Categories</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('colorsPage') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('colorsPage') }}">
                            <i class="align-middle" data-feather="aperture"></i> <span class="align-middle">Add
                                Colors</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('productsPage') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('productsPage') }}">
                            <i class="align-middle" data-feather="package"></i> <span class="align-middle">Add Products
                            </span>
                        </a>
                    </li>


                    <li class="sidebar-item {{ request()->routeIs('productRating') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('productRating') }}">
                            <i class="align-middle" data-feather="star"></i> <span class="align-middle">Product Rating
                            </span>
                        </a>
                    </li>


                    <li class="sidebar-header">
                        Order Management
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('ordersReply') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('ordersReply') }}">
                            <i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">
                                Orders
                            </span>
                        </a>
                    </li>

                    <li class="sidebar-header">
                        Blogs Management
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('blogsPage') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('blogsPage') }}">
                            <i class="align-middle" data-feather="book"></i> <span class="align-middle">Create
                                Blogs</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('blogComment') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('blogComment') }}">
                            <i class="align-middle" data-feather="message-circle"></i> <span
                                class="align-middle">Comment Reply</span>
                        </a>
                    </li>


                </ul>
            </div>
        </nav>
        <div class="main" style="position:relative;">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                                data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <a class="nav-link d-none d-sm-inline-block" href="{{ route('profilePage') }}">
                                <img src="{{ asset(auth()->user()->image ? 'uploads/profile_images/' . auth()->user()->image : 'deafult/profile.svg') }}"
                                    alt="User Profile Picture" class="avatar img-fluid rounded me-1">
                                <span class="text-dark">{{auth()->user()->name}}</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-item" href="index.html">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a style="text-decoration: none; color:black;" href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                        <i class="align-middle me-1" data-feather="log-out"></i>
                                        {{ __('Log Out') }}

                                    </a>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            @yield('main')

            <div class="mt-4">
                <footer class="footer w-100" style="position:absolute; bottom:0;">
                    <div class="w-100 footer">
                        <div class="row text-muted">
                            <div class="col-6 text-start">
                                <p class="mb-0">
                                    <a class="text-muted" href="https://adminkit.io/"
                                        target="_blank"><strong>AdminKit</strong></a> &copy;
                                </p>
                            </div>
                            <div class="col-6 text-end">
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="https://adminkit.io/" target="_blank">Help
                                            Center</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    @if (session('success'))
    <script>
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Success!",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('admin/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadFile(event) {
            var reader = new FileReader();

            reader.onload = function() {
                var output = document.getElementById("output");
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

    </script>

</body>

</html>
