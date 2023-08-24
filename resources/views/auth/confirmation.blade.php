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
    height: .8%;
    width:100%;
    position:absolute;
    bottom:0;
    left:0;
    background: #015871;
}

.wave {
  background: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/85486/wave.svg) repeat-x; 
  position: absolute;
  top: -158px;
  width: 6400px;
  height: 158px;
  animation: wave 7s cubic-bezier( 0.36, 0.45, 0.63, 0.53) infinite;
  transform: translate3d(0, 0, 0);
}

.wave:nth-of-type(2) {
  top: -125px;
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
                <img src="{{asset('img/materials/confirmation.png')}}" alt="" class="mb-3" style="max-height: 160px">
                <h3 class="display-5 fs-32 mb-3">Account confirmation</h3>
                <p class="fs-11">Since you state that your role is a <span class="text-primary">{{Auth::user()->profile->role}}</span>, we need to confirm that you are not a student. Insert the <b>confirmation key</b> in the field below or ask other teacher to confirm your account.</p>
                <form action="post" id="form-confirmation" class="mb-3 fs-11">
                    <input type="hidden" name="action" value="confirmation">
                    <div class="mb-0 form-floating input-group">
                        <input type="text" id="confirm-key" name="key" class="form-control" placeholder="key">
                        <label for="confirm-key" class="form-label text-primary">Confirmation key</label>
                        <button role="submit" class="input-group-text d-flex align-items-center gap-2"><i class='bx bx-key' ></i>Submit</button>
                    </div>
                    <p id="alert-key" class="mt-3 mb-0 fs-11 alert alert-danger d-none"></p>
                </form>
                <p class="fs-11 d-flex align-items-center justify-content-center gap-4">
                    <a href="/profile" class="hover-underline pb-1 d-flex align-items-center gap-2"><i class="bx bx-user"></i>Profile</a>
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
$('#form-confirmation').submit(function(e) {
    e.preventDefault();
    $('.alert').hide();
    let formData = new FormData($(this)[0]);
    let config = {
        method: 'post', url: domain + 'action/user', data: formData,
    };
    axios(config)
    .then((response) => {
        successMessage(response.data.message);
        location.reload();
    }, 600)
    .catch((error) => {
        console.log(error);
        $('#alert-key').html(error.response.data.message).removeClass('d-none').hide().fadeIn('slow');
    })
});

$(document).ready(function(){
});

const resendVerification = () => {
    $('#resendVerification').submit();
}

</script>
@endpush