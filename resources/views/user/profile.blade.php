@extends('layouts.master')

@push('css-styles')
<link href="{{ asset('/vendor/cropper/cropper.min.css') }}" rel="stylesheet">
<style>
.card-img-overlay { opacity: 0; color: #fff; }
.card-img-overlay:hover { background: rgba(0, 0, 0, 0.5); opacity: 1; transition: ease-in-out .4s; cursor: pointer; }
.form-label { color: var(--bs-primary); }

.user-picture-cropper-preview { overflow: hidden; height: 180px; border: 1px solid var(--color-3); }
</style>
@endpush
@section('content')

<section id="section-profile" class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            @if(!Auth::user()->profile)
            <div class="col-md-12 mb-3">
                <div class="alert alert-success">
                    <h1 class="display-5 fs-30">Congratulations!</h1>
                    <p class="fs-11">You have successfully registered, one last step and you are good to go :)</p>
                </div>
            </div>
            @else
            <div class="col-md-12 bg-light py-3 border mb-3">
                <div class="d-flex justify-content-center align-items-center gap-5">
                    <div>
                        <div class="card p-2 shadow-sm mb-3">
                            @if(Auth::user()->picture)
                            <img id="user-picture" src="{{asset('img/profiles/'.Auth::user()->picture)}}" alt="" class="card-img" style="height:320px"/>
                            @else
                            <img id="user-picture" src="{{asset('img/profiles/user.jpg')}}" alt="" class="card-img" style="height:320px"/>
                            @endif
                            <label for="input-user-picture">
                            <div class="card-img-overlay d-flex">
                                <div class="m-auto text-light text-center">
                                    <span class="text-white">Change profile picture</span>
                                </div>
                            </div>
                            </label>
                        </div>
                        <p class="text-center text-primary">Profile picture</p>
                        <form id="form-user-picture" action="/update_picture" enctype="multipart/form-data" method="POST">
                            <input id="input-user-picture" class="absolute d-none" name="input-user-picture" type="file" accept="image/*">
                        </form>
                    </div>
                    <div class="w-50">
                        <label for="modal-register-username" class="form-label">Username</label>
                        <div class="input-group mb-3">
                            <input type="text" name="username" id="modal-register-username" class="form-control form-control-sm" placeholder="Username" value="{{Auth::user()->username}}" required>
                            <span class="input-group-text hover-pointer fs-10 d-flex align-items-center" onclick="handleUsername()"><i class='bx bx-search me-2' ></i>Check username</span>
                        </div>
                        <div class="mb-3">
                            <p id="username-check-result" class="mb-0 fs-10"><span class="fst-italic text-secondary">*please check the username availability first</span></p>
                        </div>
                        <div class="mb-4 d-flex align-items-center">
                            <hr class="col me-3"/>
                            <button id="btn-username-change" class="btn btn-primary btn-sm d-flex align-items-center disabled" onclick="changeUsername()"><i class="bx bxs-user me-2"></i>Change username</button>
                        </div>
                        <div class="mb-4">
                            <label for="profile-email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" value="{{Auth::user()->email}}" disabled>
                        </div>
                        <label for="profile-password" class="form-label">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" name="password" id="profile-password" class="input form-control" placeholder="Password" value="" required>
                            <span class="input-group-text hover-pointer" onclick="togglePassword(password_visible)">
                                <i class='btn-password-toggle bx bx-show-alt'></i>
                            </span>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>
                        <div class="mb-3">
                            <p id="password-message" class="fs-10 mb-0"></p>
                        </div>
                        <div class="mb-4 d-flex align-items-center">
                            <hr class="col me-3"/>
                            <button class="btn btn-primary btn-sm d-flex align-items-center" onclick="updatePassword()"><i class="bx bx-key me-2"></i>Change password</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-12 mb-3">
                <form action="/profile/update" method="post" id="form-profile" class="m-0">
                <div class="d-flex gap-3 mb-3">
                    <div class="col">
                        <label for="first_name" class="form-label">First name*</label>
                        <input type="text" name="first_name" class="form-control" placeholder="first name" value="" required>
                    </div>
                    <div class="col">
                        <label for="last_name" class="form-label">Last name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="last name">
                    </div>
                </div>
                <div class="d-flex gap-3 mb-3">
                    <div class="col">
                        <label for="gender" class="form-label">Gender*</label>
                        <select name="gender" id="profile-gender" class="form-control form-select" required>
                            <option value="select" selected disabled hidden>Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="birth_date" class="form-label">Birth date</label>
                        <input type="date" min="1950-01-01" max="{{date('Y-m-d', time())}}" id="profile-birth_date" class="form-control" name="birth_date" value="">
                    </div>
                </div>
                <div class="mb-2">
                    <span class="text-primary fw-bold fs-11">Domicile</span>
                </div>
                <div class="d-flex gap-3 mb-3">
                    <div class="col">
                        <label for="address_city" class="form-label fs-10">City</label>
                        <input type="text" name="address_city" class="form-control" placeholder="city">
                    </div>
                    <div class="col">
                        <label for="address_province" class="form-label fs-10">Province</label>
                        <input type="text" name="address_province" class="form-control" placeholder="province">
                    </div>
                    <div class="col">
                        <label for="address_zip" class="form-label fs-10">ZIP code</label>
                        <input type="number" class="form-control" name="address_zip" placeholder="ZIP" value="" maxlength="5">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="biodata" class="form-label">Biodata</label>
                    <textarea name="biodata" id="biodata" cols="30" rows="4" class="form-control" placeholder="tell us about yoursself"></textarea>
                </div>
                <div class="mb-3">
                    <p class="fs-11 fst-italic text-secondary mb-0">*) required</p>
                </div>
                <div class="d-flex align-items center mb-3">
                    <hr class="col me-3"/>
                    <button type="submit" class="btn btn-success d-flex align-items-center"><i class='bx bxs-save me-2' ></i>Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>


<!-- modal image cropper -->
<div class="modal fade" id="modal-user-picture-cropper" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title d-flex align-items-center fw-bold"><i class='bx bx-selection me-2'></i><span>Select picture</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="img-crop" src="">
                        </div>
                        <div class="col-md-4">
                            <div class="user-picture-cropper-preview mx-3 mb-3"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary d-flex align-items-center" data-bs-dismiss="modal"><i class='bx bx-exit me-2' ></i>Cancel</button>
                <button type="button" class="btn btn-primary d-flex align-items-center" id="user-picture-crop"><i class='bx bx-crop me-2' ></i>Crop</button>
            </div>
        </div>
    </div>
</div>
<!-- modal image cropper end -->

@endsection
@push('scripts')>
<script src="{{ asset('/vendor/cropper/cropper.min.js') }}"></script>
@if(Auth::user()->profile)
<script type="text/javascript">
    $(document).ready(function(){
        let first_name = '{{$profile->first_name}}';
        let last_name = '{{$profile->last_name}}';
        let gender = '{{$profile->gender}}';
        let birth_date = '{{$profile->birth_date}}';
        let address_city = '{{$profile->address_city}}';
        let address_province = '{{$profile->address_province}}';
        let address_zip = '{{$profile->address_zip}}';
        let biodata = '{{$profile->biodata}}';
        $('[name="first_name"]').val(first_name);
        $('[name="last_name"]').val(last_name);
        $('[name="gender"] option[value="'+gender+'"]').prop('selected', true)
        $('[name="birth_date"]').val(birth_date);
        $('[name="address_city"]').val(address_city);
        $('[name="address_province"]').val(address_province);
        $('[name="address_zip"]').val(address_zip);
        $('[name="biodata"]').val(biodata);
    });
</script>
@endif
<script type="text/javascript">
const handleUsername = () => {
    let result = $('#username-check-result');
    let username = $('[name="username"]').val();
    result.html('<span class="btn spinner"></span>');
    var config = {
        method: 'post', url: this.domain + 'api/user',
        data: {
            action: 'check_username', username: username,
        },
    }
    axios(config)
    .then((response) => {
        if(response.data.available) {
            result.html('<span class="fs-bold text-success"><i class="bx bx-check-double me-1" ></i>' + response.data.response_message + '</span>');
            $('#btn-username-change').removeClass('disabled');
        } else {
            if(response.data.response_message.length > 1) {
                result.html('');
                response.data.response_message.forEach(messages);
                function messages(item, index) {
                    result.append('<span class="fs-bold text-danger"><i class="bx bx-error me-1" ></i>' + item + '</span><br/>');
                }
            } else {
                result.html('<span class="fs-bold text-danger"><i class="bx bx-error me-1" ></i>' + response.data.response_message + '</span>');
            }
            $('#btn-username-change').removeClass('disabled').addClass('disabled');
        }
    })
    .catch((error) => {
        console.log(error);
    });
}

const changeUsername = () => {
    let username = $('[name="username"]').val();
    var config = {
        method: 'post', url: this.domain + 'api/user',
        data: {
            action: 'change_username', username: username,
        },
    }
    axios(config)
    .then((response) => {
        if(response.data.error == true) {
            errorMessage(response.data.message);
        } else {
            successMessage(response.data.message);
            $('#btn-username-change').removeClass('disabled').addClass('disabled');
        }
    })
    .catch((error) => {
        console.log(error);
    });
}

$('[name="username"]').keyup(function(){
    $('#btn-username-change').removeClass('disabled').addClass('disabled');
    $('#username-check-result').html('<span class="fst-italic text-secondary">*please check username availability first</span>');
})

var password_visible = false;
const togglePassword = () => {
    let input = $('[name="password"]');
    let input_confirm = $('[name="password_confirmation"]');
    let input_btn = $('.btn-password-toggle');
    if(password_visible == false) {
        input.attr("type", "text");
        input_confirm.attr("type", "text");
        input_btn.removeClass('bx-show-alt').addClass('bx-hide');
        password_visible = true;
    } else {
        input.attr("type", "password");
        input_confirm.attr("type", "password");
        input_btn.removeClass('bx-hide').addClass('bx-show-alt');
        password_visible = false;
    }
}

const updatePassword = () => {
    let password_message = $('#password-message');
    var config = {
        method: 'post', url: this.domain + 'api/user',
        data: {
            action: 'update_password', password: $('[name="password"]').val(), password_confirmation: $('[name="password_confirmation"]').val(),
        },
    }
    axios(config)
    .then((response) => {
        if(response.data.error == true) {
            password_message.html('');
            if(response.data.message.length > 1) {
                response.data.message.forEach(password_messages);
                function password_messages(item, index) {
                    password_message.append('<span class="fs-bold text-danger"><i class="bx bx-error me-1" ></i>' + item + '</span><br/>');
                }
            } else {
                password_message.html('<span class="fs-bold text-danger"><i class="bx bx-error me-1" ></i>' + response.data.message + '</span>');
            }
        } else {
            password_message.html('');
            successMessage(response.data.message);
            $('[name="password"]').val(''); $('[name="password_confirmation"]').val('');
        }
    })
    .catch((error) => {
        console.log(error);
    });
}

$('#form-profile').submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);
    formData.append('action', 'update_profile');
    var config = {
        method: 'post', url: domain + 'api/profile',
        data: formData,
    }
    axios(config)
    .then((response) => {
        successMessage(response.data.message);
    })
    .catch((error) => {
        console.log(error);
    });
});

$('input[name=input-user-picture]').change(function(e){
    var modal = $('#modal-user-picture-cropper');
    var image = document.getElementById('img-crop');
    var cropper;
    modal.modal('show');

    let reader = new FileReader();
    reader.onload = (e) => { 
        $('#img-crop').attr('src', e.target.result); 
    }
    reader.readAsDataURL(this.files[0]); 

    modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
        aspectRatio: 1, viewMode: 3, preview: '.user-picture-cropper-preview',
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });
    $("#user-picture-crop").click(function(){
        var canvas = cropper.getCroppedCanvas({
            width: 320,
            height: 320,
        });
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob); 
            reader.onloadend = function() {
                var base64data = reader.result; 
                var config = {
                    method: 'post', url: domain + 'api/user',
                    data: {
                        action: 'update_picture', picture: base64data,
                    },
                }
                axios(config)
                .then((response) => {
                    if(response.data.error == false) {
                        successMessage(response.data.message);
                        $('#user-picture').attr('src', domain + 'img/profiles/' + response.data.picture_name);
                        $('#sidebar-user-picture').attr('src', domain + 'img/profiles/' + response.data.picture_name);
                    } else {
                        errorMessage(response.data.message);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
                $('.modal').modal('hide');
            }
        });
    });
});
</script>
@endpush