<style>
    #navbar { padding: 12px; box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2); }
    .nav-item { margin-left: 6px; }
    #user-img { width: 40px; }
</style>

<div id="section-navbar">
    <nav id="navbar" class="navbar fixed-top navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a href="/home" class="navbar-brand">Logo</a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto">
                    @if(Auth::user()->role != 'user')
                    <li class="nav-item dropdown">
                        <a href="#" role="button" class="nav-link nav-link-admin dropdown-toggle" data-bs-toggle="dropdown"><i class='bx bxs-user mr-4'></i> Admin &nbsp;</a>
                        <ul class="dropdown-menu">
                            <li><a href="/dashboard" class="dropdown-item"><i class='bx bxs-dashboard mr-4' ></i> Dashboard</a></li>
                            <li><a href="/admin_news" class="dropdown-item"><i class='bx bx-news mr-4' ></i> News</a></li>
                            <li><a href="/statistics" class="dropdown-item"><i class='bx bx-line-chart mr-4' ></i> Statistics</a></li>
                        </ul>
                    </li>
                    @endif
                    <li class="nav-item"><a href="/news" class="nav-link nav-link-news"><i class='bx bx-news mr-4' ></i> News</a></li>
                    <li class="nav-item"><a href="/assignments" class="nav-link nav-link-assignment" aria-current="page"><i class='bx bx-file mr-4' ></i> Assignments</a></li>
                    <li class="nav-item"><a href="/calendar" class="nav-link nav-link-calendar"><i class='bx bx-calendar mr-4' ></i> Calendar</a></li>
                    <li class="nav-item"><a href="/report" class="nav-link nav-link-report"><i class='bx bxs-report mr-4' ></i> Report</a></li>
                    <li class="nav-item"><a href="https://mitraleipzig.de/" class="nav-link nav-link-report" target="_blank"><i class='bx bx-link mr-4' ></i> Mitraleipzig.de</a></li>
                </ul>
                <div class="navbar-nav ms-auto">
                    @auth
                        <div class="dropdown nav-item d-flex vertical-center">
                            <a href="/profile"><img src="{{ asset('/img/profiles/'.Auth::user()->profile->image) }}" id="user-img" alt="" class="img-fluid rounded-circle box-shadow-2 mr-8">
                            <span class="mr-8">{{ Auth::user()->profile->first_name }} {{ Auth::user()->profile->last_name }}</span></a>
                            <i id="user-icon" class='bx bx-chevron-down' type="button" id="user-menu" data-bs-toggle="dropdown" aria-expanded="false"></i>
                            <ul class="dropdown-menu" aria-labelledby="user-menu">
                                <li><a class="dropdown-item" href="/profile"><i class='bx bx-user mr-4'></i> Profile</a></li>
                                <li class="mb-2"><a class="dropdown-item" href="/logout"><i class='bx bx-log-out mr-4' ></i> Logout</a></li>
                                <li class="mb-2"><hr class="dropdown-divider"></li>
                                <li class="dropdown-item text-center"><i class='bx bxs-star mr-4 text-warning'></i> @if(Auth::user()->star_point) {{Auth::user()->star_point->amount}} @else 0 @endif</li>
                            </ul>
                        </div>
                    @endauth
                    @guest
                        <a href="/login" class="nav-item nav-link">Login</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
</div>