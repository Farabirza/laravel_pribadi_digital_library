@extends('layouts.master_sidebar')

@push('css-styles')
<link href="{{ asset('/vendor/aos/aos.css') }}" rel="stylesheet">
<style>
.search-container {
  position: relative;
}

.search-container i {
  position: absolute;
  right: 15px;
  top: 12px;
  color: #ced4da;
}

.book-content {
  position: relative;
  border-radius: 10px;
  width: 258px;
  height: 360px;
  background-color: whitesmoke;
  transform: preserve-3d;
  perspective: 2000px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #000;
  margin: auto;
}

.book-content .book-cover {
  top: 0;
  overflow: hidden;
  position: absolute;
  background-color: lightgray;
  width: 100%;
  height: 100%;
  border-radius: 10px;
  transition: all 0.5s;
  transform-origin: 0;
}
.book-cover > img { height: 100%; }

.book-nav-in { display: flex; align-items: center; justify-content: center;  }
.book-nav-out { display: none; }

#pagination-books div { gap: 12px; }


@media (min-width: 1199px) {
    .book-content:hover .book-cover {
        transition: all 0.5s;
        transform: rotatey(-80deg);
    }
}
@media (max-width: 1199px) {
    h3 { font-size: 18pt; }
    .book-nav-in { display: none; }
    .book-nav-out { display: block; }
    .book-content {
        width: 194px;
        height: 270px;
    }
    .book-title {
        text-wrap: wrap;
        max-width: 194px;
    }
}
</style>
@endpush

@section('content')

<section id="">
    
    <!-- container start -->
    <div class="container mb-5">
        <div class="row justify-content-center py-5">
            @if(Auth::check() && Auth::user()->profile->role != 'student' && count($notification) > 0)
            <div class="col-md-12 mb-3">
                <div class="alert alert-info fs-11">
                    <h5 class="display-5 fs-24 mb-2 d-flex align-items-center gap-2"><i class="bx bx-bell"></i>Attention</h5>
                    <ul>
                        @foreach($notification as $message)
                        <li>{!! $message !!}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <?php $catchphrases = [
                "Unlock the World of Knowledge, Journey into Boundless Collection of Literature!",
                "Explore, Engage, Empower: Dive into the Digital Library!",
                "Unlimited Knowledge at Your Fingertips: Your Digital Library Adventure Begins Now.",
                "Books in Bits: Your Gateway to the Digital Library Universe.",
                "Turn the Page, Swipe the Screen: Embrace the Future with the Digital Library.",
                "Read, Click, Learn: Your Personalized Digital Library Awaits.",
                "Beyond Boundaries, Within Reach: Discover the Magic of the Digital Library.",
                "Libraries Unchained: Your Passport to the World of Digital Reading.",
                "Scroll and Enroll: Enrich Your Mind with the Digital Library Experience.",
                "Reading Reimagined: Where Tradition Meets Technology in the Digital Library.",
                "Words Wired for Wonder: Immerse Yourself in the Digital Library Delight.",
                "Bytes of Brilliance: Unleash the Power of the Digital Library Today.",
                "E-Books, E-Learning, E-mpowerment: Welcome to the Digital Library Revolution.",
                "Flip to the Future: Your Reading Journey Elevated in the Digital Library.",
                "From Codex to Clicks: Elevate Your Reading with the Digital Library Evolution.",
                "More Than Just Pages: Experience the Interactive Joy of the Digital Library."
            ]; $randomIndex = array_rand($catchphrases); $randomCatchphrase = $catchphrases[$randomIndex]; ?>
            <div class="col-md-12 text-center mb-3">
                <p class="fs-12 mb-2">Welcome to</p>
                <h1 class="display-5 fs-24 text-uppercase mb-2">Pribadi School Depok <span id="typed" class="text-primary"></span></h1>
                <p class="fs-11 text-secondary fst-italic">"{{$randomCatchphrase}}"</p>
            </div>
            <div class="col-md-8">
                <form id="form-search" action="/book" method="get" class="form-search">
                    <div class="search-container">
                        <?php $studySubjects = [ 'mathematics', 'biology', 'physics', 'chemistry', 'history', 'geography', 'english', 'computer', 'literature', 'economics', 'art', 'foreign language', 'music', 'social studies']; ?>
                        <input  id="search-keyword" type="search" name="search" class="form-control" autocomplete="off" placeholder="search something, try {{$studySubjects[array_rand($studySubjects)]}}" value="{{(isset($_GET['search']) ? $_GET['search'] : '')}}"><i type="button" class="bx bx-search-alt-2" onclick="searchBook()"></i>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <!-- book container start -->
            <div id="container-books" class="col-md-12 d-flex flex-wrap justify-content-center gap-3 mb-5">
                <?php $i = 1; ?>
                @forelse($books as $book)
                <div class="item-book p-3 my-2" data-aos="fade-down" data-aos-duration="{{$i*100}}">
                    <div class="book-content shadow">
                        <div class="text-center">
                            <div class="px-4 mb-3">
                                <h5 class="display-5 fs-14 mb-2"><a href="/book/{{$book->id}}" id="book-title-{{$i}}">{{$book->title}}</a></h5>
                                <p class="fs-9 mb-1">
                                    @if($book->author)<a href="/book?search={{$book->author}}">{{$book->author}}</a>@endif
                                    @if($book->publisher)| <a href="/book?search={{$book->publisher}}">{{$book->publisher}}</a>@endif
                                </p>
                                <p class="fs-9 text-secondary mb-3"><a href="/book?search={{$book->category->name}}" id="book-category-{{$i}}">{{$book->category->name}}</a></p>
                            </div>
                            <div class="book-nav-in flex-wrap gap-2">
                                <a href="/book/{{$book->id}}" class="btn btn-secondary btn-sm fs-9 px-2 py-1 gap-1"><i class="bx bx-info-circle"></i>Detail</a>
                                <span role="button" class="btn btn-primary btn-sm fs-9 px-2 py-1" onclick="modalChapters('{{$book->id}}', '{{$i}}')">Read &raquo;</span>
                            </div>
                            @if(Auth::check() && Auth::user()->authority->name != 'user')
                            <div class="d-flex justify-content-center mt-2">
                                <button class="btn btn-outline-dark btn-sm fs-9 px-2 py-1 gap-1" onclick="modalQuickEdit('{{$book->id}}', '{{$i}}')"><i class="bx bx-edit-alt"></i>Quick edit</button>
                            </div>
                            @endif
                        </div>
                        <div class="book-cover d-flex align-items-center justify-content-center">
                            @if($book->image != null)
                            <img src="{{asset('img/covers/'.$book->image)}}" alt="">
                            @else
                            <img src="{{asset('img/covers/cover-'.rand(1,3).'.jpg')}}" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="book-nav-out mt-4">
                        <div class="mb-2">
                            <h5 class="book-title display-5 fs-12 text-center"><a href="/book/{{$book->id}}">{{$book->title}}</a></h5>
                        </div>
                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-3 fs-11">
                            <a href="/book/{{$book->id}}" class="hover-underline">Detail</a>
                            -
                            <span role="button" class="hover-underline" onclick="modalChapters('{{$book->id}}', '{{$i}}')">Read</span>
                        </div>
                        @if(Auth::check() && Auth::user()->authority->name != 'user')
                        <div class="d-flex justify-content-center mt-2">
                            <button class="btn btn-outline-dark gap-1 fs-9 py-1" onclick="modalQuickEdit('{{$book->id}}', '{{$i}}')"><i class="bx bx-edit-alt"></i>Edit</button>
                        </div>
                        @endif
                    </div>
                </div>
                <input type="hidden" id="book-id-{{$i}}" name="book_id" value="{{$book->id}}">
                <input type="hidden" id="book-category_id-{{$i}}" name="category_id" value="{{$book->category_id}}">
                <input type="hidden" id="book-author-{{$i}}" name="author" value="{{$book->author}}">
                <input type="hidden" id="book-publisher-{{$i}}" name="publisher" value="{{$book->publisher}}">
                <input type="hidden" id="book-publication_year-{{$i}}" name="publication_year" value="{{$book->publication_year}}">
                <input type="hidden" id="book-isbn-{{$i}}" name="isbn" value="{{$book->isbn}}">
                <input type="hidden" id="book-description-{{$i}}" name="description" value="{{$book->description}}">
                <input type="hidden" id="book-url-{{$i}}" name="url" value="{{$book->url}}">
                <input type="hidden" id="book-keywords-{{$i}}" name="keywords" value="{{$book->keywords}}">
                <input type="hidden" id="book-source-{{$i}}" name="source" value="{{$book->source}}">
                <input type="hidden" id="book-chapter-count-{{$i}}" name="chapter_count" value="{{count($book->chapter)}}">
                <?php $j = 1; ?>
                @forelse($book->chapter->sortBy('number') as $chapter)
                <input type="hidden" id="book-chapter-id-{{$i}}-{{$j}}" name="chapter_id" value="{{$chapter->id}}">
                <input type="hidden" id="book-chapter-title-{{$i}}-{{$j}}" name="chapter_title" value="{{$chapter->title}}">
                <?php $j++; ?>
                @empty
                @endforelse
                <?php $i++; ?>
                @empty
                <div class="item-book w-100 p-3 text-center">
                    <span class="fs-11 text-muted fst-italic">Data not found</span>
                </div>
                @endforelse
            </div>
            <!-- book container end -->
            <!-- pagination start -->
            <div id="pagination-books" class="col-md-12 d-flex justify-content-center">
            {{ $books->onEachSide(3)->appends($_GET)->links() }}
            </div>
            <!-- pagination end -->
            <div id="container-categories" class="col-md-12 d-flex flex-wrap justify-content-center gap-3 mt-4">
                @forelse($categories as $item)
                @if(isset($_GET['search']) && $_GET['search'] == $item->name)
                <a href="/book?search={{$item->name}}" class="btn btn-danger fs-9 px-4 py-1 rounded-pill">{{$item->name}}</a>
                @else
                <a href="/book?search={{$item->name}}" class="btn btn-outline-danger fs-9 px-4 py-1 rounded-pill">{{$item->name}}</a>
                @endif
                @empty
                @endforelse
            </div>
        </div>
        <!-- row end -->
    </div>
    <!-- container end -->

    <!-- container most visited start -->
    @if(count($most_visited) > 0)
    <div class="container-fluid bg-light">
        <div class="row p-5">
            <div class="col-md-12">
                <h3 class="display-5 text-center mb-0">Most visited books</h3>
                <div class="d-flex justify-content-center py-4">
                    <div class="border border-primary w-25"></div>
                </div>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <?php $i = 1; ?>
                    @foreach($most_visited as $book)
                    <div class="p-3" data-aos="fade-right" data-aos-duration="{{$i*200}}">
                        <a href="/book/{{$book->id}}">
                            @if($book->image)
                            <figure class="hover-shine"><img src="{{asset('img/covers/'.$book->image)}}" class="img-fluid rounded shadow" style="max-height: 280px;"></figure>
                            @else
                            <figure class="hover-shine"><img src="{{asset('img/covers/cover-'.rand(1,3).'.jpg')}}" class="img-fluid rounded shadow" style="max-height: 280px;"></figure>
                            @endif
                        </a>
                        <div class="d-flex justify-content-center mt-2">
                            <p class="fs-11 text-wrap text-center mb-0" style="max-width: 180px"><a href="/book/{{$book->id}}">{{$book->title}}</a></p>
                        </div>
                    </div>
                    <?php $i++; ?>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- container most visited end -->

    <!-- container sign up and submit start -->
    <div class="container-fluid">
        <!-- row start -->
        <div class="row justify-content-center align-items-center" style="background:#fee396">
            <div class="col-md-5 py-2 px-4 text-end">
                <img src="{{asset('img/materials/book-animate.gif')}}" alt="" class="img-fluid" style="max-height:480px">
            </div>
            <div class="col-md-5 p-4">
                @guest
                <h5 class="display-5 fs-24">Can't find the book you're looking for?</h5>
                <p class="mb-3" style="font-weight:500"><span role="button" class="hover-underline fs-18" onclick="modal_login_show()">Sign up now!</span></p>
                <p class="mb-0 fs-11">Some books are limited to registered user. There are some benefits exclusive to user as well such as save the book to read later, review the content of the book, and request for a book to the community.</p>
                @endguest
                @auth
                <h5 class="display-5 fs-24">Be a Part of an Ever Growing Reader Community!</h5>
                <p class="mb-3 fs-11">Our digital library is a treasure trove of knowledge and a sanctuary for readers of all ages, but we need your help to keep the shelves stocked with fresh, exciting, and diverse reads.</p>
                <p class="mb-0 fs-14">a total of <span class="purecounter fw-bold" data-purecounter-end="{{$books_count}}">0</span> books has been added so far</p>
                <p class="mb-0 fs-14"><a href="/book/create" class="hover-underline" style="font-weight:500">Contribute now!</a></p>
                @endauth
            </div>
        </div>
        <!-- row end -->
    </div>
    <!-- container sign up and submit end -->
    

    <!-- container footer start -->
    <div class="container-fluid py-5" style="background:#202020; color: #f1f1f1">
        <!-- row start -->
        <div class="row justify-content-center">
            <div class="col-md-10 d-flex flex-remove-md justify-content-center align-items-center gap-5 mb-4">
                <div class="col text-center">
                    <a href="https://pribadidepok.sch.id/" target="_blank"><img src="{{asset('img/logo/logo-pribadi-white.png')}}" class="mb-3" style="max-height:60px"></a>
                </div>
                <div class="col fs-10 mb-3">
                    <p class="mb-1"><b>Email</b> info@pribadidpeok.sch.id</p>
                    <p class="mb-1"><b>Phone</b> (021) 7775620</p>
                    <p class="mb-1 text-wrap" style="max-width:480px"><b>Address</b> Jl. Margonda No.229, Kemiri Muka, Kecamatan Beji, Kota Depok, Jawa Barat 16423</p>
                </div>
            </div>
            <div class="col-md-10 d-flex flex-wrap align-items-center justify-content-center gap-3">
                <a href="https://pribadidepok.sch.id/" target="_blank" class="btn btn-outline-light btn-sm rounded-pill d-flex align-items-center gap-2"><i class="bx bx-globe"></i>pribadidepok.sch.id</a>
                <a href="https://www.instagram.com/sekolahpribadidepok/" target="_blank" class="btn btn-outline-light btn-sm rounded-pill d-flex align-items-center gap-2"><i class="bx bxl-instagram"></i>@sekolahpribadidepok</a>
                <a href="https://www.youtube.com/@sekolahpribadidepok8225" target="_blank" class="btn btn-outline-light btn-sm rounded-pill d-flex align-items-center gap-2"><i class="bx bxl-youtube"></i>Sekolah Pribadi Depok</a>
            </div>
        </div>
        <!-- row end -->
    </div>
    <!-- container footer start -->

</section>
<!-- section end -->

@include('layouts.partials.modal_bookIndex')

@endsection

@push('scripts')
<script src="{{ asset('/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('/vendor/purecounter/purecounter.js') }}"></script>
<script src="{{ asset('/vendor/typed/typed.min.js') }}"></script>
<script type="text/javascript">
var string = 'Digital Library, Online Archive, Cloud Repository';
var item = string.split(',');
var typed = new Typed('#typed', {
    strings: item, typeSpeed: 100, backSpeed: 50, backDelay: 2000, loop: true,
});

$(document).ready(function() {
    $('#link-book').addClass('active');
    $('#submenu-book').addClass('show');
    $('#link-book-index').addClass('active');
});

// Animate on scroll
AOS.init({ once: true,  easing: 'ease-in-out-sine' });
</script>
@endpush