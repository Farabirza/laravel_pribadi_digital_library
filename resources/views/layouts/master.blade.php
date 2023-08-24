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
<link href="{{ asset('/css/style.css') }}?v=1" rel="stylesheet">

@if(isset($page_title))
<title>{{$page_title}}</title>
@else
<title>cvkreatif.com</title>
@endif
  
@stack('css-styles')
<style>
@media (max-width: 768px) {
}

@media (max-width: 1199px) {
}
</style>
</head>
<body>
  
<!-- ======= Main content ======= -->
<main id="main">
@yield('content')
</main>
<!-- ======= Main content end ======= -->

<!-- Vendor JS Files -->
<script src="{{ asset('/vendor/axios/axios.js') }}"></script>
<script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('/vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/vendor/popper/popper.min.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('/js/main.js') }}"></script>

<script type="text/javascript">
// const domain = window.location.host+'/';
const domain = 'http://localhost:8000/';
// const domain = 'https://library.pribadidepok.sch.id/';

$(window).resize(function() {
  if($(window).width() < 1199) {
  } else {
  }
});
$(document).ready(function() {
  if($(window).width() < 1199) {
  } else {
  }
  
  // tooltip
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
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

@if(isset($error))
    Swal.fire({
      icon: 'error',
      title: "{{$error}}",
      showConfirmButton: false,
      timer: 3000
    });
@endif
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