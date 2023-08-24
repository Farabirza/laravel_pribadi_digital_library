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

<!-- Vendor CSS Files -->
<link href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/toastr/toastr.min.css') }}" rel="stylesheet">

<!-- Main CSS File -->
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">

<title>CVKreatif.com | Verifikasi Email</title>
  
<style>
#section-login {
    height: 100vh;
    background: #f8e9a1;
    background-size: cover;
}
#form-login { background: #fff; padding: 60px 40px; border-radius: 8px; }
</style>
</head>
<body>

<section id="section-login">
    <div class="container py-5 h-100">
        <div class="row d-flex h-100 justify-content-center align-items-center">
            <div id="form-login" class="col-md-8 shadow">
                @if (session('resent'))
                    <div class="alert alert-success mb-3" role="alert">
                        {{ __('Kode verifikasi telah dikirim ke alamat email anda.') }}
                    </div>
                @endif
                <h1 class="display-5" style="color:#f76c6c">CVKreatif.com</h1>
                <p class="fw-bold mb-3">Verifikasi Alamat Email</p>

                <p class="mb-1">Sebelum melanjutkan, silahkan cek email anda untuk melakukan proses verifikasi.</p>
                <p class="mb-3">Apabila anda <span class="text-danger">tidak menerima email berisikan kode verifikasi</span>, silahkan klik tombol dibawah ini.</p>
                <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                    @if (session('resent'))
                        <p>
                            <button type="submit" class="btn btn-primary me-2"><i class='bx bx-envelope'></i> Kirim ulang kode verifikasi</button> 
                            <a href="https://mail.google.com/" class="btn btn-danger"><i class='bx bxs-envelope'></i> Menuju Gmail.com</a>
                        </p>
                    @else
                        <p>
                            <button type="submit" class="btn btn-outline-primary me-2"><i class='bx bx-envelope'></i> Kirim kode verifikasi</button> 
                            <a href="https://mail.google.com/" class="btn btn-danger"><i class='bx bxs-envelope'></i> Menuju Gmail.com</a>
                        </p>
                    @endif
                    <hr class="my-4"/>
                    <p><a href="/" class="btn btn-secondary me-2"><i class='bx bx-arrow-back'></i> Kembali</a> <a href="/logout" class="btn btn-danger"><i class='bx bx-log-out'></i> Log out</a></p>
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