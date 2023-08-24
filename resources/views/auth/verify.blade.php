@extends('layouts.master')

@push('css-styles')
<style>
body { 
  background:radial-gradient(ellipse at center, rgba(255,254,234,1) 0%, rgba(255,254,234,1) 35%, #B7E8EB 100%);
  overflow: hidden;
}

section { z-index: 9; position: relative; }

.ocean { 
    z-index: 1;
    height: 5%;
    width: 100%;
    position: absolute;
    bottom: 0;
    left: 0;
    background: #015871;
}

.wave {
  background: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/85486/wave.svg) repeat-x; 
  position: absolute;
  top: -198px;
  width: 6400px;
  height: 198px;
  animation: wave 7s cubic-bezier( 0.36, 0.45, 0.63, 0.53) infinite;
  transform: translate3d(0, 0, 0);
}

.wave:nth-of-type(2) {
  top: -175px;
  animation: wave 7s cubic-bezier( 0.36, 0.45, 0.63, 0.53) -.125s infinite, swell 7s ease -1.25s infinite;
  opacity: 1;
}

@media (max-width: 768px) {
    .ocean { display: none; }
}
@keyframes wave {
    0% {
        margin-left: 0;
    }
    100% {
        margin-left: -1600px;
    }
}
@keyframes swell {
    0%, 100% {
        transform: translate3d(0,-25px,0);
    }
    50% {
        transform: translate3d(0,5px,0);
    }
}

</style>
@endpush

@section('content')

<section id="section-verify">
    <div class="container">
        <div class="row vh-100 d-flex align-items-center justify-content-center">
            <div id="container-form" class="col-md-8 p-5 bg-white rounded shadow text-center">
                @if(session('resent'))
                <div class="alert alert-success mb-3" role="alert">
                    <h5>Verification email sent</h5>
                    <p class="mb-0 fs-11">An email has been sent to your email address, check your email to continue the verification process.</p>
                </div>
                @endif
                <img src="{{asset('img/materials/mail-open.png')}}" alt="" class="mb-3" style="max-height: 120px">
                <h3 class="display-5 fs-32 mb-3">Verify your email address</h3>
                <p class="fs-11 mb-3 text-center fw-bold">{{Auth::user()->email}}</p>
                @if(!session('resent'))
                <p class="fs-11">Before you continue, you need to verify this email address by clicking the link below.</p>
                @endif
                <form id="resendVerification" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <div class="d-flex justify-content-center mb-3">
                    @if(session('resent'))
                    <button class="btn btn-outline-primary gap-2" onclick="resendVerification()"><i class="bx bx-mail-send"></i>Send verification email</button>
                    @else
                    <button class="btn btn-outline-primary gap-2" onclick="resendVerification()"><i class="bx bx-mail-send"></i>Send verification email</button>
                    @endif
                </div>
                </form>
                <p class="fs-11 d-flex align-items-center justify-content-center">
                    <a href="/logout" class="hover-underline pb-1 d-flex align-items-center gap-2"><i class="bx bx-log-out"></i>Sign out</a>
                </p>
            </div>
        </div>
    </div>
</section>

<div class="ocean">
    <div class="wave"></div>
    <div class="wave"></div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
});

const resendVerification = () => {
    $('#resendVerification').submit();
}

</script>
@endpush