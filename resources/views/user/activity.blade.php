@extends('layouts.master_sidebar')

@push('css-styles')
<link href="{{ asset('/vendor/aos/aos.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
<style>
</style>
@endpush

@section('content')

<section id="section-content" class="py-4">
    <div class="container">
        <!-- breadcrumb start -->
        <div class="my-4">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/profile">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Activity</li>
                </ol>
            </nav>
        </div>
        <!-- breadcrumb end -->

        <!-- row start  -->
        <div class="row my-4" data-aos="fade-right" data-aos-duration="300">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-4"><i class="bx bx-flag"></i>Reports</h3>
                <div class="list-group" style="max-height: 420px; overflow: auto;">
                    @forelse(Auth::user()->report->sortByDesc('created_at') as $report)
                    @if($report->solved)
                    <div class="list-group-item d-flex align-items-center bg-light">
                    @else
                    <div class="list-group-item d-flex align-items-center">
                    @endif
                        <div class="col">
                            <p class="fs-9 text-secondary mb-0">{{date('d/m/Y', strtotime($report->created_at))}}</p>
                            <p class="fs-11 mb-2"><a href="/book/{{$report->book->id}}" class="text-primary">{{$report->book->title}}</a></p>
                            <ul class="bx-ul fs-10 mb-0">
                                <li><i class="bx bx-info-square"></i><span class="text-secondary">{{$report->subject}}</span></li>
                                <li><i class="bx bx-message"></i><span class="text-secondary">{{($report->message ? $report->message : '-')}}</span></li>
                                <li><i class="bx bx-check"></i><span class="text-secondary">Solved at : {{($report->solved ? date('Y/m/d', strtotime($report->updated_at)) : '-')}}</span></li>
                            </ul>
                        </div>
                        @if($report->solved)
                        <i class="bx bx-check-double bx-border-circle bg-success p-2 text-light fs-18 popper" title="solved"></i>
                        @else
                        <i class="bx bx-x bx-border-circle bg-danger p-2 text-light fs-18"></i>
                        @endif
                    </div>
                    @empty
                    <p class="fs-11 text-secondary fst-italic mb-0">No report has been made yet</p>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- row end  -->
        
        <!-- row start  -->
        <div class="row my-4" data-aos="fade-right" data-aos-duration="300">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-4"><i class="bx bx-message"></i>Review</h3>
                <div class="list-group">
                    @forelse(Auth::user()->review->sortByDesc('created_at') as $review)
                    <div class="list-group-item">
                        <p class="fs-9 text-secondary mb-0">{{date('d/m/Y', strtotime($review->created_at))}}</p>
                        <p class="fs-11 mb-2"><a href="/book/{{$review->book->id}}" class="text-primary">{{$review->book->title}}</a></p>
                        <div class="d-flex align-items-center gap-2 mb-2 fs-11">
                            @for($i=1; $i <= 5; $i++)
                            @if($i > $review->rating)
                            <i class="bx bxs-star"></i>
                            @else
                            <i class="bx bxs-star" style="color:#ffa723"></i>
                            @endif
                            @endfor
                        </div>
                        <ul class="bx-ul fs-10 mb-2">
                            <li><i class="bx bx-message"></i><span class="">{{($review->comment ? $review->comment : '-')}}</span></li>
                        </ul>
                    </div>
                    @empty
                    <p class="fs-11 text-secondary fst-italic mb-0">No review has been posted yet</p>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- row end  -->
    </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#link-user').addClass('active');
    $('#submenu-user').addClass('show');
    $('#link-user-activity').addClass('active');
});

// Animate on scroll
AOS.init({ once: true,  easing: 'ease-in-out-sine' });
</script>
@endpush