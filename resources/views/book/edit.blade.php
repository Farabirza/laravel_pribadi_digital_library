@extends('layouts.master_sidebar')

@push('css-styles')
<style>
img { max-width: 100%; }
body { background: #f9f9f9; }
table tbody { font-size: 9pt; }
.form-label { color: var(--bs-primary); font-size: 11pt; }
.form-floating input { font-size: 11pt;  }
.alert { padding: 10px; }
</style>
@endpush

@section('content')

<section id="section-content" class="py-4">
    <div class="container">
        <!-- breadcrumb start -->
        <div class="col-md-12 mt-3 mb-2">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    @if(Auth::check() && Auth::user()->authority->name != 'user')
                    <li class="breadcrumb-item"><a href="/admin/book">Book</a></li>
                    @else
                    <li class="breadcrumb-item">Book</li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Edit book</li>
                </ol>
            </nav>
        </div>
        <!-- breadcrumb end -->
        <!-- form book submission start -->
        <form id="form-update-book" action="book/{{$book->id}}" method="put" class="m-0" enctype="multipart/form-data">
        <div class="row bg-white justify-content-center align-items-center shadow rounded p-5">
            <div class="col-md-12 mb-4">
                <div class="page-title">
                    <h1 class="display-5">Book editing form</h1>
                </div>
            </div>
            <!-- book image start -->
            <div class="col-md-5 px-4 mb-4">
                <div class="mb-3">
                    <h5 class="fs-14 d-flex align-items-center gap-2 mb-3"><i class="bx bx-image-alt"></i>Cover image</h5>
                    @if($book->image != null)
                    <img src="{{asset('img/covers/'.$book->image)}}" id="book-image-preview" class="shadow mb-4">
                    @else
                    <img src="{{asset('img/covers/cover-'.rand(1,3).'.jpg')}}" id="book-image-preview" class="shadow mb-4">
                    @endif
                    <input type="file" name="image" id="book-image" class="form-control" accept="image/*">
                    <input type="hidden" id="book-imageBase64" name="imageBase64" val="">
                    <p class="fs-9 fst-italic text-secondary mt-2 mb-0">*) maximum allowed file size is 2MB</p>
                    <p id="alert-book-image" class="alert alert-danger d-none mt-2"></p>
                </div>
                <div class="mb-3">
                    @if(count($categories) > 0)
                    <label for="book-category" class="form-label">Category</label>
                    <select name="category" id="book-category" class="form-select">
                        <option value="" selected disabled hidden>Select category</option>
                        @foreach($categories as $key => $category)
                        <option value="{{$category->name}}">{{$category->name}}</option>
                        @endforeach
                        <option value="other">Other</option>
                    </select>
                    <div id="book-category-other" class="form-floating mt-3 d-none">
                        <input type="text" id="book-category-other" name="category_other" class="form-control form-control-sm" placeholder="example: math">
                        <label for="book-category-other" class="form-label">Category</label>
                    </div>
                    <p class="fs-9 fst-italic text-secondary mt-2 mb-0">*) required</p>
                    <p id="alert-book-category" class="alert alert-danger d-none mt-2"></p>
                    @else
                    <div class="form-floating">
                        <input type="text" id="book-category" name="category" class="form-control form-control-sm" placeholder="example: math">
                        <label for="book-category" class="form-label">Category</label>
                    </div>
                    <p class="fs-9 fst-italic text-secondary mt-2 mb-0">*) required</p>
                    <p id="alert-book-category" class="alert alert-danger d-none mt-2"></p>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="book-access" class="form-label">Accessibility <i class='bx bx-help-circle' role="button" onclick="modalHelp('book_access')"></i></label>
                    <select name="access" id="book-access" class="form-select">
                        <option value="limited">limited</option>
                        <option value="teacher_only">teacher only</option>
                        <option value="open">open</option>
                    </select>
                </div>
            </div>
            <!-- book image end -->
            <!-- book data start -->
            <div class="col-md-5 px-4 mb-4">
                <p class="fs-11 d-flex align-items-center gap-2 mb-3"><i class="bx bx-calendar"></i>{{date('l, d F Y', time())}}</p>
                <div class="form-floating mb-3">
                    <input id="book-title" name="title" type="text" class="form-control form-control-sm" placeholder="title" value="{{$book->title}}">
                    <label for="book-title" class="form-label">Title</label>
                    <p class="fs-9 fst-italic text-secondary mt-2 mb-0">*) required</p>
                    <p id="alert-book-title" class="alert alert-danger d-none mt-2"></p>
                </div>
                <div class="form-floating mb-3">
                    <input id="book-author" name="author" type="text" class="form-control form-control-sm" placeholder="author" value="{{$book->author}}">
                    <label for="book-author" class="form-label">Author</label>
                    <p id="alert-book-author" class="alert alert-danger d-none mt-2"></p>
                </div>
                <div class="mb-3 d-flex flex-remove-md align-items-center gap-3">
                    <div class="col form-floating mb-2">
                        <input id="book-publisher" name="publisher" type="text" class="form-control form-control-sm" placeholder="publisher" value="{{$book->publisher}}">
                        <label for="book-publisher" class="form-label">Publisher</label>
                        <p id="alert-book-publisher" class="alert alert-danger d-none mt-2"></p>
                    </div>
                    <div class="col form-floating mb-2">
                        <input id="book-publication_year" name="publication_year" type="number" class="form-control form-control-sm" placeholder="publication year" value="{{$book->publication_year}}">
                        <label for="book-publication_year" class="form-label">Publication year</label>
                        <p id="alert-book-publication_year" class="alert alert-danger d-none mt-2"></p>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input id="book-isbn" name="isbn" type="text" class="form-control form-control-sm" placeholder="isbn" value="{{$book->isbn}}">
                    <label for="book-isbn" class="form-label">ISBN</label>
                <p class="fs-9 fst-italic text-secondary mt-2 mb-2">*) International Standard Book Number, book's identification code</p>
                    <p id="alert-book-isbn" class="alert alert-danger d-none mt-2"></p>
                </div>
                <div class="mb-3">
                    <label for="book-description" class="form-label">Description</label>
                    <textarea name="description" id="book-description" class="form-control" style="min-height: 120px" placeholder="description">{{$book->description}}</textarea>
                    <p id="alert-book-description" class="alert alert-danger d-none mt-2"></p>
                </div>
                <div class="form-floating mb-3">
                    <input id="book-keywords" name="keywords" type="text" class="form-control form-control-sm" placeholder="keywords" value="{{$book->keywords}}">
                    <label for="book-keywords" class="form-label">Keywords</label>
                    <p class="fs-9 fst-italic text-secondary mt-2 mb-0">*) use coma ',' as separator between items</p>
                    <p id="alert-book-keywords" class="alert alert-danger d-none mt-2"></p>
                </div>
                <div class="mb-3">
                    <div class="input-group form-floating">
                        <input id="book-url" name="url" type="text" class="form-control form-control-sm" placeholder="url" value="{{$book->url}}">
                        <label for="book-url" class="form-label">URL</label>
                        <a href="/" target="_blank" class="input-group-text"><i class="bx bx-upload"></i></a>
                    </div>
                    <p class="fs-9 fst-italic text-secondary mt-2 mb-2">*) required, link to full content of the book</p>
                    <p class="fs-9 fst-italic text-secondary mt-2 mb-0">*) press the button on the right to upload the book at the school provided drive</p>
                    <p id="alert-book-url" class="alert alert-danger d-none mt-2"></p>
                </div>
                <div class="mb-3">
                    <div class="form-floating">
                        <input type="text" name="source" id="book-source" class="form-control form-control-sm" value="{{$book->source}}" placeholder="source">
                        <label for="book-source" class="form-label">Source</label>
                    </div>
                    <p class="fs-9 fst-italic text-secondary mt-2 mb-2">*) you can put credit author statement or link to the original source of the book</p>
                    <p id="alert-book-source" class="alert alert-danger d-none mt-2"></p>
                </div>
            </div>
            <!-- book data end -->
            <!-- chapters start -->
            <div class="col-md-12 mb-4">
                <h5 class="fs-14 d-flex align-items-center gap-2 mb-2"><i class="bx bx-book-content"></i>Book chapters</h5>
                <p class="mb-3 fs-11">fill this if the book consists of several chapters or parts</p>
                <table id="table-chapters" class="table table-striped align-middle">
                    <thead>
                        <th>#</th>
                        <th>Title</th>
                        <th>URL</th>
                    </thead>
                    <tbody id="tbody-chapter">
                        <?php $i = 1; ?>
                        @forelse($book->chapter->sortBy('number') as $chapter)
                        <tr id="tr-chapter-{{$i}}">
                            <td>{{$chapter->number}}</td>
                            <input type="hidden" name="chapter_number[{{$i}}]" value="{{$i}}">
                            <td><input type="text" id="chapter-title-{{$i}}" name="chapter_title[{{$i}}]" class="form-control form-control-sm" placeholder="title of chapter" value="{{$chapter->title}}"></td>
                            <td><input type="text" id="chapter-url-{{$i}}" name="chapter_url[{{$i}}]" class="form-control form-control-sm" placeholder="link to chapter" value="{{$chapter->url}}"></td>
                        </tr>
                        <?php $i++; ?>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center fst-italic fs-11">No chapter found</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tbody>
                        <tr>
                            <td colspan="3" class="fs-11">
                                <div class="w-100 d-flex justify-content-center gap-3">
                                    <button type="button" class="btn btn-sm btn-outline-danger gap-2 px-4" onclick="removeChapter()"><i class="bx bx-layer-minus"></i>Remove last</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary gap-2 px-4" onclick="addChapter()"><i class="bx bx-layer-plus"></i>Add chapter</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- chapters end -->
            <div class="col-md-12">
                <div class="d-flex flex-align-center gap-2 mb-4">
                    <input type="checkbox" id="book-agreement" name="agreement" value="true" class="" checked>
                    <p class="m-0">This book is <span class="text-primary" style="font-weight:500" role="button" onclick="modalHelp('upload_disclaimer')">safe to be displayed</span> within this App or website</p>
                </div>
                <div class="d-flex flex-align-center justify-content-end gap-3">
                    <a href='/' class="btn btn-secondary btn-submit gap-2"><i class="bx bx-left-arrow-alt"></i>Back</a>
                    <button id="book-submit-button" type="button" class="btn btn-success btn-submit gap-2" onclick="updateBook()"><i class="bx bx-edit-alt"></i>Update book</button>
                </div>
            </div>
        </div>
        </form>
        <!-- form book submission end -->
    </div>
</section>

@include('layouts.partials.modal_help')

@endsection

@push('scripts')
<script type="text/javascript">
let book_category = '{{$book->category->name}}';
let book_access = '{{$book->access}}';
$('#book-category option[value="'+book_category+'"]').prop('selected', true);
$('#book-access option[value="'+book_access+'"]').prop('selected', true);

const updateBook = () => {
    $('.alert').hide();
    // let formData = new FormData($('#form-update-book')[0]);
    let formData = $('#form-update-book').serialize();
    let config = {
        method: $('#form-update-book').attr('method'), url: domain + $('#form-update-book').attr('action'),
        data: formData,
    }
    axios(config)
    .then((response) => {
        successMessage(response.data.message);
        return window.location.href = '/';
    }, 2000)
    .catch((error) => {
        console.log(error.response);
        if(error.response) {
            if(error.response.data.message) {
                errorMessage(error.response.data.message);
            }
            if(error.response.data.errors) {
                if(error.response.data.errors.title) { $('#alert-book-title').html(error.response.data.errors.title).removeClass('d-none').hide().fadeIn('slow'); }
                if(error.response.data.errors.author) { $('#alert-book-author').html(error.response.data.errors.author).removeClass('d-none').hide().fadeIn('slow'); }
                if(error.response.data.errors.publisher) { $('#alert-book-publisher').html(error.response.data.errors.publisher).removeClass('d-none').hide().fadeIn('slow'); }
                if(error.response.data.errors.publication_year) { $('#alert-book-publication_year').html(error.response.data.errors.publication_year).removeClass('d-none').hide().fadeIn('slow'); }
                if(error.response.data.errors.isbn) { $('#alert-book-isbn').html(error.response.data.errors.isbn).removeClass('d-none').hide().fadeIn('slow'); }
                if(error.response.data.errors.description) { $('#alert-book-description').html(error.response.data.errors.description).removeClass('d-none').hide().fadeIn('slow'); }
                if(error.response.data.errors.image) { $('#alert-book-image').html(error.response.data.errors.image).removeClass('d-none').hide().fadeIn('slow'); }
                if(error.response.data.errors.url) { $('#alert-book-url').html(error.response.data.errors.url).removeClass('d-none').hide().fadeIn('slow'); }
                if(error.response.data.errors.keywords) { $('#alert-book-keywords').html(error.response.data.errors.keywords).removeClass('d-none').hide().fadeIn('slow'); }
                if(error.response.data.errors.source) { $('#alert-book-source').html(error.response.data.errors.source).removeClass('d-none').hide().fadeIn('slow'); }
                if(error.response.data.errors.category) { $('#alert-book-category').html(error.response.data.errors.category).removeClass('d-none').hide().fadeIn('slow'); }
            }
        }
    });
}

// agreement start
$('#book-agreement').change(function() {
    if($(this).is(":checked")) {
        $('#book-submit-button').prop('disabled', false);
    } else {
        $('#book-submit-button').prop('disabled', true);
    }
})
// agreement end

// category start
$('#book-category').change(function() {
    if($(this).find(':selected').val() == 'other') {
        $('#book-category-other').removeClass('d-none');
    } else {
        $('#book-category-other').addClass('d-none');
    }
});
// category end

// chapter start
let chapter_index = "{{$i}}";
const addChapter = () => {
    if(chapter_index == 1) {
        $('#tbody-chapter').html('');
    }
    $('#tbody-chapter').append(`
        <tr>
            <td>`+chapter_index+`</td>
            <input type="hidden" name="chapter_number[`+chapter_index+`]" value="`+chapter_index+`">
            <td><input type="text" id="chapter-name-`+chapter_index+`" name="chapter_title[`+chapter_index+`]" class="form-control form-control-sm" placeholder="title of chapter"></td>
            <td><input type="text" id="chapter-url-`+chapter_index+`" name="chapter_url[`+chapter_index+`]" class="form-control form-control-sm" placeholder="link to chapter"></td>
        </tr>
    `);
    chapter_index++;
};
const removeChapter = () => {
    if(chapter_index > 2) {
        $('#tbody-chapter tr:last').remove();
        chapter_index--;
    } else if(chapter_index == 2) {
        $('#tbody-chapter').html(`
            <tr>
                <td colspan="3" class="text-center fst-italic fs-11">No chapter found</td>
            </tr>
        `);
        chapter_index--;
    } else {
        errorMessage('cannot delete anymore than this');
    }
};

// cover image start
$('#book-image').change(function(e){
    $('#alert-book-image').hide();
    let reader = new FileReader();
    if(e.target.files && e.target.files[0]) {
        let file = e.target.files[0];
        const maxAllowedSize = 2 * 1024 * 1024;
        if(file.size > maxAllowedSize) {
            return $('#alert-book-image').html('maximum allowed size exceeded').removeClass('d-none').hide().fadeIn('slow');
        }
    }
    reader.onload = (e) => { 
        $('#book-image-preview').attr('src', e.target.result); 
        $('#book-imageBase64').val(e.target.result);
    }
    reader.readAsDataURL(this.files[0]); 
}); 
// cover image end

$(document).ready(function() {
    $('#link-book').addClass('active');
    $('#submenu-book').addClass('show');
});
</script>
@endpush