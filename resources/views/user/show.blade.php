@extends('layouts.master_sidebar')

@push('css-styles')
<link href="{{ asset('/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
<style>
body { background: #f9f9f9; min-height: 100vh; }
table thead th { font-weight: 500; }
table { font-size: .8em }
.alert { font-size: 9pt; padding: 10px; }
.form-label { color: var(--bs-primary); font-size: 11pt; }

.container-user-image { display: flex; align-items: center; }
.user-image img { max-height: 180px; border: 6px solid white; }
.container-user-data { display: flex; justify-content: end; }
.user-data { text-align: end; }

@media (max-width: 1199px) {
}
@media (max-width: 768px) {
    .container-user-data, .container-user-image { justify-content: center; }
    .user-data { text-align: center; }
}
</style>

@endpush

@section('content')

<section id="section-profile" class="px-3 py-5">
    <div class="container">
        <!-- breadcrumb start -->
        <div class="col-md-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    @if(Auth::check() && Auth::user()->authority->name != 'user')
                    <li class="breadcrumb-item"><a href="/admin/user">User</a></li>
                    @else
                    <li class="breadcrumb-item"><a href="/profile">User</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{$user->profile->full_name}}</li>
                </ol>
            </nav>
        </div>
        <!-- breadcrumb end -->
        <!-- row start -->
        <div class="row my-4" data-aos="fade-right" data-aos-duration="300">
            <div class="col-md-12 p-0 bg-white rounded shadow">
                <div class="bg-primary d-flex flex-remove-md justify-content-between align-items-center py-4 px-5 rounded-top text-white">
                    <div class="container-user-image gap-3">
                        <div class="user-image mb-2">
                            @if($user->picture == null)
                            <img src="{{asset('img/profiles/user.jpg')}}" alt="" class="rounded-circle">
                            @else
                            <img src="{{asset('img/profiles/'.$user->picture)}}" alt="" class="rounded-circle">
                            @endif
                        </div>
                    </div>
                    <div class="container-user-data">
                        <div class="user-data">
                            <h3 class="fs-24 fw-semibold ls-2 mb-0">{{$user->profile->full_name}}</h3>
                            <p class="fs-11 fst-italic mb-0">{{$user->email}}</p>
                            <p class="fs-10">
                                @if($user->profile->role == 'student')
                                <?php $current_grade = $user->profile->grade + date('Y', time()) - $user->profile->year_join; ?>
                                @if($current_grade <= 12)
                                <span class="fw-bold">Grade {{$current_grade}}</span>
                                @endif
                                <span>
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
                                <span>{{$user->profile->role}}</span>
                                @else
                                <span>{{$user->profile->role}}</span>
                                @endif
                                | <span>{{$user->profile->gender}}</span>
                            </p>
                            @if($user->authority->name != 'user')
                            <p class="fs-10 ls-1"><span class="px-2 py-1 border border-white rounded">{{$user->authority->name}}</span></p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <!-- section start -->
                    <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-book"></i>Submitted books</h3>
                    <?php $i = 1; ?>
                    <div class="table-container" style="max-height:420px; overflow:auto;">
                        <table class="table fs-10">
                            <tbody>
                                @forelse($user->book->sortByDesc('created_at') as $item)
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>
                                        <a href="/book/{{$item->id}}" class="hover-primary pb-1">{{$item->title}}</a> 
                                        @if($item->author)
                                        <span class="text-muted">by {{$item->author}}</span>
                                        @endif
                                    </td>
                                </tr>
                                <?php $i++; ?>
                                @empty
                                <tr>
                                    <td class="fs-10 text-muted fst-italic">This user hasn't submitted anything yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- section end -->
                    <div class="py-4">
                        <div style="border-top:2px dashed var(--bs-primary)"></div>
                    </div>
                    <!-- section start -->
                    <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-bookmark"></i>Saved books</h3>
                    <?php $i = 1; ?>
                    <div class="table-container" style="max-height:420px; overflow:auto;">
                        <table class="table fs-10">
                            <tbody>
                                @forelse($user->bookmark->sortByDesc('created_at') as $item)
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>
                                        @if($item->book->image)
                                        <a href="{{asset('img/covers/'.$item->book->image)}}" class="glightbox">  
                                            <img src="{{asset('img/covers/'.$item->book->image)}}" style="max-height:80px;" class="shadow-sm me-2">
                                        </a>
                                        @endif
                                        <a href="/book/{{$item->book->id}}" class="hover-primary pb-1">{{$item->book->title}}</a> 
                                        @if($item->author)
                                        <span class="text-muted">by {{$item->book->author}}</span>
                                        @endif
                                    </td>
                                </tr>
                                <?php $i++; ?>
                                @empty
                                <tr>
                                    <td class="fs-10 text-muted fst-italic">This user hasn't saved any book yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- section end -->
                    <div class="py-4">
                        <div style="border-top:2px dashed var(--bs-primary)"></div>
                    </div>
                    <!-- section start -->
                    <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-message"></i>Reviews</h3>
                    <?php $i = 1; ?>
                    <div class="mb-4 list-group" style="max-height:420px; overflow:auto;">
                        @forelse($user->review->sortByDesc('created_at') as $item)
                        <div class="list-group-item d-flex align-items-center gap-3">
                            @if($item->user->picture == null)
                            <img src="{{asset('img/profiles/user.jpg')}}" alt="" class="rounded-circle shadow-sm" style="max-height:80px">
                            @else
                            <img src="{{asset('img/profiles/'.$item->user->picture)}}" alt="" class="rounded-circle shadow-sm" style="max-height:80px">
                            @endif
                            <div class="col">
                                <p class="fs-11 text-primary mb-1">
                                    <a href="/book/{{$item->book->id}}">{{$item->book->title}}</a>
                                    @if($item->book->author)
                                    <span class="text-muted">by {{$item->book->author}}</span>
                                    @endif
                                </p>
                                <div class="d-flex align-items-center gap-2 mb-2 fs-11">
                                    @for($j=1; $j <= 5; $j++)
                                    @if($j > $item->rating)
                                    <i class="bx bxs-star"></i>
                                    @else
                                    <i class="bx bxs-star" style="color:#ffa723"></i>
                                    @endif
                                    @endfor
                                    <span class="fs-11 text-secondary ms-2">{{date('d/m/Y', strtotime($item->created_at))}}</span>
                                </div>
                                <p class="fs-11 text-secondary mb-0">{{($item->comment ? $item->comment : '-')}}</p>
                            </div>
                        </div>
                        <?php $i++; ?>
                        @empty
                        <p class="fs-10 text-muted fst-italic mb-0">This user hasn't made any review yet</p>
                        @endforelse
                    </div>
                    <!-- section end -->
                </div>
            </div>
        </div>
        <!-- row end -->
        <!-- row start -->
        <div class="row my-4" data-aos="fade-right" data-aos-duration="600">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-history"></i>History</h3>
                <div class="table-container mb-3">
                    <table id="table-record" class="table table-striped">
                        <thead>
                            <th>Date of visit</th>
                            <th>Title</th>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @forelse($user->logVisit as $record)
                            <tr>
                                <td>{{date('l, j F Y', strtotime($record->created_at))}}</td>
                                <td><a href="/book/{{$record->book->id}}" class="hover-primary">{{$record->book->title}}</a></td>
                            </tr>
                            <?php $i++ ?>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- row end -->
    </div>
</section>



@endsection

@push('scripts')
<script src="{{ asset('/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript">
const lightbox = GLightbox({
    selector: '.glightbox',
});
$(document).ready(function() {
    new DataTable('#table-record', {
        ordering: false,
        searching: false,
    });
    $('#link-user').addClass('active');
    $('#submenu-user').addClass('show');
    $('#link-user-profile').addClass('active');
});
</script>
@endpush