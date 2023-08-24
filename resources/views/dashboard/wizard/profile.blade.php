
<section id="section-wizard-profile" class="section-wizard px-3">
    <div class="container">
        <div class="row bg-white p-4 rounded shadow mb-4">
            <div class="col-md-12">
                <div class="alert alert-success alert-success-profile d-none">
                    <h5 class="d-flex align-items-center"><i class='bx bx-check-square me-2'></i>Success!</h5>
                    <p class="mb-0">Update saved</p>
                </div>
                <div class="alert alert-danger alert-danger-profile d-none">
                    <h5 class="d-flex align-items-center"><i class='bx bx-error me-2'></i>Error!</h5>
                    <p id="alert-danger-profile-message" class="mb-0"></p>
                </div>
                <h2 class="section-title mt-3 mb-4">Profile</h2>

                <!-------------------------- form profile start -------------------------->
                @if($profile)
                <form id="form-profile" action="ajax/profile/{{$profile->id}}" method="put" class="m-0">
                @else
                <form id="form-profile" action="ajax/profile" method="post" class="m-0">
                @endif
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name*</label>
                    <input type="text" name="full_name" class="form-control form-control-sm mb-2" placeholder="full name">
                    <p class="fs-9 text-muted fst-italic mb-3">*) required</p>
                    <p id="alert-full_name" class="alert alert-danger d-none mb-3"></p>
                </div>
                <div class="d-flex flex-remove-md gap-3 mb-3">
                    <div class="col">
                        <label for="gender" class="form-label">Gender*</label>
                        <select name="gender" id="profile-gender" class="form-control form-select mb-2" required>
                            <option value="select" selected disabled hidden>Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <p class="mb-2 fs-9 text-muted fst-italic">*) required</p>
                    <p id="alert-gender" class="alert alert-danger d-none mb-3"></p>
                    </div>
                    <div class="col">
                        <label for="birth_date" class="form-label">Birth date</label>
                        <input type="date" min="1950-01-01" max="{{date('Y-m-d', time())}}" id="profile-birth_date" class="form-control" name="birth_date" value="">
                    </div>
                </div>
                <div class="mb-2">
                    <span class="text-primary fw-bold fs-11">Domicile</span>
                </div>
                <div class="d-flex flex-remove-md gap-3 mb-3">
                    <div class="col">
                        <label for="address_street" class="form-label fs-10">Street</label>
                        <input type="text" name="address_street" class="form-control" placeholder="street">
                    </div>
                    <div class="col">
                        <label for="address_city" class="form-label fs-10">City</label>
                        <input type="text" name="address_city" class="form-control" placeholder="ex: Jakarta">
                    </div>
                </div>
                <div class="d-flex flex-remove-md gap-3 mb-3">
                    <div class="col">
                        <label for="address_state" class="form-label fs-10">State</label>
                        <input type="text" name="address_state" class="form-control" placeholder="ex: Indonesia">
                    </div>
                    <div class="col">
                        <label for="address_zip" class="form-label fs-10">ZIP code</label>
                        <input type="number" class="form-control" name="address_zip" placeholder="ZIP" value="" maxlength="5">
                    </div>
                </div>
                <div class="d-flex flex-remove-md gap-3 mb-3">
                    <div class="col">
                        <label for="profile-languange" class="form-label">Languange</label>
                        <input type="text" name="languange" id="profile-languange" class="form-control form-control-sm mb-2" placeholder="ex: English, Spanish">
                        <p class="mb-2 fs-9 text-muted fst-italic">*) use coma ',' as separator</p>
                        <p id="alert-languange" class="alert alert-danger d-none mb-3"></p>
                    </div>
                    <div class="col">
                        <label for="profile-interest" class="form-label">Interest</label>
                        <input type="text" name="interest" id="profile-interest" class="form-control form-control-sm mb-2" placeholder="ex: Artificial Intelligence, Traveling">
                        <p class="mb-2 fs-9 text-muted fst-italic">*) use coma ',' as separator</p>
                        <p id="alert-interest" class="alert alert-danger d-none mb-3"></p>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="biodata" class="form-label">Biodata</label>
                    <textarea name="biodata" id="biodata" cols="30" rows="4" class="form-control" placeholder="tell us about yourself"></textarea>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <hr class="col me-3"/>
                    <button type="button" class="btn btn-success d-flex align-items-center" onclick="submitProfile()"><i class='bx bxs-save me-2' ></i>Save</button>
                </div>
                </form>
                <!-------------------------- form profile end -------------------------->

            </div>
        </div>

        <div class="row mb-5">
            <div id="container-nav-profile" class="col-md-12 d-flex align-items-center justify-content-end">
                @if(Auth::user()->profile)
                <span class="text-primary fs-14 d-flex align-items-center" role="button" onclick="navWizard('education', 40)">Next<i class='bx bx-chevrons-right ms-2' ></i></span>
                @else
                <span class="text-secondary fs-14 d-flex align-items-center popper" title="please save your profile to continue">Next<i class='bx bx-chevrons-right ms-2' ></i></span>
                @endif
            </div>
        </div>
    </div>
</section>

@if($profile)
<script type="text/javascript">
var full_name = "{{ $profile->full_name }}";
var gender = "{{ $profile->gender }}";
var birth_date = "{{ $profile->birth_date }}";
var languange = "{{ $profile->languange }}";
var interest = "{{ $profile->interest }}";
var biodata = "{{ $profile->biodata }}";
var address_street = "{{ $profile->address_street }}";
var address_city = "{{ $profile->address_city }}";
var address_state = "{{ $profile->address_state }}";
var address_zip = "{{ $profile->address_zip }}";
$(document).ready(function() {
    $('[name="full_name"]').val(full_name);
    $('[name="gender"] option[value="'+gender+'"]').prop('selected', true);
    $('[name="birth_date"]').val(birth_date);
    $('[name="languange"]').val(languange);
    $('[name="interest"]').val(interest);
    $('[name="biodata"]').val(biodata);
    $('[name="address_street"]').val(address_street);
    $('[name="address_city"]').val(address_city);
    $('[name="address_state"]').val(address_state);
    $('[name="address_zip"]').val(address_zip);
});
</script>
@endif
<script type="text/javascript">
function submitProfile() {
    $('.alert').hide();
    var formProfile = $('#form-profile');
    if(formProfile.attr('method') == 'post') {
        var formData = new FormData(document.getElementById('form-profile'));
        formData.append('user_id', user_id);
    } else {
        var formData = formProfile.serialize();
    }
    var config = {
        method: formProfile.attr('method'), url: domain + formProfile.attr('action'),
        data: formData,
    }
    axios(config)
    .then((response) => {
        successMessage(response.data.message);
        if(response.data.new) {
            profile_exist = true;
            formProfile.attr('method', 'put');
            formProfile.attr('action', 'ajax/profile/' + response.data.profile_id);
            $('#progress-bar-wizard').animate({width: '20%'}, 'fast').attr('aria-valuenow', 20);
            $('#container-nav-profile').html(`<span class="text-primary fs-14 d-flex align-items-center" role="button" onclick="navWizard('education', 40)">Next<i class='bx bx-chevrons-right ms-2' ></i></span>`);
        }
    })
    .catch((error) => {
        console.log(error.response);
        if(error.response) {
            let response = error.response.data;
            if(response.errors) {
                if(response.errors.full_name) { $('#alert-full_name').html(response.errors.full_name).removeClass('d-none').hide().fadeIn('slow'); }
                if(response.errors.gender) { $('#alert-gender').html(response.errors.gender).removeClass('d-none').hide().fadeIn('slow'); }
            }
        }
    });
};
</script>