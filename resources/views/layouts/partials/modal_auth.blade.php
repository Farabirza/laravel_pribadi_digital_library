<style>
.alert { font-size: 11pt; }
</style>

<!-- Modal Login -->
<div class="modal fade" id="modal-login" aria-hidden="true"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center fw-medium"><i class='bx bx-log-in-circle me-2'></i><span>Sign in to your account</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/login" id="form-login" method="POST">
            @csrf
            <div class="modal-body">
                <div class="mb-2 d-flex align-items-center gap-3">
                    <div class="col form-floating">
                        <input type="text" name="email" id="modal-login-email" class="form-control form-control-sm" placeholder="Email" value="" required>
                        <label for="modal-login-email" class="label">Email</label>
                    </div>
                    <div class="col form-floating">
                        <input type="text" class="form-control form-control-sm" id="email2" value="@pribadidepok.sch.id" disabled>
                        <label for="email2" class="form-label">Email extension</label>
                    </div>
                </div>
                <p class="mb-3 fs-10 fst-italic text-secondary">*) you only need to put the first part of your email</p>
                <div class="input-group form-floating mb-3">
                    <input type="password" name="password" id="modal-login-password" class="form-control form-control-sm" placeholder="Password" value="" required>
                    <span class="input-group-text hover-pointer" onclick="togglePassword(password_visible)">
                        <i class='btn-password-toggle bx bx-show-alt'></i>
                    </span>
                    <label for="modal-login-password" class="label">Password</label>
                </div>
                <div class="form-outline mb-3">
                    <p class="text-muted" style="color: #393f81;"><input type="checkbox" name="remember" value="true" class="mr-8" checked> Remember me</p>
                </div>
                <p class="text-muted">Doesn't have account? <span role="button" class="text-primary" onclick="modal_register_show()">Sign up</span>, or</p>
                <a href="/auth/google" class="btn btn-danger btn-sm"><i class='bx bx-xs bxl-google-plus me-2'></i>Sign in with Google</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary me-2 gap-2" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i>Cancel</button>
                <button type="submit" class="btn btn-sm btn-primary gap-2"><i class='bx bx-log-in-circle' ></i> Sign in</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Login end -->
<!-- Modal Register -->
<div class="modal fade" id="modal-register" aria-hidden="true"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center"><i class='bx bxs-user-plus me-2'></i><span>Create a new account</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="user" id="form-register" method="POST">
            <div class="modal-body">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="form-floating col">
                        <input type="text" name="email" id="modal-register-email" class="form-control form-control-sm" placeholder="Email" value="" required>
                        <label for="modal-register-email" class="label">Email</label>
                    </div>
                    <div class="form-floating col">
                        <input id="modal-register-email2" type="text" class="form-control" value="@pribadidepok.sch.id" disabled>
                        <label for="modal-register-email2" class="label">Email extension</label>
                    </div>
                </div>
                <p class="mb-3 fs-10 fst-italic text-secondary">*) you only need to put the first part of your email</p>
                <p id="alert-register-email" class="alert alert-danger d-none mb-3"></p>
                <div class="input-group form-floating mb-3">
                    <input type="password" name="password" id="modal-register-password" class="input form-control form-control-sm" placeholder="Password" value="" required>
                    <span class="input-group-text hover-pointer" onclick="togglePassword(password_visible)">
                        <i class='btn-password-toggle bx bx-show-alt'></i>
                    </span>
                    <label for="modal-register-password" class="label">Password</label>
                </div>
                <p id="alert-register-password" class="alert alert-danger d-none mb-3"></p>
                <div class="form-floating mb-3">
                    <input type="password" id="modal-register-password_confirmation" class="form-control form-control-sm" name="password_confirmation" placeholder="Confirm Password">
                    <label for="modal-register-password_confirmation" class="form-label">Confirm password</label>
                </div>
                <p id="alert-register-password_confirmation" class="alert alert-danger d-none mb-3"></p>
                <p class="text-muted fst-italic fs-10 mb-3">*) password must be at least 6 characters</p>
                <div class="form-outline mb-3">
                    <p class="" style="color: #393f81;"><input id="modal-register-agreement" type="checkbox" name="agreement" value="true" class="mr-8"> I agree with <span class="text-primary hover-pointer" onclick="modal_tos_show()">terms conditions and privacy policy</span></p>
                </div>
                <p class="text-muted">Already have an account? <span role="button" class="text-primary" href="#" onclick="modal_login_show()">Sign in</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary me-2 gap-2" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i>Cancel</button>
                <button type="button" id="btn-register-submit" class="btn btn-sm btn-primary gap-2" onclick="signUp()" disabled><i class='bx bx-log-in-circle'></i>Sign Up</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Register end -->

<!-- Modal Terms start -->
<div class="modal fade" id="modal-terms" aria-hidden="true"> 
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center"><i class='bx bx-file me-2'></i>Terms of Service Agreement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm mr-3" onclick="modal_register_show()">I understand</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Terms end -->

@push('scripts')
<script type="text/javascript">
const signUp = () => {
    $('.alert').html('').hide();
    let formData = new FormData($('#form-register')[0]);
    let config = {
        method: $('#form-register').attr('method'), url: domain + $('#form-register').attr('action'),
        data: formData,
    }
    axios(config)
    .then((response) => {
        successMessage(response.data.message);
        $('#form-register').trigger('reset');
        $('.modal').modal('hide');
        $('#modal-login-email').val(response.data.user.email);
        $('#modal-login-password').val(response.data.user.key);
        $('#form-login').submit();
    })
    .catch((error) => {
        console.log(error);
        errorMessage(error.response.data.message);
        if(error.response.data.errors) {
            if(error.response.data.errors.email) { $('#alert-register-email').html(error.response.data.errors.email).removeClass('d-none').hide().fadeIn('slow'); }
            if(error.response.data.errors.password) { $('#alert-register-password').append(error.response.data.errors.password).removeClass('d-none').hide().fadeIn('slow'); }
            if(error.response.data.errors.password_confirmation) { $('#alert-register-password_confirmation').append(error.response.data.errors.password_confirmation).removeClass('d-none').hide().fadeIn('slow'); }
        }
    });
}

$('#modal-register-agreement').change(function() {
    if($(this).is(":checked")) {
        $('#btn-register-submit').prop('disabled', false);
    } else {
        $('#btn-register-submit').prop('disabled', true);
    }
});

const modal_login_show = () => {
  $('.modal').modal('hide');
  $('#modal-login').modal('show');
}
const modal_register_show = () => {
  $('.modal').modal('hide');
  $('#modal-register').modal('show');
}
const modal_tos_show = () => {
    $('.modal').modal('hide');
    $('#modal-terms').modal('show');
}

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

$(document).ready(function(){
    @error('email')
    errorMessage('Email error : {{$message}}');
    @enderror
    @error('password')
    errorMessage('Password error : {{$message}}');
    @enderror
});
</script>
@endpush