<?php header("Location: /"); die(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="description" content="Blank Laravel Template by irzafarabi.com" />
<meta name="keywords" lan="en" content="blank, laravel, template" />
<meta property="og:image" content="{{ asset('img/bg/office-1.jpg') }}" />

<!-- Vendor JS Files -->
<script src="{{ asset('/vendor/jquery/jquery-3.1.1.min.js') }}"></script>

<!-- Favicons -->
<link href="{{ asset('/img/logo/logo.png') }}" rel="icon">
<link href="{{ asset('/img/logo/logo.png') }}" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/toastr/toastr.min.css') }}" rel="stylesheet">

<!-- Main CSS File -->
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">

<title>Laravel | Login Page</title>
  
<style>
#section-login {
    height: 100vh;
    background: url('../img/bg/bg_trans-80.png') top left repeat, url("../img/bg/office-1.jpg") top center transparent fixed;
    background-size: cover;
}
#form-login { background: #fff; padding: 60px 40px; border-radius: 8px; }
</style>
</head>
<body>

<section id="section-login">
    <div class="container py-5 h-100">
        <div class="row d-flex h-100 justify-content-center align-items-center">
            <div id="form-login" class="col-md-8">
                <h1 class="display-5">Laravel Blank Template</h1>
                <p class="mb-40">Log in to your account</p>

                <form action="/login" method="POST">
                @csrf
                    @if(session('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                    @endif  
                    <div class="form-group">
                        <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" value="{{ old('email') }}" autofocus>
                        @error('email')
                        <br><div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
                        @error('password')
                        <br><div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-outline">
                        <p class="pb-lg-2" style="color: #393f81;"><input type="checkbox" name="remember" value="true" class="mr-8"> Remember me</p>
                    </div>
                    <div class="form-group d-flex">
                        <button type="submit" class="btn btn-primary btn-lg"><i class='bx bx-log-in' ></i> Login</button>
                    </div>
                    <div class="form-group">
                        <!-- <a class="small text-muted" href="#!">Forgot password?</a> -->
                        <p class="pb-lg-2" style="color: #393f81;">Don't have an account? <a href="/register"><b>Register here</b></a></p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<!-- Vendor JS Files -->
<script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/vendor/toastr/toastr.min.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('/js/main.js') }}"></script>


<script type="text/javascript">
$(document).ready(function(){
});
</script>

</body>
</html>