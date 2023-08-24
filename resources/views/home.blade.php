@extends('layouts.master')

@push('css-styles')
<style>
#section-intro {
    background: linear-gradient(0deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url("{{asset('img/bg/bg-library.jpg')}}") center center fixed;
}
#container-content { border-radius: 25px; background: #f1f1f1; }
#content-title { font-size: 36pt; letter-spacing: 1px; }
#content-tagline { font-size: 14pt; }
@media (max-width: 1199px) {
    #container-content { border-radius: 0; padding-bottom: 30px; }
    #content-title { font-size: 24pt; }
    #content-tagline { font-size: 11pt; }
}
</style>
@endpush

@section('content')

<!-- section-intro -->
<section id="section-intro" class="vh-100">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center mb-4">
            <div id="container-content" class="col-md-10 d-flex flex-remove-md align-items-center p-4 shadow-lg gap-3">
                <div class="col my-3 p-4">
                    <img class="img-fluid" src="{{ asset('/img/materials/art-digital-library.png') }}" style="max-height: 480px"/>
                </div>
                <div class="col mb-3">
                    <h1 id="content-title" class="fw-bold"><span class="text-primary">Pribadi School</span> Digital Library</h1>
                    <hr>
                    <p id="content-tagline">Unlock the World of Knowledge, Journey into Boundless Collection of Literature!</p>
                    <button class="btn btn-outline-primary w-100 mb-2 gap-2" onclick="modal_login_show()"><i class="bx bx-log-in"></i>Sign in</button>
                    <a href="/auth/google" class="btn btn-danger gap-2 mb-3"><i class='bx bx-xs bxl-google-plus'></i><span>Sign in with Google</span></a>
                    <p class="text-center">or</p>
                    <a href="/" class="btn btn-outline-dark w-100 mb-2 gap-2"><i class="bx bx-user"></i>Sign in as a guest</a>
                    <p class="fs-10 fst-italic text-secondary mb-2">*) guest has limited access</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- section-intro end -->

@guest
@include('layouts/partials/modal_auth')
@endguest

@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function(){
});
</script>
@endpush