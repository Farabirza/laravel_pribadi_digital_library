<style>
:root {
  --sidebar-width: 300px;
}
a:hover { color: inherit }
/* ========================== Navigation start ========================== */
#sidebar-dashboard {
    z-index: 999;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: var(--sidebar-width);
    padding: 20px;
    transition: all ease-in-out 0.5s;
    transition: all 0.5s;
    overflow-y: auto;
    background: #2196f4;
} .mobile-nav-toggle {
  position: fixed;
  right: 15px;
  top: 15px;
  z-index: 9998;
  border: 0;
  font-size: 24px;
  transition: all 0.4s;
  outline: none !important;
  color: #fff;
  width: 40px;
  height: 40px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  line-height: 0;
  border-radius: 50px;
  cursor: pointer;
} .mobile-nav-active {
  overflow: hidden;
} .mobile-nav-active #sidebar-dashboard {
  left: 0;
}

/* ========================== Navigation start ========================== */
/* Desktop Navigation */
.nav-menu * { margin: 0; padding: 0; list-style: none; }
.nav-menu ul { width: 100%; }
.nav-menu > ul > li {
  position: relative;
  white-space: nowrap;
}
.nav-menu .nav-link, .nav-menu li:focus {
  display: flex;
  align-items: center;
  color: #fff;
  margin-bottom: 8px;
  transition: 0.3s;
  font-size: 15px;
}
.nav-menu li i, .nav-menu li:focus i {
  font-size: 24px;
  padding-right: 8px;
  color: #fff;
}
.nav-menu li:hover, .nav-menu .active, .nav-menu .active:focus, .nav-menu li:hover > a {
  text-decoration: none;
  color: #fff;
  cursor: pointer;
}
.nav-menu li:hover i, .nav-menu .active i, .nav-menu .active:focus i, .nav-menu li:hover > a i { color: #fff; }
.dropdown-divider { margin: 0 20px; }
.nav-drop { position: absolute; right: 0; }

.nav-submenu { color: #fff; font-size: 10pt; text-indent: 2em; margin-bottom: 10px; }
.nav-submenu a:hover { color: var(--bs-light); }

.nav-list { font-size: 11pt; padding-bottom: 15px; }
/* ========================== Navigation end ========================== */

#section-header-dashboard { position: relative; }

#main, #container-header-dashboard {
    padding-left: var(--sidebar-width);
}

#section-content { padding: 30px 20px; }

#sidebar-dashboard { color: #fff; }
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
    #section-content { padding: 30px 1%; }
}

@media (max-width: 1199px) {
    #toggle-sidebar { display: none; }
    #main, #container-header-dashboard { padding-left: 0; padding-right: 0 }
    #sidebar-dashboard {
        left: calc(var(--sidebar-width) * -1);
    }
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

 <!-- ======================================= sidebar start ================================================== -->
 <header>
 <div id="sidebar-dashboard" class="d-flex flex-column flex-shrink-0">
    <div class="mb-4 px-3">
        <a href='/' class="text-center"><img src="{{asset('img/logo/logo-pribadi-white.png')}}" class="d-block"></a>
    </div>
    @auth
    @if(Auth::user()->profile)
    <div class="d-flex align-items-center gap-3 p-2 border border-light mb-3">
        <div>
            <img src="{{ asset('img/profiles/user.jpg') }}" alt="" class="rounded" style="max-height:100px">
        </div>
        <div class="col">
            <p class="mb-0 fw-500"><a href="/profile">{{ Auth::user()->profile->full_name }}</a></p>
            <p class="fst-italic mb-0 em-8">{{ Auth::user()->profile->role }}</p>
            @if(Auth::user()->authority->name != 'user')
            <p class="mb-0 mt-1"><span class="badge bg-light text-primary">{{ Auth::user()->authority->name }}</span></p>
            @endif
        </div>
    </div>
    @endif
    <div id="sidebar-menu" class="py-3 px-3">
        <nav class="nav-menu navbar">
            <ul>
                <!-- book -->
                <li id="link-book" class="nav-link mb-3"><i class="bx bx-book"></i><span role="button" data-bs-toggle="collapse" data-bs-target="#submenu-book" aria-expanded="true" aria-controls="submenu-book">Book<i class='bx bx-chevron-down nav-drop'></i></span></li>
                <ul class="bx-ul collapse nav-submenu mb-3" id="submenu-book">
                    <li id="link-book-index" class="nav-list"><a href='/book'><i class="bx bx-search-alt-2"></i>Search</a></li>
                    <li id="link-book-create" class="nav-list"><a href='/book/create'><i class="bx bx-mail-send"></i>Submission</a></li>
                    <li id="link-book-bookmark" class="nav-list"><span role="button" onclick="modalBookmark()"><i class="bx bx-bookmarks"></i>Bookmarks</span></li>
                </ul>
                <!-- book end -->
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

<section id="section-header-dashboard" class="bg-white py-3 shadow">
    <div id="container-header-dashboard" class="container-fluid pe-0">
        <div class="row m-0">
            <div class="col-md-12 text-primary d-flex align-items-center flex-remove-md justify-content-between px-3">
                <div class="col d-flex align-items-center gap-3">
                    <span id="toggle-sidebar" role="button" onclick="toggleSidebar()"><i class='bx bx-menu'></i></span>
                    <h1 class="fs-18 display-5 d-flex align-items-center mb-0">
                        @if(isset($dashboard_header))
                        {!! $dashboard_header !!}
                        @else
                        <i class="bx bxs-dashboard me-3"></i><span>Dashboard</span>
                        @endif
                    </h1>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Mobile nav toggle button ======= -->
<i class="bi bi-list mobile-nav-toggle bg-dark d-xl-none" role="button" onclick="toggleSidebar()"></i>

<script>
// sidebar start
var sidebar_show = true;
var sidebar_width = $('#sidebar-dashboard').outerWidth();
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
function toggleSidebar() {
    if(sidebar_show == true) {
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
});
// sidebar end
</script>