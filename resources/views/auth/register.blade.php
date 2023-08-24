<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="description" content="Blank Laravel Template by irzafarabi.com" />
<meta name="keywords" lan="en" content="blank, laravel, template" />
<meta property="og:image" content="{{ asset('img/bg/office-1.jpg') }}" />

<!-- Vendor JS Files -->
<script src="{{ asset('/vendor/jquery/jquery-3.1.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script> <!-- intl-tel-input plugin -->

<!-- Favicons -->
<link href="{{ asset('/img/logo/logo.png') }}" rel="icon"/>
<link href="{{ asset('/img/logo/logo.png') }}" rel="apple-touch-icon"/>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet"/>
<link href="{{ asset('/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/toastr/toastr.min.css') }}" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/> <!-- intl-tel-input plugin -->

<!-- Main CSS File -->
<link href="{{ asset('/css/style.css') }}" rel="stylesheet"/>

<title>Laravel | Register</title>
  
<style>
#section-register {
    background: url('../img/bg/bg_trans-80.png') top left repeat, url("../img/bg/office-1.jpg") top center transparent fixed;
    background-size: cover;
}
#container-form-register { background: #fff; padding: 60px 40px; border-radius: 8px; }
.form-label { color: #149ddd; }

.iti { width: 100%; }
</style>
</head>
<body>

<section id="section-register">
    <div class="container py-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div id="container-form-register" class="col-md-8">
                <h1 class="display-5">Laravel Blank Template</h1>
                <p class="mb-40">Register a new account</p>

                <form id="form-register" action="/register" method="POST">
                @csrf
                    @if(session('success'))
                    <div class="alert alert-success mt-2" role="alert">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger mt-2" role="alert">{{ session('error') }}</div>
                    @endif  
                    
                    <div class="mb-3 title-dark">
                        <h5>User Account</h5>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" id="email" class="form-control" name="email" placeholder="Email Address" value="@error('email') {{ old('email') }} @enderror" required>
                        <label for="email" class="form-label">Email</label>
                    </div>
                    @error('email')
                    <div class="alert alert-danger mt-2">{{$message}}</div>
                    @enderror

                    <div class="form-floating">
                        <input type="password" id="password" class="form-control mb-3" name="password" placeholder="Password" required>
                        <label for="password" class="form-label">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                        <label for="password_confirmation" class="form-label">Confirm password</label>
                        @error('password')
                        <br><div class="alert alert-danger mt-2">{{$message}}</div>
                        @enderror
                        @error('password_confirmation')
                        <br><div class="alert alert-danger mt-2">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="mb-3 title-dark">
                        <h5>Profile</h5>
                    </div>
                    
                    <!-- full name -->
                    <div class="form-group mb-3 d-flex">
                        <div class="form-floating col">
                            <input type="name" id="first_name" class="form-control" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" required>
                            <label for="first_name" class="form-label">First name</label>
                        </div>
                        <span>&ensp;</span>
                        <div class="form-floating col">
                            <input type="name" id="last_name" class="form-control" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required>
                            <label for="last_name" class="form-label">Last name</label>
                        </div>
                    </div>
                    @error('first_name')
                    <div class="alert alert-danger mt-2">{{$message}}</div>
                    @enderror
                    @error('last_name')
                    <div class="alert alert-danger mt-2">{{$message}}</div>
                    @enderror
                    <!-- full name end -->

                    <!-- whatsapp number -->
                    <div class="form-group mb-3">
                        <label class="text-muted mb-2">WhatsApp / contact number</label>
                        <div class="d-flex mb-2">
                            <input type="tel" id="contact" name="contact" class="form-control" value="{{ old('contact') }}" placeholder="821-8270-7310">
                        </div>
                    </div>
                    <!-- whatsapp number end -->

                    <!-- gender -->
                    <div class="form-floating mb-3">
                        <select id="gender" name="gender" class="form-control form-select" required>
                            <option value="select" selected disabled hidden>Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <label for="gender" class="form-label">Gender</label>
                        @error('gender')
                        <div class="alert alert-danger mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <!-- gender end -->

                    <!-- birth -->
                    <div class="form-group mb-3">
                        <label class="text-muted mb-2">Birth place / date</label>
                        <div class="d-flex">
                            <div class="form-floating col">
                                <input type="text" class="form-control" name="birth_place" placeholder="Birth place" value="{{ old('birth_place') }}">
                                <label for="birth_place" class="form-label">Birth place</label>
                            </div>
                            <span>&ensp;</span>
                            <div class="form-floating col">
                                <input type="date" min="1950-01-01" max="{{date('Y-m-d', time())}}" id="birth_date" class="form-control" name="birth_date" value="{{date('Y-m-d', time())}}" required>
                                <label for="birth_date" class="form-label">Birth date</label>
                            </div>
                        </div>
                    </div>
                    <!-- birth end -->

                    <!-- address -->
                    <div class="form-group mb-3">
                        <label class="text-muted mb-2">Address</label>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="address_street" placeholder="Street" value="{{ old('street') }}">
                                <label for="street" class="form-label">Street</label>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="form-floating col">
                                <input type="text" class="form-control" name="address_city" placeholder="City" value="{{ old('city') }}">
                                <label for="city" class="form-label">City / Districts</label>
                            </div>
                            <span>&ensp;</span>
                            <div class="form-floating col">
                                <input type="text" class="form-control" name="address_province" placeholder="Province" value="{{ old('province') }}">
                                <label for="province" class="form-label">Province</label>
                            </div>
                            <span>&ensp;</span>
                            <div class="form-floating col">
                                <input type="number" class="form-control" name="zip" placeholder="Zip" value="{{ old('zip') }}">
                                <label for="zip" class="form-label">ZIP code</label>
                            </div>
                        </div>
                    </div>
                    <!-- address -->

                    <div class="mb-5">
                        <p class="text-muted fst-italic mb-3">*You may use "-" for string or "0" for number if you wish to fill certain input field with blank</p>
                        <p><input type="checkbox" id="agreement" name="agreement" class="form-checkbox mr-8">By signing this, I  agree to the <a href="" target="_blank">privacy policy</a> and <a href="" target="_blank">terms of service</a>.</p>
                    </div>
                    

                    <div class="pt-1 mb-3">
                        <a class="btn btn-outline-danger mr-8" href="/login" type="button"><i class='bx bx-arrow-back' ></i> Back to Login Page</a>
                        <button class="btn btn-outline-primary" type="submit"><i class='bx bx-user-plus' ></i> Register</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<!-- Vendor JS Files -->
<script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('/vendor/toastr/toastr.min.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('/js/main.js') }}"></script>


<script type="text/javascript">
$(document).ready(function(){
    
    // Input contact
    const input_contact = document.querySelector("#contact");
    const iti = window.intlTelInput(input_contact, {
        separateDialCode: true,
        placeholderNumberType: "none",
        initialCountry: "id",
        preferredCountries: ["id", "de", "us"],  
        utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    $("#form-register").submit(function(e){
        e.preventDefault();
        
        let number = iti.getNumber();
        $('#contact').val(number);

        if($('input[name="agreement"]').is(":checked")) {
            e.currentTarget.submit();
        } else {
            Swal.fire({
                icon: 'error',
                title: "Unable to Register",
                text: "You need to check our privacy policy and terms of service!",
                showConfirmButton: true,
            });
        }
    });
});
</script>

</body>
</html>