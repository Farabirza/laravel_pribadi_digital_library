@extends('layouts.master')

@push('css-styles')
<link rel="stylesheet" href="{{ asset('/vendor/datatables/datatables.min.css') }}">
<link href="{{ asset('/vendor/cropper/cropper.min.css') }}" rel="stylesheet">
<script src="{{ asset('/vendor/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('/vendor/fontawesome/fontawesome.js') }}" crossorigin="anonymous"></script>
<style>
.overlay-container { position: relative; }
#overlay-img img {
    opacity: 1;
    display: block;
    width: 100%;
    transition: .5s ease;
    backface-visibility: hidden;
}
.overlay {
    transition: .5s ease;
    opacity: 0;
    position: absolute;
    text-align: center;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
}
.overlay-container:hover #overlay-img img { opacity: 0.3; }
.overlay-container:hover .overlay { opacity: 1; }
.overlay-text { background-color: var(--first-color); color: white; font-size: 10pt; padding: 4px 10px; }
.overlay-text:hover { cursor:pointer; background-color: #fff; color: var(--first-color); transition: .5s; }
.cropper-preview { overflow: hidden; height: 160px; margin: 10px; border: 1px solid red; }
  
.profile-name { letter-spacing: 1pt; }
.user-role { 
    padding: 4px 20px;
    border-radius: 4px;
    margin: 4px;
    white-space: nowrap;
    background: var(--first-color); 
    color: var(--color-light-1); 
}
label { color: #0b82b9; margin-bottom: 4px; }
</style>
@endpush
@section('content')
<!-- section-profile -->
<section id="section-profile" class="ptb-60 bg-light">
    <div class="container">
        <!-- row -->
        <div class="row justify-content-center">

            <!-- profile-img -->
            <div class="col-md-10 justify-content-center text-center"> 
                <div class="overlay-container">
                    <label for="replace-img">
                        <div id="overlay-img">
                            <img src="{{ asset('/img/profiles/'.Auth::user()->profile->image) }}" id="profile-img" alt="" class="rounded-circle mb-2 box-shadow-1">
                        </div>
                        <div class="overlay">
                            <div id="overlay-text" class="overlay-text">Change</div>
                        </div>
                    </label>
                </div>
                <form id="form-profile_img" enctype="multipart/form-data" method="POST">
                @csrf
                <input id="replace-img" class="absolute w-full h-full d-none" name="profile-img" type="file">
                </form>

                <!-- modal image cropper -->
                <div class="modal fade" id="modal-crop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="img-container">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <img id="img-crop" src="">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="cropper-preview"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="crop">Crop</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal image cropper end --> 
                <!-- profile-img end -->

                <h3 class="profile-name layout-5 mb-2">Welcome, <span style="color:#ff5546">{{ Auth::user()->profile->first_name }} {{ Auth::user()->profile->last_name }}</span></h3>
                <p class="text-muted fst-italic mb-3">{{Auth::user()->group->name}}</p>
                <p><span class="user-role">{{ucfirst(Auth::user()->role)}}</span></p>
            </div>
        </div>
        <!-- row end -->
    </div>
</section>
<!-- section-profile end -->

<!-- section data -->
<section id="section-userdata" class="ptb-60">
    <div class="container">
        <!-- row -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="mb-3">User Data</h3>
                <form id="form-password" action="/update_password" method="POST" class="mb-4"> <!-- form-password -->
                    @csrf
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" value="{{Auth::user()->email}}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control mb-3" name="password" placeholder="Password">
                        <input type="password" class="form-control mb-4" name="password_confirmation" placeholder="Confirm password">
                    </div>
                    <button class="btn btn-outline-primary" type="submit"><i class='bx bx-key'></i> Change password</button>
                </form> <!-- form-password end -->
                <hr class="mb-3">
                <h3 class="mb-3">User Profile</h3>
                <form id="form-profile" action="/update_profile" method="POST" class="mb-40"> <!-- form-profile -->
                    @csrf
                    <div class="form-group d-flex">
                        <div class="col">
                            <label>First name</label> <!-- first name -->
                            <input type="text" name="first_name" class="form-control" placeholder="First name" value="{{ Auth::user()->profile->first_name }}">
                        </div>
                        <span>&ensp;</span>
                        <div class="col">
                            <label>Last name</label> <!-- last name -->
                            <input type="text" name="last_name" class="form-control" placeholder="Last name" value="{{ Auth::user()->profile->last_name }}">
                        </div>
                    </div>
                    <!-- contact -->
                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" name="contact" class="form-control" placeholder="Contact" value="{{Auth::user()->profile->contact}}">
                    </div>
                    <!-- contact end -->
                    <!-- school origin -->
                    <div class="form-group d-flex">
                        <div class="col">
                            <label>School origin</label>
                            <input type="text" name="school_origin" class="form-control" placeholder="School origin" value="{{ Auth::user()->profile->school_origin }}">
                        </div>
                        <span>&ensp;</span>
                        <div>
                            <label>Grade</label>
                            <input type="text" name="grade" class="form-control" placeholder="Grade" value="{{ Auth::user()->profile->grade }}">
                        </div>
                    </div>
                    <!-- school origin end -->
                    <!-- gender -->
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" class="form-control form-select">
                            <option value="female" @if(Auth::user()->profile->gender == 'female') selected @endif>Female</option>
                            <option value="male" @if(Auth::user()->profile->gender == 'male') selected @endif>Male</option>
                        </select>
                    </div>
                    <!-- gender end -->
                    <!-- birth date / place -->
                    <div class="form-group d-flex">
                        <div class="col">
                            <label>Birth place</label>
                            <input type="text" name="birth_place" class="form-control" placeholder="Birth place" value="{{ Auth::user()->profile->birth_place }}">
                        </div>
                        <span>&ensp;</span>
                        <div class="col">
                            <label>Birth date</label>
                            <input type="date" min="1950-01-01" max="{{date('Y-m-d', time())}}" class="form-control" name="birth_date" value="{{Auth::user()->profile->birth_date}}" required>
                        </div>
                    </div>
                    <!-- birth date / place end -->
                    <!-- address -->
                    <div class="form-group">
                        <div class="col mb-3">
                            <label>Address street</label>
                            <input type="text" name="address_street" class="form-control" placeholder="Address street" value="{{ Auth::user()->profile->address_street }}">
                        </div>
                        <div class="d-flex">
                            <div class="col">
                                <label>City</label>
                                <input type="text" name="address_city" class="form-control" placeholder="Address city" value="{{ Auth::user()->profile->address_city }}">
                            </div>
                            <span>&ensp;</span>
                            <div class="col">
                                <label>Province</label>
                                <input type="text" name="address_province" class="form-control" placeholder="Address province" value="{{ Auth::user()->profile->address_province }}">
                            </div>
                            <span>&ensp;</span>
                            <div class="col">
                                <label>ZIP</label>
                                <input type="text" name="zip" class="form-control" placeholder="ZIP" value="{{ Auth::user()->profile->zip }}">
                            </div>
                        </div>
                    </div>
                    <!-- address end -->
                    <!-- group -->
                    <div class="form-group">
                        <label>User group</label>
                        <input type="text" class="form-control mb-1" name="group" value="{{Auth::user()->group->name}}" disabled>
                        <span class="text-muted fst-italic">*Contact Admin if you wish to change group</span>
                    </div>
                    <!-- group end -->
                    <button type="submit" class="btn btn-primary"><i class='bx bx-edit-alt'></i> Update Profile</button>
                </form> <!-- form-profile end -->
            </div>
        </div>
        <!-- row end -->
    </div>
</section>
<!-- section data end -->

@endsection
@push('scripts')
<script src="{{ asset('/vendor/cropper/cropper.min.js') }}"></script>
<script src="{{ asset('/js/ajax_profile.js') }}" type="text/javascript" defer></script>
<script type="text/javascript">
$(document).ready(function(){
});
</script>
@endpush