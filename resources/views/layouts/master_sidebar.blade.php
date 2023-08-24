<!DOCTYPE html>
<html lang="en">

<head>
@include('layouts.partials.metaTags')

<!-- Vendor JS Files -->
<script src="{{ asset('/vendor/jquery/jquery-3.6.0.min.js') }}"></script>

<!-- Vendor CSS Files -->
<link href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/toastr/toastr.min.css') }}" rel="stylesheet">

<!-- Main CSS File -->
<link href="{{ asset('/css/style.css') }}?v=3" rel="stylesheet">
<link href="{{ asset('/css/style_dashboard.css') }}" rel="stylesheet">

@if(isset($page_title))
<title>{{$page_title}}</title>
@else
<title>cvkreatif.com</title>
@endif
  
@stack('css-styles')
<style>
#sidebar-dashboard img { max-width: 100%; }
#sidebar-profile, #sidebar-menu { padding-left: 20px; padding-right: 20px; }
.section-title { 
    color: #374785; 
    text-transform: uppercase; 
    letter-spacing: 1.4px; 
    display: flex;
    align-items: center;
    padding-left: 16px;
    border-left: 8px solid #374785;
}
.nav-link span { font-weight: 500; font-size: 12pt; }
.nav-list a { display: flex; align-items: center; gap: 2px; }
.sign-admin { position: absolute; top: 10px; right: 35px; padding: 6px; border: transparent; background: gold; color: #fff; }
#btn-notification {
    z-index: 999;
    position: fixed;
    right: 40px;
    bottom: 40px; 
    background: #f9f9f9;
    color: var(--bs-dark);
    font-size: 24pt;
    padding: 10px;
    border-radius: 50%;
}
#btn-notification:hover {
    background: #ddd;
}
#btn-notification span {
    position: absolute;
    top: 5%;
    left: 90%;
    background: var(--bs-danger);
    font-size: 8pt;
}
@media (max-width: 768px) {
}

@media (max-width: 1199px) {
    #btn-notification {
        font-size: 18pt;
        right: 25px;
        bottom: 25px;
        border: 1px solid #999; 
    }
}
</style>
</head>
<body>

@include('layouts.partials.modal_notification')

 <!-- ======================================= sidebar start ================================================== -->
 <header>
 <div id="sidebar-dashboard" class="d-flex flex-column flex-shrink-0">
    <div class="mb-5">
        <p class="text-center text-light fs-14 mb-4"><a href="/" class="text-center"><b>Digital</b> Library</a></p>
        <a href="/" class="text-center"><img src="{{asset('img/logo/logo-pribadi-white.png')}}" class="d-block"></a>
    </div>
    @auth
    <div class="px-3 mb-3">
        <div class="text-center position-relative">
            @if(Auth::user()->picture != null)
            <img src="{{ asset('img/profiles/'.Auth::user()->picture) }}" alt="" class="rounded user-picture" style="max-height:180px;">
            @else
            <img src="{{asset('img/profiles/user.jpg')}}" alt="" class="rounded user-picture" style="max-height:180px;">
            @endif
            @if(Auth::user()->authority->name == 'superadmin')
            <a href="/admin/user"><i class=" sign-admin bx bxs-crown bx-border-circle popper" title="Superadmin"></i></a>
            @elseif(Auth::user()->authority->name == 'admin')
            <a href="/admin/user"><i class="sign-admin bx bx-crown bx-border-circle popper" title="Admin"></i></a>
            @endif
            @if(Auth::user()->profile)
            <p class="text-light fs-10 mt-3 mb-2 text-uppercase fw-bold d-flex align-items-center justify-content-center gap-2" style="letter-spacing:1px">
                <a href="/profile">{{Auth::user()->profile->full_name}}</a>
            </p>
            <p class="text-light fs-10 mb-0 text-capitalize"><span class="bg-white text-dark rounded px-3">{{Auth::user()->profile->role}}</span></p>
            @endif
        </div>
    </div>
    <div id="sidebar-menu" class="py-3 px-3">
        <nav class="nav-menu navbar">
            <ul>
                @if((Auth::user()->profile && Auth::user()->profile->role == 'student') || (Auth::user()->profile && Auth::user()->profile->role != 'student' && Auth::user()->confirmation == 1))
                <!-- book -->
                <li id="link-book" class="nav-link mb-3"><i class="bx bx-book"></i><span role="button" data-bs-toggle="collapse" data-bs-target="#submenu-book" aria-expanded="true" aria-controls="submenu-book">Book<i class='bx bx-chevron-down nav-drop'></i></span></li>
                <ul class="bx-ul collapse nav-submenu mb-3" id="submenu-book">
                    <li id="link-book-index" class="nav-list"><a href='/'><i class="bx bx-search-alt-2"></i>Search</a></li>
                    <li id="link-book-create" class="nav-list"><a href='/book/create'><i class="bx bx-mail-send"></i>Submission</a></li>
                    <li id="link-book-bookmark" class="nav-list"><span role="button" onclick="modalBookmark()"><i class="bx bx-bookmarks"></i>Bookmarks</span></li>
                </ul>
                <!-- book end -->
                @endif
                <!-- user -->
                <li id="link-user" class="nav-link mb-3"><i class="bx bx-user"></i><span role="button" data-bs-toggle="collapse" data-bs-target="#submenu-user" aria-expanded="true" aria-controls="submenu-user">User<i class='bx bx-chevron-down nav-drop'></i></span></li>
                <ul class="bx-ul collapse nav-submenu mb-3" id="submenu-user">
                    <li id="link-user-profile" class="nav-list"><a href='/profile'><i class="bx bxs-user"></i>Profile</a></li>
                    @if((Auth::user()->profile && Auth::user()->profile->role == 'student') || (Auth::user()->profile && Auth::user()->profile->role != 'student' && Auth::user()->confirmation == 1))
                    <li id="link-user-activity" class="nav-list"><a href='/activity'><i class="bx bx-time-five"></i>Activity</a></li>
                    @endif
                    <li id="link-user-logout" class="nav-list"><a href='/logout'><i class="bx bx-log-out-circle"></i>Sign out</a></li>
                </ul>
                <!-- user end -->
                <!-- admin start -->
                @if(Auth::user()->authority->name != 'user')
                <li id="link-admin" class="nav-link mb-3"><i class="bx bx-crown"></i><span role="button" data-bs-toggle="collapse" data-bs-target="#submenu-admin" aria-expanded="true" aria-controls="submenu-admin">Admin<i class='bx bx-chevron-down nav-drop'></i></span></li>
                <ul class="bx-ul collapse nav-submenu mb-3" id="submenu-admin">
                    <li id="link-admin-user" class="nav-list"><a href='/admin/user'><i class="bx bxs-user"></i>User controller</a></li>
                    <li id="link-admin-book" class="nav-list"><a href='/admin/book'><i class="bx bxs-book"></i>Book controller</a></li>
                </ul>
                @endif
                <!-- admin end -->
            </ul>
        </nav>
    </div>
    @endauth
    @guest
    <div class="px-3 mb-3">
        <button class="w-100 btn btn-outline-light gap-2" onclick="modal_login_show()"><i class="bx bx-log-in"></i>Sign in</button>
    </div>
    @endguest
</div>
</header>
<!-- ======================================= sidebar end ================================================== -->
  
@guest
@include('layouts/partials/modal_auth')
@endguest

<section id="section-header-dashboard" class="bg-white py-3 shadow">
    <div id="container-header-dashboard" class="container-fluid pe-0">
        <div class="row m-0">
            <div class="col-md-12 text-primary d-flex align-items-center flex-remove-md justify-content-between">
                <div class="col d-flex align-items-center gap-3">
                    <span id="toggle-sidebar" role="button" class="btn"><i class='bx bx-menu'></i></span>
                    <h1 class="fs-18 display-5 d-flex align-items-center mb-0">@if(isset($dashboard_header)){!! $dashboard_header !!}@else<i class="bx bxs-dashboard me-3"></i><span>Dashboard</span>@endif</h1>
                </div>
                @if(Auth::check() && Auth::user()->profile)
                <div class="col d-flex align-items-center">
                    @include('layouts/partials/searchbar')
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- ======= Main content ======= -->
<main id="main">
@yield('content')
</main>
<!-- ======= Main content end ======= -->

<!-- ======= Mobile nav toggle button ======= -->
<i class="bi bi-list mobile-nav-toggle bg-dark d-xl-none"></i>

@auth
<!-- modal bookmark start -->
<div class="modal fade" id="modal-bookmark" aria-hidden="true"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title d-flex align-items-center gap-2"><i class='bx bx-bookmarks'></i><span>Bookmarks</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    @forelse(Auth::user()->bookmark as $item)
                    <div class="list-group-item">
                        <p class="fs-11 mb-0">
                            <a href="/book/{{$item->book->id}}" class="hover-primary">{{$item->book->title}}</a>
                            @if($item->book->author)
                            by <a href="/book?search={{$item->book->author}}" class="hover-primary">{{$item->book->author}}</a>
                            @endif
                        </p>
                    </div>
                    @empty
                    <div class="list-group-item">
                        <p class="fs-11 fst-italic text-muted mb-0">You haven't saved any book yet</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal bookmark end -->
@endauth

<!-- Vendor JS Files -->
<script src="{{ asset('/vendor/axios/axios.js') }}"></script>
<script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('/vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/vendor/popper/popper.min.js') }}"></script>

<!-- JS Files -->
<script src="{{ asset('/js/main.js') }}"></script>

<script type="text/javascript">
@auth
const user_id = '{{Auth::user()->id}}';
const modalBookmark = () => {
    $('#modal-bookmark').modal('show');
};
@endauth
// const domain = window.location.host+'/';
const domain = 'http://localhost:8000/';
// const domain = 'https://library.pribadidepok.sch.id/';

// toggle sidebar
var sidebar_show = true;
var sidebar_width = $('#sidebar-dashboard').outerWidth();
$('#toggle-sidebar').click(function() {
    toggleSidebar(sidebar_show);
});
$('.mobile-nav-toggle').click(function() {
    toggleSidebar(sidebar_show);
});
$(window).resize(function() {
    if($(window).width() < 1199) {
        $('#sidebar-dashboard').css('left', sidebar_width*-1);
        $('#container-header-dashboard').css({'padding-left': 0, 'padding-right': 0});
        $('#main').css('padding-left', 0);
        sidebar_show = false;
    } else {
        $('#sidebar-dashboard').css('left', 0);
        $('#container-header-dashboard').css('padding-left', sidebar_width);
        $('#main').css('padding-left', sidebar_width);
        sidebar_show = true;
    }
});
function toggleSidebar(show) {
    if(show == true) {
        $('#sidebar-dashboard').css('left', sidebar_width*-1);
        if($(window).width() > 1199) {
        $('#container-header-dashboard').css({'padding-left': 0, 'padding-right': 0});
          $('#main').animate({'padding-left': 0});
        }
        sidebar_show = false;
    } else {
        $('#sidebar-dashboard').css('left', 0);
        if($(window).width() > 1199) {
          $('#container-header-dashboard').animate({'padding-left': sidebar_width});
          $('#main').animate({'padding-left': sidebar_width});
        }
        sidebar_show = true;
    }
};

$(document).ready(function(){
    if($(window).width() < 1199) {
        $('#sidebar-dashboard').removeClass('show');
        sidebar_show = false;
    } else {
        $('#sidebar-dashboard').removeClass('show').addClass('show');
        sidebar_show = true;
    }
    
    // popperjs
    $('.popper').popover({
        trigger: 'hover',
        html: true,
        placement: 'bottom',
        container: 'body'
    });
    @if(session('success'))
        successMessage("{{ session('success') }}");
    @elseif(session('error'))
        errorMessage("{{ session('error') }}");
    @elseif(session('info'))
        infoMessage("{{ session('info') }}");
    @endif
});

@if(isset($_GET['info']))
    Swal.fire({
      icon: 'info',
      title: "{{$_GET['info']}}",
      showConfirmButton: false,
      timer: 3000
    });
@endif

function successMessage(message) { toastr.success(message, 'Success!'); } 
function infoMessage(message) { toastr.info(message, 'Info'); } 
function warningMessage(message) { toastr.error(message, 'Warning!'); } 
function errorMessage(message) { toastr.error(message, 'Error!'); } 
</script>

@stack('scripts')
</body>

</html>