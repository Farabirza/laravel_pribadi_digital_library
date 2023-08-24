@push('css-styles')
<style>
#modal-quickEdit .form-label { color: var(--bs-primary); font-size: 10pt; }
#modal-quickEdit input { font-size: 9pt; }
</style>
@endpush

<div class="modal fade" id="modal-chapters" aria-hidden="true"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title d-flex align-items-center gap-2"><i class='bx bx-list-ul'></i><span>Book chapters</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3 fs-11">Select the link below to go to the section of the book you're looking for :</p>
                <a target="_blank" href="/" id="chapter-main" class="btn btn-sm btn-primary rounded-pill mb-2">Full content</a>
                <div id="container-chapters" class="fs-11"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-quickEdit" aria-hidden="true"> 
    <div class="modal-dialog modal-lg">
        <form action="/book/quick_update" method="post" id="form-quickEdit" class="m-0">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title d-flex align-items-center gap-2"><i class='bx bx-edit-alt'></i><span>Quick edit</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="quickEdit-book_id" name="book_id">
                <div class="mb-3 d-flex flex-remove-md gap-3">
                    <div class="col mb-2">
                        <label for="quickEdit-title" class="form-label">Title</label>
                        <input type="text" id="quickEdit-title" name="title" class="form-control form-control-sm" value="" required>
                    </div>
                    <div class="col mb-2">
                        <label for="quickEdit-author" class="form-label">Author</label>
                        <input type="text" id="quickEdit-author" name="author" class="form-control form-control-sm" value="">
                    </div>
                </div>
                <div class="mb-3 d-flex flex-remove-md gap-3">
                    <div class="col mb-2">
                        <label for="quickEdit-publisher" class="form-label">Publisher</label>
                        <input type="text" id="quickEdit-publisher" name="publisher" class="form-control form-control-sm" value="">
                    </div>
                    <div class="col mb-2">
                        <label for="quickEdit-publication_year" class="form-label">Publication year</label>
                        <input type="number" id="quickEdit-publication_year" name="publication_year" class="form-control form-control-sm" value="">
                    </div>
                    <div class="col mb-2">
                        <label for="quickEdit-isbn" class="form-label">ISBN</label>
                        <input type="text" id="quickEdit-isbn" name="isbn" class="form-control form-control-sm" value="">
                    </div>
                </div>
                <div class="mb-3 d-flex flex-remove-md gap-3">
                    <div class="col mb-2">
                        <label for="quickEdit-url" class="form-label">URL</label>
                        <input type="text" id="quickEdit-url" name="url" class="form-control form-control-sm" value="">
                    </div>
                    <div class="col mb-2">
                        <label for="quickEdit-source" class="form-label">Source</label>
                        <input type="text" id="quickEdit-source" name="source" class="form-control form-control-sm" value="">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="quickEdit-description" class="form-label">Description</label>
                    <textarea name="description" id="quickEdit-description" class="form-control form-control-sm"></textarea>
                </div>
                <div class="mb-3">
                    <label for="quickEdit-keywords" class="form-label">Keywords</label>
                    <input type="text" id="quickEdit-keywords" name="keywords" class="form-control form-control-sm" value="">
                </div>
                @if(isset($categories))
                <div class="mb-3">
                    <label for="quickEdit-category_id" class="form-label">Category</label>
                    <select name="category_id" id="quickEdit-category_id" class="form-select form-select-sm">
                        @forelse($categories as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @empty
                        <option value="">No category has been made</option>
                        @endforelse
                    </select>
                </div>
                @endif
            </div>
            <div class="modal-footer gap-2">
                <button type="button" class="btn btn-sm btn-secondary gap-1" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i>Cancel</button>
                <a href="/" id="btn-quickEdit-edit" class="btn btn-sm btn-success gap-1"><i class='bx bx-edit-alt' ></i>Full edit</a>
                <button type="submit" id="btn-quickEdit-submit" class="btn btn-sm btn-primary gap-1"><i class='bx bx-save' ></i>Save</button>
            </div>
        </div>
        </form>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
const modalChapters = (book_id, item_id) => {
    $('#chapter-main').attr('href', book_id +'/0/read');
    $('#container-chapters').html('');
    if($('#book-chapter-count-'+item_id).val() > 0) {
        for(let i = 1; i <= $('#book-chapter-count-'+item_id).val(); i++) {
            $('#container-chapters').append(`
                <a href="`+ book_id +'/'+ $('#book-chapter-id-'+item_id+'-'+i).val() +`/read" class="btn btn-sm btn-outline-primary rounded-pill mb-2">`+ $('#book-chapter-title-'+item_id+'-'+i).val() +`</a>
            `);
        }
    }
    $('#modal-chapters').modal('show');
}

const modalQuickEdit = (book_id, item_id) => {
    $('#form-quickEdit').trigger('reset');
    let category_id = $('#book-category_id-'+item_id).val();
    $('#quickEdit-category_id option[value="'+category_id+'"]').prop('selected', true);
    $('#quickEdit-book_id').val($('#book-id-'+item_id).val());
    $('#quickEdit-title').val($('#book-title-'+item_id).html());
    $('#quickEdit-author').val($('#book-author-'+item_id).val());
    $('#quickEdit-publisher').val($('#book-publisher-'+item_id).val());
    $('#quickEdit-publication_year').val($('#book-publication_year-'+item_id).val());
    $('#quickEdit-isbn').val($('#book-isbn-'+item_id).val());
    $('#quickEdit-url').val($('#book-url-'+item_id).val());
    $('#quickEdit-source').val($('#book-source-'+item_id).val());
    $('#quickEdit-description').val($('#book-description-'+item_id).val());
    $('#quickEdit-keywords').val($('#book-keywords-'+item_id).val());
    $('#btn-quickEdit-edit').attr('href', '/book/'+book_id+'/edit');
    $('#modal-quickEdit').modal('show');
};
</script>
@endpush