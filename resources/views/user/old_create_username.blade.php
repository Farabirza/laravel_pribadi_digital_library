@extends('layouts.master')

@push('css-styles')
<style>
#navbar { display: none;  }
#main { min-height: 100vh; background: #f8e9a1; padding: 0 !important; }
@media (max-width: 768px) {
}
@import url(//fonts.googleapis.com/css?family=Lato:300:400);

body {
  margin:0;
}

.header {
  position:relative;
  background: linear-gradient(60deg, rgba(84,58,183,1) 0%, rgba(0,172,193,1) 100%);
}
.logo {
  width:50px;
  fill:white;
  padding-right:15px;
  display:inline-block;
  vertical-align: middle;
}

.inner-header {
  height:85vh;
  width:100%;
  margin: 0;
  padding: 0;
}

.flex { /*Flexbox for containers*/
  display: flex;
  justify-content: center;
  align-items: center;
}

.waves {
  position:relative;
  width: 100%;
  height:15vh;
  margin-bottom:-7px; /*Fix for safari gap*/
  min-height:100px;
  max-height:150px;
}

/* .content {
  position:relative;
  height:20vh;
  text-align:center;
  background-color: white;
} */

/* Animation */

.parallax > use {
  animation: move-forever 25s cubic-bezier(.55,.5,.45,.5)     infinite;
}
.parallax > use:nth-child(1) {
  animation-delay: -2s;
  animation-duration: 7s;
}
.parallax > use:nth-child(2) {
  animation-delay: -3s;
  animation-duration: 10s;
}
.parallax > use:nth-child(3) {
  animation-delay: -4s;
  animation-duration: 13s;
}
.parallax > use:nth-child(4) {
  animation-delay: -5s;
  animation-duration: 20s;
}
@keyframes move-forever {
  0% {
   transform: translate3d(-90px,0,0);
  }
  100% { 
    transform: translate3d(85px,0,0);
  }
}
/*Shrinking for mobile*/
@media (max-width: 768px) {
    .inner-header { padding: 0 20px; }
    /* .waves {
        height:40px;
        min-height:40px;
    } */
    .content {
        height:30vh;
    }
    h1 {
        font-size:24px;
    }
}
</style>
@endpush

@section('content')

<!-- <section id="section-content" class="vh-100 py-40">
    <div class="container h-100">

    <div class="row d-flex h-100 justify-content-center align-items-center px-2">
            <div class="col-md-8 card bg-light p-4">
                <div class="d-flex justify-content-between mb-4">
                    <a href="/"><img src="{{asset('img/logo/logo_cvkreatif.com.png')}}" alt="" style="height:40px"/></a>
                    <a href="/login" class="btn btn-outline-primary btn-modal-login px-4 rounded remove-md"><i class='bx bxs-user me-1' ></i> Login</a>
                </div>
                <h3 class="fs-12 mb-3">Selamat datang <span class="fw-bold text-primary">{{$user->email}}</span></h3>
                <p class="fs-10">Sebelum melanjutkan, silahkan tentukan username anda.</p>
                <form action="/auth/google/register" method="post">
                @csrf
                <input type="hidden" name="google_email" value="{{$user->email}}">
                <input type="hidden" name="google_id" value="{{$user->google_id}}">
                <div class="d-flex flex-remove-md">
                    <div class="col input-group me-3 mb-3">
                        <span class="input-group-text fs-10">cvkreatif.com/cv/</span>
                        <input type="text" name="google_username" class="form-control fs-10" placeholder="username">
                    </div>
                    <button type="button" id="btn-check-username" class="btn btn-primary btn-sm fs-10 mb-3"><i class='bx bx-check-square me-2' ></i>Cek username</button>
                </div>
                <p id="username-check-result" class="mb-2"></p>
                <p class="fs-9 fst-italic text-muted">*username akan menjadi acuan alamat CV anda, contoh: https://cvkreatif.com/cv/john_doe</p>
                <hr class="mb-3">
                <div class="d-flex justify-content-end">
                    <button type="submit" id="btn-submit-username" class="btn btn-primary disabled"><i class='bx bx-user-plus me-2' ></i>Daftar</button>
                </div>
                </form>
            </div>
        </div>

    </div>
</section> -->


<div class="header">

<!--Content before waves-->
<div class="inner-header flex">
    <div class="col-md-5 card bg-light p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/"><img src="{{asset('img/logo/logo_cvkreatif.com.png')}}" alt="" style="height:40px"/></a>
            <a href="/login" class="btn btn-sm btn-outline-primary btn-modal-login px-4 rounded remove-md"><i class='bx bxs-user me-1' ></i> Login</a>
        </div>
        <h3 class="fs-14 mb-2">Selamat datang <span class="fw-bold text-primary">{{$user->email}}</span></h3>
        <p class="fs-9">Sebelum melanjutkan, silahkan tentukan username anda.</p>
        <form action="/auth/google/register" method="post">
        @csrf
        <input type="hidden" name="google_email" value="{{$user->email}}">
        <input type="hidden" name="google_id" value="{{$user->google_id}}">
        <div class="d-flex flex-remove-md">
            <div class="col input-group me-3 mb-3">
                <span class="input-group-text fs-10">cvkreatif.com/cv/</span>
                <input type="text" name="google_username" class="form-control fs-10" placeholder="username">
            </div>
            <button type="button" id="btn-check-username" class="btn btn-primary btn-sm fs-10 mb-3"><i class='bx bx-check-square me-2' ></i>Cek username</button>
        </div>
        <p id="username-check-result" class="mb-2"></p>
        <p class="fs-9 fst-italic text-muted">*username akan menjadi acuan alamat CV anda, contoh: https://cvkreatif.com/cv/john_doe</p>
        <hr class="mb-3">
        <div class="d-flex justify-content-end">
            <button type="submit" id="btn-submit-username" class="btn btn-primary disabled"><i class='bx bx-user-plus me-2' ></i>Daftar</button>
        </div>
        </form>
    </div>
</div>
<!--Waves Container-->
<div>
    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
    viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
    <defs>
    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
    </defs>
    <g class="parallax">
    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
    <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
    </g>
    </svg>
</div>
<!--Waves end-->

</div>
<!--Header ends-->

<!--Content starts-->
<!-- <div class="content flex">
</div> -->
<!--Content ends-->

@include('layouts/partials/modal_auth')

@endsection

@push('scripts')
<script type="text/javascript">

// $(document).ready(function(){
//     let wavesHeight = $('.container-waves').outerHeight();
//     $('#section-content').animate({'margin-bottom': '-137.9px'});
// });

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('[name="google_username"]').keyup(function(){
    $('#btn-submit-username').removeClass('disabled').addClass('disabled');
})
$('#btn-check-username').click(function(e){
    e.preventDefault();
    let google_username = $('[name="google_username"]').val();
    $('#username-check-result').html('<span class="btn spinner"></span>');
    formData = {
        action: 'google_username', username: google_username,
    }
    $.ajax({
        type: "POST",
        url: "/ajax/user",
        data: formData,
        dataType: 'JSON',
        success: function (data) {
            if(data.accept == false) {
                $('#username-check-result').html(
                    '<span class="fs-bold text-danger">' + data.message + '</span>'
                );
                $('#btn-submit-username').removeClass('disabled').addClass('disabled');
            } else {
                $('#username-check-result').html(
                    '<span class="fs-bold text-success"><i class="bx bx-check-double me-1" ></i>' + data.message + '</span>'
                );
                $('#btn-submit-username').removeClass('disabled');
            }
        }, error:function(data) {
            errorMessage('Terdapat kesalahan')
        },
    });
});
</script>
@endpush