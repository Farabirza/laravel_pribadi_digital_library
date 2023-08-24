@extends('layouts.master_sidebar')

@push('css-styles')
<link href="{{ asset('/vendor/cropper/cropper.min.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
<style>
body { background: #f9f9f9; min-height: 100vh; }
table thead th { font-weight: 500; }
img { max-width: 100%; }
.alert { font-size: 9pt; padding: 10px; }
.form-label { color: var(--bs-primary); font-size: 11pt; }

.card-img-overlay { opacity: 0; color: #fff; }
.card-img-overlay:hover { background: rgba(0, 0, 0, 0.5); opacity: 1; transition: ease-in-out .4s; cursor: pointer; }

.user-picture-cropper-preview { overflow: hidden; height: 180px; }

@media (max-width: 1199px) {
}
@media (max-width: 768px) {
}
</style>

@endpush

@section('content')

<section id="section-profile" class="px-3 py-5">
    <div class="container">
        <div class="row mb-2">
            <!-- breadcrumb start -->
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">User</li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
            <!-- breadcrumb end -->
        </div>
        <div class="row bg-white p-4 rounded shadow mb-4">
            @if(!$user->profile)
            <div class="col-md-12 mb-2">
                <div class="alert alert-success">
                    <h1 class="display-5 fs-30">Congratulations!</h1>
                    <p class="fs-11">You have successfully registered, one last step and you are good to go :)</p>
                </div>
            </div>
            @endif
            @if($user->profile)
            <div class="col-md-12 mb-2">
                <div class="d-flex flex-remove-md justify-content-center align-items-center gap-5 py-4 bg-light border mb-3">
                    <div class="mb-2">
                        <div class="card p-2 shadow-sm mb-3">
                            @if($user->picture)
                            <img id="user-picture" src="{{asset('img/profiles/'.$user->picture)}}" alt="" class="card-img user-picture" style="min-height:320px"/>
                            @else
                            <img id="user-picture" src="{{asset('img/profiles/user.jpg')}}" alt="" class="card-img user-picture" style="min-height:320px"/>
                            @endif
                            <label for="input-user-picture">
                            <div class="card-img-overlay d-flex">
                                <div class="m-auto text-light text-center">
                                    <span class="text-white">Change profile picture</span>
                                </div>
                            </div>
                            </label>
                        </div>
                        <form id="form-user-picture" action="/update_picture" enctype="multipart/form-data" method="POST">
                            <input id="input-user-picture" class="absolute d-none" name="input-user-picture" type="file" accept="image/*">
                        </form>
                        @if($user->profile->role == 'student')
                        <div class="d-flex justify-content-center gap-2 fs-11 mb-0">
                            <?php $current_grade = $user->profile->grade + date('Y', time()) - $user->profile->year_join; ?>
                            @if($current_grade <= 12)
                            <span id="student-grade" class="fw-bold">Grade {{$current_grade}}</span>
                            @endif
                            <span id="student-level">
                                @if($current_grade <= 6)
                                Elementary school
                                @elseif($current_grade >= 7 && $current_grade <= 9)
                                Junior high school
                                @elseif($current_grade >= 10 && $current_grade <= 12)
                                Senior high school
                                @else
                                <b>Alumni</b>
                                @endif
                            </span>
                        </div>
                        @else
                        <div class="text-center fs-11 mb-0 fw-bold text-capitalize"><span class="rounded px-3 text-light" style="background:#d4af37">{{$user->profile->role}}</span></div>
                        @endif
                    </div>
                    <div class="mb-2" style="min-widht:50%;">
                        <div class="mb-3">
                            <label for="user-email" class="form-label">Email</label>
                            <input type="text" id="user-email" class="form-control form-control-sm" value="{{$user->email}}" disabled>
                        </div>
                        <!-- change password start -->
                        <form action="action/user" method="post" id="form-update_password" class="m-0">
                        <div class="mb-3">
                            <label for="user-password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="user-password" class="input form-control form-control-sm" placeholder="Password" value="" required>
                                <span class="input-group-text hover-pointer" onclick="togglePassword(password_visible)">
                                    <i class='btn-password-toggle bx bx-show-alt'></i>
                                </span>
                            </div>
                        </div>
                        <div class=" mb-3">
                            <label for="user-password_confirmation" class="form-label">Confirm password</label>
                            <input type="password" id="user-password_confirmation" class="form-control form-control-sm" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>
                        <p id="alert-update_password" class="alert alert-danger d-none mb-3"></p>
                        <div class="d-flex align-items-center justify-content-end gap-3 mb-3">
                            <hr class="col">
                            <button type="button" class="btn btn-primary btn-sm gap-2" onclick="changePassword()"><i class="bx bx-key"></i>Change password</button>
                        </div>
                        </form>
                        <!-- change password end -->
                        <div class="mb-3">
                            <label for="user-authority" class="form-label">Authority</label>
                            <input type="text" id="user-authority" class="form-control form-control-sm" value="{{ucfirst($user->authority->name)}}" disabled>
                        </div>
                        <p class="fs-10 fst-italic text-secondary mb-0">*) only superadmin can change your authority</p>
                    </div>
                </div>
            </div>
            @endif
            <!-- user profile data start -->
            <div class="col-md-12">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-user"></i>User profile data</h3>
                <!-- form profile start -->
                @if($user->profile)
                <form action="profile/{{$user->profile->id}}" method="put" id="form-profile" class="m-0">
                @else
                <form action="profile" method="post" id="form-profile" class="m-0">
                @endif
                <div class="mb-3 d-flex flex-remove-md gap-3">
                    <div class="col">
                        <label for="profile-full_name" class="form-label">Full name*</label>
                        @if($user->profile)
                        <input type="text" id="profile-full_name" name="full_name" class="form-control form-control-sm mb-2" value="{{$user->profile->full_name}}">
                        @else
                        <input type="text" id="profile-full_name" name="full_name" class="form-control form-control-sm mb-2" value="">
                        @endif
                        <p class="fs-9 fst-italic text-secondary mb-0">*) required</p>
                        <p id="alert-profile-full_name" class="alert alert-danger d-none mt-2 mb-0"></p>
                    </div>
                    <div class="col">
                        <label for="profile-gender" class="form-label">Gender</label>
                        <select id="profile-gender" name="gender" class="form-select form-select-sm mb-2">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="profile-role" class="form-label">Role</label>
                    <select name="role" id="profile-role" class="form-select form-select sm">
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                        <option value="staff">Staff</option>
                        <option value="management">Management</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                @if($user->profile && $user->profile->role != 'student')
                <div id="profile-student-detail" class="mb-3 d-flex flex-remove-md gap-3 border rounded bg-light p-4 d-none">
                @else
                <div id="profile-student-detail" class="mb-3 d-flex flex-remove-md gap-3 border rounded bg-light p-4">
                @endif
                    <div class="col mb-2">
                        <label for="profile-year_join" class="form-label">Which year did you join Pribadi School Depok?</label>
                        @if($user->profile && $user->profile->year_join != null)
                        <input type="number" name="year_join" id="profile-year_join" class="form-control form-control-sm mb-2" placeholder="ex: {{date('Y', time())}}" value="{{$user->profile->year_join}}">
                        @else
                        <input type="number" name="year_join" id="profile-year_join" class="form-control form-control-sm mb-2" placeholder="ex: {{date('Y', time())}}" value="{{date('Y', time())}}">
                        @endif
                        <p id="alert-profile-year_join" class="alert alert-danger d-none mb-0"></p>
                    </div>
                    <div class="col mb-2">
                        <label for="profile-grade" class="form-label">Which grade were you at that time?</label>
                        <select name="grade" id="profile-grade" class="form-select form-select-sm mb-2">
                            <optgroup>
                                <option value="1">1st grade elementary school</option>
                                <option value="2">2nd grade elementary school</option>
                                <option value="3">3rd grade elementary school</option>
                                <option value="4">4th grade elementary school</option>
                                <option value="5">5th grade elementary school</option>
                                <option value="6">6th grade elementary school</option>
                            </optgroup>
                            <optgroup>
                                <option value="7">1st grade junior high school</option>
                                <option value="8">2nd grade junior high school</option>
                                <option value="9">3rd grade junior high school</option>
                            </optgroup>
                            <optgroup>
                                <option value="10">1st grade senior high school</option>
                                <option value="11">2nd grade senior high school</option>
                                <option value="12">3rd grade senior high school</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                @if($user->profile)
                <p class="mb-2 text-primary" style="font-weight:500">Address</p>
                <div class="mb-3 d-flex flex-remove-md gap-3">
                    <div class="col mb-2">
                        <label for="profile-address_street" class="form-label">Street</label>
                        <input type="text" id="profile-address_street" name="address_street" class="form-control form-control-sm" placeholder="ex: Jl. Margonda No.229" value="{{$user->profile->address_street}}">
                    </div>
                    <div class="col mb-2">
                        <label for="profile-address_city" class="form-label">City</label>
                        <input type="text" id="profile-address_city" name="address_city" class="form-control form-control-sm" placeholder="ex: Depok" value="{{$user->profile->address_city}}">
                    </div>
                    <div class="col mb-2">
                        <label for="profile-address_zip" class="form-label">ZIP code</label>
                        <input type="number" id="profile-address_zip" name="address_zip" class="form-control form-control-sm" placeholder="ex: 16423" value="{{$user->profile->address_zip}}">
                    </div>
                </div>
                <div class="mb-3 d-flex flex-remove-md gap-3">
                    <div class="col mb-2">
                        <label for="profile-birth_place" class="form-label">Birth place</label>
                        <input type="text" id="profile-birth_place" name="birth_place" class="form-control form-control-sm" placeholder="ex: Bandung" value="{{$user->profile->birth_place}}">
                    </div>
                    <div class="col mb-2">
                        <label for="profile-birth_date" class="form-label">Birth date</label>
                        <input type="date" min="1950-01-01" max="{{date('Y-m-d', time())}}" id="profile-birth_date" class="form-control form-control-sm" name="birth_date" value="{{$user->profile->birth_date}}">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="profile-biodata" class="form-label">Biodata</label>
                    <textarea name="biodata" id="profile-biodata" cols="30" rows="4" class="form-control" placeholder="tell us about yourself">{{$user->profile->biodata}}</textarea>
                </div>
                @endif
                <div class="d-flex align-items-center gap-3 mt-4">
                    <hr class="col">
                    <button type="button" class="btn btn-success gap-2" onclick="submitProfile()"><i class="bx bx-save"></i>Save</button>
                </div>
                </form>
                <!-- form profile end -->
            </div>
            <!-- user profile data end -->
        </div>
        
        @if($user->profile)
        <div id="section-saved-books" class="row bg-white p-4 rounded shadow mb-4">
            <!-- bookmark start -->
            <div class="col-md-12">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-bookmark"></i>Saved book</h3>
                <div class="fs-11 pe-3" style="max-height: 400px; overflow: auto">
                    <?php $i = 1; ?>
                    @forelse($user->bookmark as $bookmark)
                    <div class="mb-2 d-flex align-items-center gap-3">
                        <span>{{$i}} )</span>
                        <a href="/book/{{$bookmark->book->id}}" class="hover-primary">{{$bookmark->book->title}}</a>
                    </div>
                    <?php $i++; ?>
                    @empty
                    <p class="text-secondary fst-italic mb-0">You haven't saved any book</p>
                    @endforelse
                </div>
            </div>
            <!-- bookmark end -->
        </div>
        <div id="section-submitted-books" class="row bg-white p-4 rounded shadow mb-4">
            <!-- submitted book start -->
            <div class="col-md-12">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-book"></i>Submitted book</h3>
                <div class="fs-11 pe-3" style="max-height: 400px; overflow: auto">
                    <?php $i = 1; ?>
                    @forelse($user->book->sortByDesc('created_at') as $book)
                    <div class="mb-2 d-flex align-items-center gap-3">
                        <span>{{$i}} )</span>
                        <a href="/book/{{$book->id}}" class="hover-primary">{{$book->title}}</a>
                        <hr class="col">
                        <div class="d-flex gap-2">
                            <span class="text-muted">{{($book->status == 'confirmation' ? 'need confirmation' : $book->status)}}</span> |
                            <a href="/book/{{$book->id}}/edit" class="text-primary">Edit</a>
                        </div>
                    </div>
                    <?php $i++; ?>
                    @empty
                    <p class="text-secondary fst-italic mb-0">You haven't submitted any book</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="row bg-white p-4 rounded shadow mb-4">
            <!-- submitted book end -->
            <!-- Record start -->
            <div class="col-md-12">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-history"></i>Visit record</h3>
                <div class="table-container mb-3">
                    <table id="table-record" class="table table-striped">
                        <thead>
                            <th>Date of visit</th>
                            <th>Book title</th>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @forelse($user->logVisit->sortByDesc('created_at') as $record)
                            <tr>
                                <td>{{date('l, j F Y | h:i A', strtotime($record->created_at))}}</td>
                                @if($record->book)
                                <td><a href="/book/{{$record->book->id}}" class="text-primary">{{$record->book->title}}</a></td>
                                @else
                                <td>-</td>
                                @endif
                            </tr>
                            <?php $i++ ?>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Record end -->
        </div>
        @endif
    </div>
</section>


<!-- modal image cropper -->
<div class="modal fade" id="modal-user-picture-cropper" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center"><i class='bx bx-selection me-2'></i><span>Select picture</span></h5>
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
                            <p class="fs-10 fst-italic text-secondary mx-3 mb-0">*) select area for your profile picture</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class='bx bx-exit' ></i>Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" id="user-picture-crop"><i class='bx bx-crop' ></i>Crop</button>
            </div>
        </div>
    </div>
</div>
<!-- modal image cropper end -->

@endsection

@push('scripts')
<script src="{{ asset('/vendor/cropper/cropper.min.js') }}"></script>
<script src="{{ asset('/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript">
@if($user->profile)
let gender = '{{$user->profile->gender}}';
let role = '{{$user->profile->role}}';
let grade = '{{$user->profile->grade}}';
let year_join = '{{$user->profile->year_join}}';
$('#profile-gender option[value="'+gender+'"]').prop('selected', true);
$('#profile-role option[value="'+role+'"]').prop('selected', true);
if(role == 'student') {
    $('#profile-grade option[value="'+grade+'"]').prop('selected', true);
    $('#profile-year_join option[value="'+year_join+'"]').prop('selected', true);
}
@endif
const submitProfile = () => {
    $('.alert').html('').addClass('d-none');
    if($('#form-profile').attr('method') == 'post') {
        var formData = new FormData($('#form-profile')[0]);
        formData.append('user_id', user_id);
    } else {
        var formData = $('#form-profile').serialize();
    }
    var config = {
        method: $('#form-profile').attr('method'), url: domain + $('#form-profile').attr('action'),
        data: formData
    }
    axios(config)
    .then((response) => {
        successMessage(response.data.message);
        if(response.data.new) {
            window.location.href = '/';
        }
    })
    .catch((error) => {
        console.log(error.response);
        if(error.response) {
            if(error.response.data.message) {
                errorMessage(error.response.data.message);
            }
            if(error.response.data.errors) {
                if(error.response.data.errors.full_name) { $('#alert-profile-full_name').html(error.response.data.errors.full_name).removeClass('d-none').hide().fadeIn('slow'); }
                if(error.response.data.errors.year_join) { $('#alert-profile-year_join').html(error.response.data.errors.year_join).removeClass('d-none').hide().fadeIn('slow'); }
            }
        }
    });
}

$('#profile-role').change(function() {
    if($(this).find(':selected').val() != 'student') {
        $('#profile-student-detail').addClass('d-none');
    } else {
        $('#profile-student-detail').removeClass('d-none').hide().fadeIn('slow');
    }
});

const changePassword = () => {
    $('.alert').html('').addClass('d-none');
    var formData = new FormData($('#form-update_password')[0]);
    formData.append('action', 'update_password');
    var config = {
        method: $('#form-update_password').attr('method'), url: domain + $('#form-update_password').attr('action'),
        data: formData,
    }
    axios(config)
    .then((response) => {
        if(response.data.error == false) {
            $('#form-update_password').trigger('reset');
            successMessage(response.data.message);
        } else {
            $('#alert-update_password').html('');
            response.data.message.forEach(foreachMessage);
            function foreachMessage(item, index) {
                $('#alert-update_password').append('<li>'+ item +'</li>')
            }
            $('#alert-update_password').removeClass('d-none').hide().fadeIn('slow');
        }
    })
    .catch((error) => {
        console.log(error);
    });
}

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
                    method: 'post', url: domain + 'action/user',
                    data: {
                        action: 'update_picture', picture: base64data,
                    },
                }
                axios(config)
                .then((response) => {
                    successMessage(response.data.message);
                    $('.user-picture').attr('src', domain + 'img/profiles/' + response.data.picture_name);
                    $('#sidebar-user-picture').attr('src', domain + 'img/profiles/' + response.data.picture_name);
                })
                .catch((error) => {
                    console.log(error);
                });
                $('.modal').modal('hide');
            }
        });
    });
});

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
$(document).ready(function() {
    var tablerecord = $('#table-record').dataTable();
    $('#link-user').addClass('active');
    $('#submenu-user').addClass('show');
    $('#link-user-profile').addClass('active');
});
</script>
@endpush