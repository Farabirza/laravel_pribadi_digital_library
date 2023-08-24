@extends('layouts.master_sidebar')

@push('css-styles')
<link href="{{ asset('/vendor/aos/aos.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
<style>
body { background: #f9f9f9; }
img { max-width: 100%; }
table tbody { font-size: 11pt; vertical-align: top; }
table thead th { font-weight: 500; }
#book-source a { color: var(--bs-primary) !important; }

.comment-text {
  background-color: #d2d6de;
  color: #444;
  margin: 5px 0 0 20px;
  padding: 10px;
  position: relative;
}
.comment-text::after, .comment-text::before {
  border: solid transparent;
  border-right-color: #d2d6de;
  content: " ";
  height: 0;
  pointer-events: none;
  position: absolute;
  right: 100%;
  top: 15px;
  width: 0;
}
.comment-text::after {
  border-width: 5px;
  margin-top: -5px;
}
.comment-text::before {
  border-width: 6px;
  margin-top: -6px;
}
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
                    @if(Auth::check() && Auth::user()->authority->name != 'user')
                    <li class="breadcrumb-item"><a href="/admin/book">Book</a></li>
                    @else
                    <li class="breadcrumb-item">Book</li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{$book->title}}</li>
                </ol>
            </nav>
        </div>
        <!-- breadcrumb end -->

        <!-- report start -->
        @if(Auth::check() && Auth::user()->profile->role != 'student' && count($reports) > 0)
        <div class="row my-4" data-aos="fade-right" data-aos-duration="100">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <form action="action/book" method="post" id="form-confirm" class="m-0">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-2"><i class="bx bx-flag"></i>User feedback</h3>
                <p class="fs-11 mb-3">users are noticing some issues with this book and reporting it, please check and confirm when it's solved</p>
                <div class="list-group mb-3">
                    @foreach($reports as $item)
                    <div class="list-group-item d-flex align-items-center justify-content-between">
                        <div class="col">
                            <table class="table-borderless fs-10">
                                <tr>
                                    <td class="text-primary">From</td>
                                    <td class="px-3">:</td>
                                    <td>{{$item->user->profile->full_name}} | <span class="text-muted">{{$item->user->email}}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-primary">Subject</td>
                                    <td class="px-3">:</td>
                                    <td>{{$item->subject}}</td>
                                </tr>
                                <tr>
                                    <td class="text-primary">Additional comment</td>
                                    <td class="px-3">:</td>
                                    <td>{{$item->comment}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="fs-14">
                            <i class="bx bx-check bx-border-circle border-success btn-outline-success p-1 popper" title="solved" role="button" onclick="solved('{{$item->id}}')"></i>
                        </div>
                    </div>
                    @endforeach
                </div>
                </form>
            </div>
        </div>
        @endif
        <!-- report end -->
        <!-- confirmation start -->
        @if(Auth::check() && Auth::user()->profile->role != 'student' && $book->status == 'confirmation')
        <div class="row my-4" data-aos="fade-right" data-aos-duration="200">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <form action="action/book" method="post" id="form-confirm" class="m-0">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-2"><i class="bx bx-check-square"></i>Confirm?</h3>
                <p class="fs-11 mb-3">make sure the information provided by the uploader is correct and the link is working perfectly.</p>
                <div class="mb-3 form-floating fs-11">
                    <input type="text" id="confirm-message" name="message" class="form-control form-control-sm" placeholder="message">
                    <label for="confirm-message" class="form-label">Additional message</label>
                </div>
                <div class="d-flex align-items-center gap-3 fs-18">
                    <i class="bx bx-x bx-border-circle border-danger btn-outline-danger p-1 popper" title="no, delete this book" role="button" onclick="confirmBook(false)"></i>
                    <i class="bx bx-check bx-border-circle border-success btn-outline-success p-1 popper" title="yes, publish this book" role="button" onclick="confirmBook(true)"></i>
                </div>
                </form>
            </div>
        </div>
        @endif
        <!-- confirmation end -->

        <!-- book data start -->
        <div class="row justify-content-center align-items-center p-4 rounded-3 shadow bg-white" data-aos="fade-right" data-aos-duration="300">
            @if(count($alerts) > 0)
            <div class="col-md-12 px-4 pt-4 fs-11">
                <div class="alert alert-info">
                    <ul class="mb-0">
                        @foreach($alerts as $alert)
                        <li>{!! $alert !!}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <div class="col-md-6 p-4">
                @if($book->image != null)
                <figure class="hover-shine"><img src="{{asset('img/covers/'.$book->image)}}" id="book-image-preview" class="shadow rounded mb-4"></figure>
                @else
                <figure class="hover-shine"><img src="{{asset('img/covers/cover-'.rand(1,3).'.jpg')}}" id="book-image-preview" class="shadow rounded mb-4"></figure>
                @endif
            </div>
            <div class="col-md-6 p-4">
                <div class="d-flex flex-wrap gap-3 mb-3">
                    <a href="/book?search={{$book->category->name}}" class="bg-primary text-light py-1 px-3 rounded-pill fs-9">{{$book->category->name}}</a>
                    @if($keywords[0] != null)
                    @foreach($keywords as $keyword)
                    <a href="/book?search={{$keyword}}" class="btn btn-outline-secondary py-1 px-3 rounded-pill fs-9">{{$keyword}}</a>
                    @endforeach
                    @endif
                </div>
                <div class="mb-4">
                    <h3 id="book-title" class="display-5 pb-2" style="font-size:28pt;">{{$book->title}}</h3>
                    <hr class="w-25 border border-primary border-1 opacity-75">
                </div>
                <?php $book_rating = floor(($rating ? $rating/count($book->review) : 0)); ?>
                <div class="d-flex gap-2 mb-3 fs-18">
                    @for($i=1; $i <= 5; $i++)
                    @if($i > $book_rating)
                    <i class="bx bxs-star"></i>
                    @else
                    <i class="bx bxs-star" style="color:#ffa723"></i>
                    @endif
                    @endfor
                </div>
                <p class="fs-11 mb-3">Rating : <b>{{($rating ? number_format((float)($rating/count($book->review)), 2, '.', '') : 0)}}</b> | {{count($book->review)}} review(s) | {{count($book->logVisit)}} visitor(s)</p>
                @if(Auth::check() && $book->status == 'active')
                <div class="mb-3 d-flex gap-3">
                    @if($bookmark)
                    <i id="btn-bookmark" class="bx bxs-bookmark bx-border-circle btn-success p-2 popper" title="Bookmark" role="button" onclick="toggleBookmark()"></i>
                    @else
                    <i id="btn-bookmark" class="bx bxs-bookmark bx-border-circle border-success btn-outline-success p-2 popper" title="Bookmark" role="button" onclick="toggleBookmark()"></i>
                    @endif
                    @if($report != null && $report->solved == 0)
                    <i class="bx bxs-flag-alt bx-border-circle btn-danger p-2 popper" title="Report problem" role="button" onclick="modalReport('{{$book->id}}')"></i>
                    @else
                    <i class="bx bxs-flag-alt bx-border-circle border-danger btn-outline-danger p-2 popper" title="Report problem" role="button" onclick="modalReport('{{$book->id}}')"></i>
                    @endif
                    @if($review != null)
                    <i class="bx bxs-message bx-border-circle btn-primary p-2 popper" title="Review" role="button" onclick="modalReview('{{$book->id}}')"></i>
                    @else
                    <i class="bx bxs-message bx-border-circle border-primary btn-outline-primary p-2 popper" title="Review" role="button" onclick="modalReview('{{$book->id}}')"></i>
                    @endif
                </div>
                @endif
                <div class="fs-11 mb-0 d-flex flex-wrap gap-2">
                    @if($book->author)
                    <span class="fw-bold ls-1">{{$book->author}}</span>
                    @endif
                    @if($book->publisher)
                    | <span class="">{{$book->publisher}}</span>
                    @endif
                    @if($book->publication_year)
                    | <span class="">{{$book->publication_year}}</span>
                    @endif
                </div>
                <p class="fs-11 text-secondary mb-3">{{($book->description ? $book->description : '-')}}</p>
                <table class="table-borderless mb-4">
                    <tr>
                        <td>ISBN</td>
                        <td class="px-3">:</td>
                        <td>{{($book->isbn ? $book->isbn : '-')}}</td>
                    </tr>
                    <tr>
                        <td>Source</td>
                        <td class="px-3">:</td>
                        <td id="book-source">{!! ($book->source ? $book->source : '-') !!}</td>
                    </tr>
                    <tr>
                        <td>Posted by</td>
                        <td class="px-3">:</td>
                        <td><a href="/user/{{$book->user_id}}" class="text-primary">{{$book->user->profile->full_name}}</a> <span class="text-secondary">on {{date('F jS, Y', strtotime($book->created_at))}}</span></td>
                    </tr>
                    <tr>
                        <td>Last update</td>
                        <td class="px-3">:</td>
                        <td class="text-secondary">{{date('F jS, Y', strtotime($book->updated_at))}}</td>
                    </tr>
                </table>
                <div class="d-flex flex-wrap align-items-center gap-3">
                    @if(Auth::check() && Auth::user()->profile->role != 'student')
                    <a href="/book/{{$book->id}}/delete" class="btn btn-sm btn-danger gap-2 btn-warn" data-warning="Once deleted everything related to this book will be lost"><i class="bx bx-trash-alt"></i>Delete</a>
                    <a href="/book/{{$book->id}}/edit" class="btn btn-sm btn-success gap-2"><i class="bx bx-edit-alt"></i>Edit</a>
                    @endif
                    <a target="_blank"  href="/{{$book->id}}/0/read" class="btn btn-sm btn-primary gap-2"><i class="bx bx-book-content"></i>Read</a>
                </div>
            </div>
            <div class="col-md-12 p-4">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-list-ul"></i>Chapters</h3>
                <div class="mb-3 list-group">
                    <a target="_blank" href="/{{$book->id}}/0/read" class="list-group-item list-group-item-action d-flex align-items-center gap-2 fs-12 text-primary"><i class="bx bx-book-content"></i>Full content</a>
                </div>
                <?php $i = 1; ?>
                <div class="list-group">
                @forelse($book->chapter->sortBy('number') as $chapter)
                    <a target="_blank" href="/{{$book->id}}/{{$chapter->id}}/read" class="list-group-item list-group-item-action fs-11 text-primary mb-0">{{$chapter->title}}</a>
                @empty
                <p class="list-group-item fs-11 fst-italic text-secondary">No chapter listed</p>
                @endforelse
                </div>
            </div>
        </div>
        <!-- book data end -->

        @if(Auth::check() && $book->status == 'active')
        <!-- section review start -->
        <div class="row my-4" data-aos="fade-right" data-aos-duration="400">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-message"></i>Reviews</h3>
                <!-- my review start -->
                @if($review != null)
                <div class="mb-3 d-flex align-items-center gap-4 border rounded p-4">
                    <div class="">
                        @if(Auth::user()->picture)
                        <img src="{{asset('img/profiles/'.Auth::user()->picture)}}" class="img-fluid border rounded-circle" style="max-height:120px">
                        @else
                        <img src="{{asset('img/profiles/user.jpg')}}" class="img-fluid border rounded-circle" style="max-height:120px">
                        @endif
                    </div>
                    <div class="col fs-11">
                        <p class="mb-1">
                            <span class="fw-bold">{{Auth::user()->profile->full_name}}</span> | {{Auth::user()->email}}
                        </p>
                        <div class="d-flex align-items-center gap-2 mb-2 fs-11">
                            @for($i=1; $i <= 5; $i++)
                            @if($i > $review->rating)
                            <i class="bx bxs-star"></i>
                            @else
                            <i class="bx bxs-star" style="color:#ffa723"></i>
                            @endif
                            @endfor
                            <span class="fs-11 text-secondary ms-2">{{date('d/m/Y', strtotime($review->created_at))}}</span>
                        </div>
                        <p class="fs-11 text-secondary mb-3">{{$review->comment}}</p>
                        <p class="fs-11 d-flex gap-2 mb-0">
                            <span class="hover-underline" role="button" onclick="modalReview('{{$book->id}}')">Edit</span> | <a href="/review/{{$book->id}}/delete" class="hover-underline btn-warn" data-warning="">Delete</a>
                        </p>
                    </div>
                </div>
                @endif
                <!-- my review end -->
                <!-- reviews start -->
                <div id="container-reviews" class="mb-3">
                    @forelse($reviews as $item)
                    @if(Auth::check() && $item->user->id != Auth::user()->id)
                    <div class="review-comment mb-3">
                        <div class="d-flex">
                            <img class="comment-img img-fluid rounded-circle border" src="{{ asset('/img/profiles/'.($item->user->picture ? $item->user->picture : 'user.jpg')) }}" style="max-height:100px">
                            <div class="comment-text rounded fs-11">
                                <p class="mb-1">
                                    <a href="/user/{{$item->user->id}}" class="fw-bold">{{$item->user->profile->full_name}}</a> | {{$item->user->email}}
                                </p>
                                <div class="d-flex align-items-center gap-1 mb-2">
                                    @for($i=1; $i <= 5; $i++)
                                    @if($i > $item->rating)
                                    <i class="bx bxs-star"></i>
                                    @else
                                    <i class="bx bxs-star" style="color:#ffa723"></i>
                                    @endif
                                    @endfor
                                    <span class="fs-11 text-secondary ms-2">{{date('d/m/Y', strtotime($item->created_at))}}</span>
                                    @foreach($item->user->bookmark as $bookmark)
                                    @if($bookmark->book_id == $book->id)
                                    <i class="bx bx-bookmark bx-border-circle border-success bg-success text-light ms-1 p-1"></i>
                                    @endif
                                    @endforeach
                                </div>
                                <p class="mb-0">{{$item->comment}}</p>
                                @if(Auth::user()->authority->name != 'user')
                                <p class="fs-10 text-muted mt-2 mb-0"><a href="/review/{{$item->id}}/destroy" class="flex-start gap-1 btn-warn" data-warning="You wish to delete this review?"><i class="bx bx-trash-alt"></i>Delete</a></p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                    @endif
                    @empty
                    <p class="fs-11 mb-0 d-flex"><span class="btn btn-sm btn-outline-primary gap-2" role="button" onclick="modalReview('{{$book->id}}')">Be the first to review this book!</span></p>
                    @endforelse
                </div>
                <!-- reviews end -->
            </div>
        </div>
        <!-- section review end -->
        <!-- section record start -->
        <div class="row my-4" data-aos="fade-right" data-aos-duration="600">
            <div class="col-md-12 p-4 bg-white rounded shadow">
                <h3 class="d-flex align-items-center gap-2 fs-18 mb-3"><i class="bx bx-history"></i>Visit record</h3>
                <div class="table-container mb-3">
                    <table id="table-record" class="table table-striped">
                        <thead>
                            <th>Date of visit</th>
                            <th>Name</th>
                            <th>Role</th>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @forelse($records as $record)
                            <tr>
                                <td>{{date('l, j F Y', strtotime($record->created_at))}}</td>
                                <td><a href="/user/{{$record->user->id}}" class="hover-primary">{{$record->user->profile->full_name}}</a></td>
                                @if($record->user->profile->role != 'student')
                                <td>{{$record->user->profile->role}}</td>
                                @else
                                <?php 
                                    $get_grade = $record->user->profile->grade + date('Y', time()) - $record->user->profile->year_join;
                                    if($get_grade <= 6) {
                                        $student_grade = 'Grade ' . $get_grade . ' elementary';
                                    } elseif ($get_grade >= 7 && $get_grade <= 9) {
                                        $student_grade = 'Grade ' . $get_grade . ' junior high';
                                    } elseif ($get_grade >= 9 && $get_grade <= 12) {
                                        $student_grade = 'Grade ' . $get_grade . ' senior high';
                                    } else {
                                        $student_grade = 'Alumni';
                                    }
                                ?>
                                <td>{{ $student_grade }}</td>
                                @endif
                            </tr>
                            <?php $i++ ?>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- section record end -->
        @endif
    </div>
</div>

@auth
@include('layouts.partials.modal_book')
@endauth

@endsection

@push('scripts')
<script src="{{ asset('/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('/vendor/datatables/datatables.min.js') }}"></script>
<script type="text/javascript">
@auth
const solved = (report_id) => {
    let formData = { action: 'solved', report_id: report_id, }
    let config = {
        method: 'post', url: domain + 'action/report', data: formData,
    }
    axios(config)
    .then((response) => {
        successMessage(response.data.message);
        return location.reload();
    })
    .catch((error) => {
        console.log(error);
        errorMessage(error.response.data.message);
    });
}

const confirmBook = (confirmed) => {
    let formData = {
        action: 'confirm_book', book_id: "{{$book->id}}", 
        confirmed: confirmed, message: $('#confirm-message').val(),
    }
    console.log(formData);
    let config = {
        method: 'post', url: domain + 'action/book', data: formData,
    }
    axios(config)
    .then((response) => {
        successMessage(response.data.message);
        return location.reload();
    })
    .catch((error) => {
        console.log(error);
        errorMessage(error.response.data.message);
    });
}

const toggleBookmark = () => {
    let formData = {
        user_id: '{{Auth::user()->id}}', book_id: '{{$book->id}}',
    }
    let config = {
        method: 'post', url: domain + 'bookmark', data: formData,
    }
    axios(config)
    .then((response) => {
        successMessage(response.data.message);
        if(response.data.exist) {
            $('#btn-bookmark').removeClass('border-success btn-outline-success').addClass('btn-success');
        } else {
            $('#btn-bookmark').removeClass('btn-success').addClass('border-success btn-outline-success');
        }
    })
    .catch((error) => {
        errorMessage(error.response.data);
        console.log(error);
    });
};
@endauth

var tablerecord = $('#table-record').dataTable();
// Animate on scroll
AOS.init({ once: true,  easing: 'ease-in-out-sine' });
</script>
@endpush