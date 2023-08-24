@extends('layouts.master_admin')

@push('css-styles')
<style>
@media (max-width:768px) {
    .col-sm-6 { width: 50%; }
}
</style>
@endpush

@section('content')

<section id="section-content">
    <div class="container-fluid">
        <div class="row">

            <!-- user table start -->
            <div class="col-md-12 p-3">
                <div class="shadow p-4 rounded">
                    <table id="table-user" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Full name</th>
                                <th>Profession</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td><a href="/cv/{{$user->username}}">{{$user->username}}</a></td>
                                <td>{{$user->email}}</td>
                                @if(isset($user->profile))
                                <td>{{$user->profile->first_name.' '.$user->profile->last_name}}</td>
                                <td>{{$user->profile->profession}}</td>
                                @else
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                @endif
                            </tr> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- user table end -->

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('/vendor/chart/chart.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/chart/chartjs-plugin-datalabels.min.js') }}" ></script>
<script src="{{ asset('/vendor/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('/vendor/purecounter/purecounter.js') }}">
$(document).ready(function(){
    var purecounter = new PureCounter({
        selector: ".purecounter",
        duration: .2,
        delay: 0,
        once: true,
    });
});
</script>
<script>
$(document).ready(function(){ 
    $('.nav-link').removeClass('active'); $('#link-overview').addClass('active'); // nav-link active
    // datatables start
    $('#table-user').DataTable({
        order: [[0, 'desc']], responsive: true,
    });
    // datatables end
});
</script>
@endpush