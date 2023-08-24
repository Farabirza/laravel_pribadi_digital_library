@extends('layouts.master_sidebar')

@push('css-styles')
<link href="{{ asset('/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
<style>
body { background: #f9f9f9; min-height: 100vh; vertical-align: center; }
table thead th { font-weight: 500; }
.alert { font-size: 9pt; padding: 10px; }
.form-label { color: var(--bs-primary); font-size: 11pt; }
.dropdown-item { display: flex; align-items: center; gap: 8px; padding-left: 10px; }
.dropdown-item:hover { cursor: pointer; }

@media (max-width: 1199px) {
}
@media (max-width: 768px) {
}
</style>

@endpush

@section('content')

<section class="py-5">
    <div class="container">
        <!-- breadcrumb start -->
        <div class="my-4">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item">Admin</li>
                    <li class="breadcrumb-item active" aria-current="page">User controller</li>
                </ol>
            </nav>
        </div>
        <!-- breadcrumb end -->
        <div class="row my-4">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-key"></i>User confirmation key</h3>
                <div class="mb-3 w-75 input-group">
                    <input type="text" id="confirmation-key" class="form-control" value="40620b4f-cc40-402a-8b7d-b6e48f736031">
                    <button class="input-group-text d-flex align-items-center gap-2" onclick="copy()"><i class="bx bx-copy"></i>Copy to clipboard</button>
                </div>
                <p class="fs-10 fst-italic text-muted mb-0">*) Share this key to teacher who wish to confirm their account</p>
            </div>
        </div>
              
        <!-- row start -->
        <div class="row my-4">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-user"></i>Users</h3>
                <div class="table-container bg-white">
                    <table id="table-users" class="table table-hover fs-9">
                        <thead>
                            <th>#</th>
                            <th>Full name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Authority</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php $i = 1; $count_elementary = 0; $count_junior = 0; $count_senior = 0; $count_alumni = 0; ?>
                            @foreach($users as $user)
                            @if($user->status == 'suspended')
                            <tr class="text-danger">
                            @else
                            <tr>
                            @endif
                            @if($user->profile && $user->profile->role == 'student')
                            <?php 
                                $get_grade = $user->profile->grade + date('Y', time()) - $user->profile->year_join;
                                if($get_grade <= 6) {
                                    $count_elementary++;
                                } elseif ($get_grade >= 7 && $get_grade <= 9) {
                                    $count_junior++;
                                } elseif ($get_grade >= 9 && $get_grade <= 12) {
                                    $count_senior++;
                                } else {
                                    $count_alumni++;
                                }
                            ?>
                            @endif
                                <td>{{$i}}</td>
                                <td><a href="/user/{{$user->id}}" class="hover-primary">{{($user->profile ? $user->profile->full_name : '-')}}</a></td>
                                <td>{{$user->email}}</td>
                                <td>{{($user->profile ? $user->profile->role : '-')}}</td>
                                <td>{{$user->authority->name}}</td>
                                <td>
                                    @if(($user->id != Auth::user()->id) && ($user->authority->name != 'superadmin'))
                                    <div class="dropdown">
                                        <i class="bx bx-dots-vertical bx-border-circle btn-outline-dark p-1" role="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                        <div class="dropdown-menu fs-10">
                                            <div class="dropdown-item" onclick="userData('{{$user->id}}')"><i class="bx bx-file"></i>User data</div>
                                            <div class="dropdown-item" onclick="modalPassword('{{$user->id}}', '{{$user->email}}')"><i class="bx bx-key"></i>Reset password</div>
                                            <div class="dropdown-item" onclick="modalAuthority('{{$user->id}}', '{{$user->authority->id}}', '{{$user->email}}')"><i class="bx bx-crown"></i>Change authority</div>
                                            <div class="dropdown-item" onclick="modalNotification('{{$user->id}}')"><i class="bx bx-message"></i>Send notification</div>
                                            @if($user->status == 'suspended')
                                            <div class="dropdown-item text-primary"><i class="bx bx-user-check"></i><a href="/admin/{{$user->id}}/suspend" class="btn-warn" data-warning="Re-activate this user?">Activate</a></div>
                                            @else
                                            <div class="dropdown-item text-danger"><i class="bx bx-user-x"></i><a href="/admin/{{$user->id}}/suspend" class="btn-warn" data-warning="This user will not be able to access anything">Suspend</a></div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- row end -->

        <!-- row start -->
        <div id="row-userData" class="row my-4 d-none">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-file"></i>User data</h3>
                <div id="container-userData">
                    <div class="d-flex align-items-center flex-remove-md gap-3">
                        <div class="flex-center py-3">
                            <img id="userData-image" src="{{asset('img/profiles/user.jpg')}}" class="rounded img-thumbnail shadow" style="max-height: 320px;">
                        </div>
                        <div class="col">
                            <table class="table fs-10">
                                <tr>
                                    <th>Email</th>
                                    <td>:</td>
                                    <td id="userData-email" class="userData-data"></td>
                                </tr>
                                <tr>
                                    <th>Authority</th>
                                    <td>:</td>
                                    <td id="userData-authority" class="userData-data"></td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>:</td>
                                    <td id="userData-role" class="userData-data"></td>
                                </tr>
                                <tr>
                                    <th>Joined at</th>
                                    <td>:</td>
                                    <td id="userData-joined_at" class="userData-data"></td>
                                </tr>
                                <tr>
                                    <th>Full name</th>
                                    <td>:</td>
                                    <td id="userData-full_name" class="userData-data"></td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>:</td>
                                    <td id="userData-gender" class="userData-data"></td>
                                </tr>
                                <tr>
                                    <th>Birth date</th>
                                    <td>:</td>
                                    <td id="userData-birth_date" class="userData-data"></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>:</td>
                                    <td id="userData-address" class="userData-data"></td>
                                </tr>
                                <tr>
                                    <th>Biodata</th>
                                    <td>:</td>
                                    <td id="userData-biodata" class="userData-data"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row end -->

        <!-- row start -->
        <div class="row my-4">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-pie-chart-alt"></i>Student demography</h3>
                <div class="flex-center">
                    <canvas id="chart-student-demography" style="max-height: 420px"></canvas>
                </div>
            </div>
        </div>
        <!-- row end -->
    </div>
</section>

@include('layouts.partials.modal_admin')

@endsection

@push('scripts')
<script src="{{ asset('/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/chartjs/chartjs-4.3.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/chartjs/chartjs-plugin-datalabels-2.0.0.min.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('/vendor/chart/chart.min.js') }}"></script> -->
<!-- <script type="text/javascript" src="{{ asset('/vendor/chart/chartjs-plugin-datalabels.min.js') }}" ></script> -->
<script type="text/javascript">
const ctx = document.getElementById('chart-student-demography');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
        'Elementary',
        'Junior high',
        'Senior high',
    ],
    datasets: [{
        label: ' ',
        data: ['{{$count_elementary}}', '{{$count_junior}}', '{{$count_senior}}'],
        backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)',
        'rgb(255, 205, 86)',
        ],
        hoverOffset: 4
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            datalabels: {
                color: 'blue',
            },
        }
    }
});

const current_year = "{{date('Y')}}";
// user profile start 
const userData = (user_id) => {
    $('.userData-data').html('');
    let formData = { action: 'get_user', user_id: user_id };
    let config = {
        method: 'post', url: domain + 'action/admin', data: formData,
    };
    axios(config)
    .then((response) => {
        if(response.data.user.picture == null) {
            $('#userData-image').attr('src', domain + 'img/profiles/user.jpg');
        } else {
            $('#userData-image').attr('src', domain + 'img/profiles/' + response.data.user.picture);
        }
        $('#userData-email').html(response.data.user.email);
        $('#userData-authority').html(response.data.authority.name);
        if(response.data.profile) {
            $('#userData-full_name').html(response.data.profile.full_name);
            $('#userData-gender').html(response.data.profile.gender);
            $('#userData-role').html(response.data.profile.role);
            $('#userData-biodata').html(response.data.profile.biodata);
            $('#userData-birth_date').html(response.data.profile.birth_place +', '+ response.data.profile.birth_date);
            $('#userData-address').html(response.data.profile.address_street +', '+ response.data.profile.address_city +', '+ response.data.profile.address_zip);
            if(response.data.profile.role == 'student') {
                let current_grade = current_year - response.data.profile.year_join + parseInt(response.data.profile.grade);
                $('#userData-joined_at').html(response.data.profile.year_join);
                $('#userData-role').html('Grade ' + current_grade + ' student');
            }
        }
        $('#row-userData').removeClass('d-none').hide().fadeIn('slow');
    })
    .catch((error) => {
        console.log(error);
        if(error.response) {
            errorMessage(error.response.data.message);
        }
    });
};

// copy to clipboard start 
const copy = () => {
    let copyText = document.getElementById('confirmation-key');
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    infoMessage('Confirmation key copied');
};
$(document).ready(function() {
    new DataTable('#table-users', {
        fixedColumns: true,
        ordering: false,
        searching: true,
    });
    $('#link-admin').addClass('active');
    $('#submenu-admin').addClass('show');
    $('#link-admin-user').addClass('active');
});
</script>
@endpush