@extends('layouts.master_sidebar')

@push('css-styles')
<link href="{{ asset('/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
<style>
body { background: #f9f9f9; min-height: 100vh; vertical-align: center; }
table thead th { font-weight: 500; }
table { font-size: .8em; }
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
                    <li class="breadcrumb-item active" aria-current="page">Book controller</li>
                </ol>
            </nav>
        </div>
        <!-- breadcrumb end -->
              
        <!-- row start -->
        <div class="row my-4">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-book"></i>Books</h3>
                <div class="table-container bg-white">
                    <table id="table-books" class="table table-hover">
                        <thead>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Uploaded at</th>
                            <th>Visitor</th>
                            <th>Review</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @forelse($books as $item)
                            <tr>
                                <td>{{$i}}</td>
                                <td><a href="/book/{{$item->id}}" class="hover-primary">{{$item->title}}</a></td>
                                <td><a href="/book?search={{(isset($item->category->name) ? $item->category->name : '')}}" class="hover-primary">{{(isset($item->category->name) ? $item->category->name : '')}}</a></td>
                                <td>{{date('Y/m/d', strtotime($item->created_at))}} by <a href="/user/{{($item->user->id)}}" class="hover-primary">{{(isset($item->user->profile) ? $item->user->profile->full_name : $item->user->email)}}</a></td>
                                <td>{{count($item->logVisit)}}</td>
                                <td>{{count($item->review)}}</td>
                                <td>
                                    <div class="dropdown">
                                        <i class="bx bx-dots-vertical bx-border-circle btn-outline-dark p-1" role="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                        <div class="dropdown-menu fs-10">
                                            <div class="dropdown-item"><i class="bx bx-file"></i>User data</div>
                                            <div class="dropdown-item"><i class="bx bx-key"></i>Reset password</div>
                                            <div class="dropdown-item"><i class="bx bx-crown"></i>Change authority</div>
                                            <div class="dropdown-item"><i class="bx bx-message"></i>Send notification</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php $i++; ?>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- row end -->

        <!-- row start -->
        <div class="row my-4">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-history"></i>Records</h3>
                <div class="table-container">
                    <table class="table table-striped" id="table-records">
                        <thead>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Visitor</th>
                        </thead>
                        <tbody>
                            @forelse($logVisits as $item)
                            @if($item->book)
                            <tr>
                                <td>{{date('Y/m/d | h:i A', strtotime($item->created_at))}}</td>
                                <td><a href="/book/{{$item->book->id}}" class="hover-primary">{{$item->book->title}}</a></td>
                                <td><a href="/book?search={{(isset($item->book->category->name) ? $item->book->category->name : '')}}" class="hover-primary">{{$item->book->category->name}}</a></td>
                                <td><a href="/user/{{$item->user->id}}" class="hover-primary">{{($item->user->profile ? $item->user->profile->full_name : $item->user->email)}}</a></td>
                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td colspan="4" class="text-muted fst-italic text-center">Record empty</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- row end -->

        <!-- row line chart start -->
        <div class="row my-4">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-line-chart"></i>Number of visitor based on students' grade levels</h3>
                <div class="flex-center">
                    <canvas id="chart-student-demography" style="max-height: 420px"></canvas>
                </div>
            </div>
        </div>
        <!-- row end -->

        <!-- row categories start -->
        <div class="row my-4">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-4"><i class="bx bx-category"></i>Categories</h3>
                <div class="flex-start flex-wrap gap-2 mb-3">
                    <button class="btn btn-danger btn-sm rounded-pill flex-center gap-1" onclick="modalCategory('create')"><i class="bx bx-plus"></i>New category</button>
                    @forelse($categories as $item)
                    <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="modalCategory('edit', '{{$item->id}}', '{{$item->name}}')">{{$item->name}}</button>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <!-- row categories end -->

        <!-- row reviews start -->
        <div class="row my-4">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-message"></i>Reviews</h3>
                <div class="list-group" style="max-height:420px; overflow:auto;">
                    @forelse($reviews as $item)
                    @if($item->book)
                    <div class="list-group-item d-flex">
                        <div class="col">
                            <p class="fs-11 mb-1">
                                <a href="/user/{{$item->user->id}}" class="text-primary">{{$item->user->profile->full_name}}</a> on <a href="/book/{{$item->book->id}}" class="hover-primary">{{$item->book->title}}</a>
                            </p>
                            <div class="d-flex align-items-center gap-2 mb-2 fs-11">
                                @for($i=1; $i <= 5; $i++)
                                @if($i > $item->rating)
                                <i class="bx bxs-star"></i>
                                @else
                                <i class="bx bxs-star" style="color:#ffa723"></i>
                                @endif
                                @endfor
                                <span class="fs-11 text-secondary ms-2">{{date('d/m/Y', strtotime($item->created_at))}}</span>
                            </div>
                            <p class="fs-10 mb-0">{{$item->comment}}</p>
                        </div>
                        <a href="/review/{{$item->id}}/destroy" class="m-0 btn-warn" data-warning="You wish to delete this review?"><i class="bx bx-trash-alt bx-border-circle p-1 btn-outline-danger border-danger" role="button"></i></a>
                    </div>
                    @endif
                    @empty
                    <div class="list-group-item">
                        <p class="fs-11 text-muted fst-italic mb-0">No one made any review yet</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- row reviews end -->

    </div>
</section>

@include('layouts.partials.modal_bookAdmin')

@endsection

@push('scripts')
<script src="{{ asset('/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/chartjs/chartjs-4.3.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/vendor/chartjs/chartjs-plugin-datalabels-2.0.0.min.js') }}"></script>
<script type="text/javascript">
const BookVisitor = document.getElementById('chart-student-demography');
let days_in_month = @json($days_in_month);
let arr_elementary = @json($arr_elementary);
let arr_junior = @json($arr_junior);
let arr_senior = @json($arr_senior);
const chartBookVisitor = new Chart(BookVisitor, {
    data: { 
        labels: days_in_month,
        datasets: [{
            type: 'line', label: 'Elementary School',
            backgroundColor: "rgb(255, 99, 132)", borderColor: 'rgb(255, 99, 132)',
            tension: 0.4, data: arr_elementary
        }, {
            type: 'line', label: 'Middle School',
            backgroundColor: "rgb(54, 162, 235)", borderColor: 'rgb(54, 162, 235)',
            tension: 0.4, data: arr_junior
        }, {
            type: 'line', label: 'High School',
            backgroundColor: "rgb(255, 205, 86)", borderColor: 'rgb(255, 205, 86)',
            tension: 0.4, data: arr_senior
        }]
    }
});

const current_year = "{{date('Y')}}";

// copy to clipboard start 
$(document).ready(function() {
    new DataTable('#table-books', {
        ordering: true,
        searching: true,
    });
    new DataTable('#table-records', {
        ordering: true,
        searching: true,
    });
    $('#link-admin').addClass('active');
    $('#submenu-admin').addClass('show');
    $('#link-admin-book').addClass('active');
});
</script>
@endpush