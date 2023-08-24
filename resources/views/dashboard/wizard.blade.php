@extends('layouts.master_dashboard')

@push('css-styles')
<link href="{{ asset('/vendor/cropper/cropper.min.css') }}" rel="stylesheet">
<style>
body { background: #f9f9f9; min-height: 100vh; }
.alert { font-size: 10pt; }
.form-label { color: var(--bs-primary) }

@media (max-width: 1199px) {
}
@media (max-width: 768px) {
}
</style>

@endpush

@section('content')

<section id="section-wizard" class="px-3 py-5">
    <div class="container">
        <div class="row mb-2">
            <!-- breadcrumb start -->
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">User</li>
                        <li class="breadcrumb-item active" aria-current="page">Wizard</li>
                    </ol>
                </nav>
            </div>
            <!-- breadcrumb end -->
        </div>
        <div class="row bg-white p-4 rounded shadow">
            <div class="col-md-12">
                <h3 class="display-5 fs-24 mb-3">User Data</h3>
                <div class="mb-3">
                    <label for="profile-full_name" class="form-label">Full name</label>
                    <input type="text" id="profile-full_name" name="full_name" class="form-control form-control-sm">
                </div>
                <div class="mb-3">
                    <label for="profile-role" class="form-label">Role</label>
                    <select name="role" id="profile-role" class="form-select form-select sm">
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                        <option value="staff">Staff</option>
                        <option value="management">Management</option>
                    </select>
                </div>
                <div id="profile-student-detail" class="mb-3 d-flex align-items-center gap-3">
                    <div class="col">
                        <label for="profile-year_join" class="form-label">Which year did you join Pribadi School Depok?</label>
                        <input type="number" name="year_join" id="profile-year_join" class="form-control form-control-sm" placeholder="example: {{date('Y', time())}}">
                    </div>
                    <div class="col">
                        <label for="profile-grade" class="form-label">Which grade are you at that time?</label>
                        <select name="grade" id="profile-grade" class="form-select form-select-sm">
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
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('/vendor/cropper/cropper.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#link-user').addClass('active');
    $('#submenu-user').addClass('show');
    $('#link-user-wizard').addClass('active');
});
</script>
@endpush