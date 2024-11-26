<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup Website</title>
    <link rel="stylesheet" href="{{ asset('login/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body>
    <div class="container py-5" id="container">

        <div class="form-container sign-up px-5 py-5">
            <form action="{{ route('signup') }}" method="POST">
                @csrf
                <h1>Create Account</h1>
                <input class="@error('name') is-invalid @enderror" type="text" name="name"
                    placeholder="Full Name">
                @error('name')
                    <small class="invalid-feedback text-danger text-start">{{ $message }}</small>
                @enderror
                <input class="@error('username') is-invalid @enderror" type="text" name="username"
                    placeholder="User Name">
                @error('username')
                    <small class="invalid-feedback text-danger text-start">{{ $message }}</small>
                @enderror
                <input class="@error('email') is-invalid @enderror" type="email" name="email" placeholder="Email">
                @error('email')
                    <small class="invalid-feedback text-danger text-start">{{ $message }}</small>
                @enderror
                <input class="@error('password') is-invalid @enderror" type="password" name="password"
                    placeholder="Password">
                @error('password')
                    <small class="invalid-feedback text-danger text-start">{{ $message }}</small>
                @enderror
                <input class="@error('confirmPassword') is-invalid @enderror" type="password" name="confirmPassword"
                    placeholder="Confirm Password">
                @error('confirmPassword')
                    <small class="invalid-feedback text-danger text-start">{{ $message }}</small>
                @enderror
                <button type="submit">Sign Up</button>
            </form>
        </div>

        <div class="form-container sign-in px-5 py-5">
            <form action="{{ route('signin') }}" method="POST">
                @csrf
                <h1>Sign In</h1>
                <input type="email" name="user_email" placeholder="Email"
                    class="@error('user_email') is-invalid @enderror" value="{{ old('user_email') }}">
                @error('user_email')
                    <small class="invalid-feedback text-danger">{{ $message }}</small>
                @enderror

                <input type="password" name="user_password" placeholder="Password"
                    class="@error('user_password') is-invalid @enderror">
                @error('user_password')
                    <small class="invalid-feedback text-danger">{{ $message }}</small>
                @enderror

                @if ($errors->has('login'))
                    <div class="alert alert-danger w-75 p-2 mb-0">
                        <i data-feather="alert-triangle" class="pe-2"></i>{{ $errors->first('login') }}
                    </div>
                @endif

                <a href="#">Forgot Password?</a>
                <button type="submit">Sign In</button>
            </form>

        </div>

        <div class="toggle-container">
            <div class="toggle">

                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features.</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>

                <div class="toggle-panel toggle-right">
                    <h1>Hello, Subscriber!</h1>
                    <p>Register with your personal details to use all of site features.</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>



    <script src="{{ asset('login/app.js') }}"></script>
    <script>
        feather.replace();
    </script>
</body>

</html>
