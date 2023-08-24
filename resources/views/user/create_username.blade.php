@extends('layouts.master')

@push('css-styles')
<style>
body {
  margin:0;
}

.header {
  position:relative;
  background: linear-gradient(60deg, rgba(84,58,183,1) 0%, rgba(0,172,193,1) 100%);
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

<div class="header">

<!--Content before waves-->
<div class="inner-header flex">
    <form action="/auth/google/register" method="post" class="m-0">
    @csrf
    <div class="row justify-content-center px-3">
        <div class="col-md-12 card shadow p-4">
            <h3 class="display-5 fs-24 mb-3">Create username</h3>
            @if(isset($user))
            <div class="mb-3 text-primary">
                <b>{{$user->name}}</b> | {{$user->email}}
            </div>
            <input type="hidden" name="google_email" value="{{$user->email}}">
            <input type="hidden" name="google_id" value="{{$user->google_id}}">
            @endif
            <div class="mb-3">
                <div class="input-group">
                    <input type="text" name="username" id="modal-register-username" class="form-control" placeholder="Username" value="" required>
                    <span class="input-group-text hover-pointer fs-10 d-flex align-items-center" onclick="handleUsername()"><i class='bx bx-search me-2' ></i>Check username</span>
                </div>
            </div>
            <div class="mb-3">
                <p id="username-check-result" class="mb-0 fs-10"><span class="fst-italic text-secondary">*) please check the username availability before continue</span></p>
            </div>
            <div class="d-flex gap-3 align-items-center justify-content-end">
                <hr class="col">
                <a href="/" class="btn btn-secondary btn-sm d-flex align-items-center"><i class='bx bx-arrow-back me-2'></i>Back</a>
                <button type="submit" id="btn-submit-username" class="btn btn-primary btn-sm d-flex align-items-center disabled"><i class='bx bx-user-plus me-2' ></i>Submit</button>
            </div>
        </div>
    </div>
    </form>
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

@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $('#btn-auth-signin').css('display', 'none');
});

$('[name="username"]').keyup(function(){
    $('#btn-submit-username').removeClass('disabled').addClass('disabled');
    $('#username-check-result').html(`<span class="fst-italic text-secondary">*) please check the username availability before continue</span>`);
})

const handleUsername = () => {
    var result = $('#username-check-result');
    result.html('<span class="btn spinner"></span>');
    var config = {
        method: 'post', url: domain + 'action/general',
        data: {
            action: 'check_username', username: $('[name="username"]').val(),
        },
    }
    axios(config)
    .then((response) => {
        if(response.data.available) {
            result.html('<span class="fs-bold text-success"><i class="bx bx-check-double me-1" ></i>' + response.data.message + '</span>');
            $('#btn-submit-username').removeClass('disabled');
        } else {
            if(response.data.message.length > 1) {
                result.html('');
                response.data.message.forEach(messages);
                function messages(item, index) {
                    result.append('<span class="fs-bold text-danger"><i class="bx bx-error me-1" ></i>' + item + '</span><br/>');
                }
            } else {
                result.html('<span class="fs-bold text-danger"><i class="bx bx-error me-1" ></i>' + response.data.message + '</span>');
            }
            $('#btn-submit-username').removeClass('disabled').addClass('disabled');
        }
    })
    .catch((error) => {
        console.log(error);
        if(error.response) {
            if(error.response.data.message) { errorMessage(response.message); }
        }
    });
}

</script>
@endpush