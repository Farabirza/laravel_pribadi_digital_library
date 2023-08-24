<style>
#container-topbar { justify-content: end; }
@media(max-width: 1199px) {
  #container-topbar { justify-content: start; }
}
</style>

<nav class="navbar bg-body-tertiary">
  <div id="container-topbar" class="container-fluid d-flex align-items-center gap-3">
    <span class="fs-12">Welcome, {{Auth::user()->username}}</span>|
    <a href="/" class="fs-12"><i class="bx bxs-dashboard bx-border btn-outline-dark popper" title="Dashboard"></i></a>
    <i role="button" type="button" class="bx bx-palette bx-border btn-outline-dark popper" title="Preference" data-bs-toggle="offcanvas" data-bs-target="#sidebar-preference" aria-controls="sidebar-preference"></i>
  </div>
</nav>

@include('themes.preference.preference_'.$theme->file_name)

