<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup Website</title>
    <link rel="stylesheet" href="{{asset('login/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="container" id="container">

        <div class="form-container sign-up">
            <form action="{{route('signup')}}" method="POST">
                @csrf
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-x-twitter"></i></a>
                </div>
                <span>or use your email for register</span>
                <input type="text" name="name" placeholder="Full Name">
                <input type="text" name="username" placeholder="User Name">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="confirmPassword" placeholder="Confirm Password">
                <button>Sign Up</button>
            </form>
        </div>

        <div class="form-container sign-in">
            <form action="{{route('signin')}}" method="POST">
                @csrf
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-x-twitter"></i></a>
                </div>
                <span>or use your email and password</span>
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <a href="#">Forgot Password?</a>
                <button>Sign In</button>
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



    <script src="{{asset('login/app.js')}}"></script>
</body>
</html>
