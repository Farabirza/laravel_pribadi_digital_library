@if(!Route::is('home'))
<style>
    #navbar { box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2); }
</style>
@endif
<style>
.navbar-brand img { max-height: 40px; }
.nav-item { margin-left: 6px; }
#user-img { width: 40px; }
@media (max-width: 1199px) {
    .navbar-brand img { max-height: 30px; }
    .navbar-collapse { padding-top: 15px; }
    .navbar-nav { margin-bottom: 4px; }
}
</style>

<div id="section-navbar">
    <nav id="navbar" class="navbar @if(!Route::is('home')) fixed-top @endif navbar-expand-lg py-3 navbar-light bg-white">
        <div class="container">
            <a href="/" class="navbar-brand"><img id="navbar-logo-img" class="py-1" src="{{ asset('/img/logo/logo_cvkreatif.com.png') }}" alt="site_logo"/></a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav justify-content-center col">
                </div>
                <div class="navbar-nav ">
                    @auth
                        <div class="dropdown nav-item d-flex vertical-center">
                            <img src="{{ asset('/img/profiles/male.png') }}" id="user-img" alt="" class="img-fluid rounded-circle box-shadow-2 me-2">
                            <span class="me-2">{{Auth::user()->username}}</span>
                            <i id="user-icon" class='bx bx-chevron-down' type="button" id="user-menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                            <ul class="dropdown-menu" aria-labelledby="user-menu">
                                @if(isset(Auth::user()->config))
                                <li><a class="dropdown-item" href="/cv/{{Auth::user()->username}}"><i class='bx bx-file mr-3'></i> Halaman CV</a></li>
                                <li><a class="dropdown-item" href="/dashboard/edit/profile"><i class='bx bx-edit-alt mr-3'></i> Edit data</a></li>
                                <li class="mb-2"><hr class="dropdown-divider"></li>
                                @endif
                                <li id="show-modal-feedback" class="mb-2"><span class="dropdown-item btn"><i class='bx bx-star mr-3'></i> Feedback</span></li>
                                <li class="mb-2"><a class="dropdown-item" href="/logout"><i class='bx bx-log-out mr-3' ></i> Logout</a></li>
                            </ul>
                        </div>
                    @endauth
                    @guest
                        <div class="nav-item nav-link align-middle"><a href="/login" class="btn btn-outline-primary btn-modal-login px-4 rounded"><i class='bx bxs-user me-1' ></i> Login</a></div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
</div>
@auth
@include('layouts/partials/modal_feedback')
@endauth
@include('layouts/partials/modal_auth')
@push('scripts')
<script>
$(window).resize(function() {
  if($(window).width() < 1199) {
    $('#navbar').removeClass('py-3');
  } else {
    $('#navbar').addClass('py-3');
  }
});
$('document').ready(function(){
    // window size
    if($(window).width() < 1199) {
        $('#navbar').removeClass('py-3');
    } else {
        $('#navbar').addClass('py-3');
    }
});
</script>
@endpush