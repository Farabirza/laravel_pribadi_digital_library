@push('css-styles')
<style>
#modal-review .form-label, #modal-report .form-label { color: var(--bs-primary); font-size: 10pt; }
.modal input { font-size: 9pt; }

.review-rating:not(:checked) > input {
  /* position: absolute; */
  appearance: none;
}

.review-rating:not(:checked) > label {
  float: right;
  cursor: pointer;
  color: #666;
}

.review-rating:not(:checked) > label:before {
  content: '★';
}

.review-rating > input:checked + label:hover,
.review-rating > input:checked + label:hover ~ label,
.review-rating > input:checked ~ label:hover,
.review-rating > input:checked ~ label:hover ~ label,
.review-rating > label:hover ~ input:checked ~ label {
  color: #e58e09;
}

.review-rating:not(:checked) > label:hover,
.review-rating:not(:checked) > label:hover ~ label {
  color: #ff9e0b;
}

.review-rating > input:checked ~ label {
  color: #ffa723;
}
</style>
@endpush
<input type="text" name="subject" id="report-user-subject" value="{{($report != null ? $report->subject : '')}}" class="d-none">
<input type="text" name="comment" id="report-user-comment" value="{{($report != null ? $report->comment : '')}}" class="d-none">
<input type="number" name="rating" id="review-user-rating" value="{{($review != null ? $review->rating : '')}}" class="d-none">
<input type="text" name="comment" id="review-user-comment" value="{{($review != null ? $review->comment : '')}}" class="d-none">

<!-- modal review start -->
<div class="modal fade" id="modal-review" aria-hidden="true"> 
    <div class="modal-dialog">
        <form action="/review" method="post" id="form-review" class="m-0">
        @csrf
        <input type="hidden" id="review-book_id" name="book_id">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title d-flex align-items-center gap-2"><i class='bx bx-message-alt'></i><span>Review</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fs-11">Please tell us your thought about this book</p>
                <label class="form-label">Rating</label>
                <div class="mb-3 d-flex justify-content-center border rounded">
                    <div class="review-rating" style="font-size:50px">
                        <input type="radio" id="review-star-5" name="rating" value="5" class="d-none">
                        <label for="review-star-5" class="popper" title="&#129321; Amazing!"></label>
                        <input type="radio" id="review-star-4" name="rating" value="4" class="d-none">
                        <label for="review-star-4" class="popper" title="&#128516; Interesting"></label>
                        <input type="radio" id="review-star-3" name="rating" value="3" class="d-none">
                        <label for="review-star-3" class="popper" title="&#128528; Average"></label>
                        <input type="radio" id="review-star-2" name="rating" value="2" class="d-none">
                        <label for="review-star-2" class="popper" title="&#128542; Not good"></label>
                        <input type="radio" id="review-star-1" name="rating" value="1" class="d-none">
                        <label for="review-star-1" class="popper" title="&#128555; Please take this down!"></label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="review-comment" class="form-label">Comment</label>
                    <textarea name="comment" id="review-comment" class="form-control" style="min-height:120px"></textarea>
                </div>
            </div>
            <div class="modal-footer gap-2">
                <button type="button" class="btn btn-sm btn-secondary gap-1" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i>Cancel</button>
                <a href="/review/delete" id="btn-review-delete" class="btn btn-sm btn-danger gap-1 btn-warn" data-waring=""><i class='bx bx-trash-alt'></i>Delete</a>
                <button type="submit" id="btn-review-submit" class="btn btn-sm btn-success gap-1"><i class='bx bx-mail-send' ></i>Post</button>
            </div>
        </div>
        </form>
    </div>
</div>
<!-- modal review end -->

<!-- modal report start -->
<div class="modal fade" id="modal-report" aria-hidden="true"> 
    <div class="modal-dialog">
        <form action="/report" method="post" id="form-report" class="m-0">
        @csrf
        <input type="hidden" id="report-book_id" name="book_id">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title d-flex align-items-center gap-2"><i class='bx bx-flag'></i><span>Report</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 form-floating">
                  <select name="subject" id="select-report-subject" class="form-select form-select-sm">
                    <option value="Broken link">Link towards book's content is not working</option>
                    <option value="Broken link">Part of the book is missing</option>
                    <option value="Inappropriate content">This book contains inappropriate content</option>
                    <option value="Information inaccurate">Some information regarding this book is inaccurate</option>
                    <option value="Other">Other</option>
                  </select>
                  <label for="select-report-subject" class="form-label">Subject</label>
                </div>
                <div class="mb-3">
                  <label for="report-comment" class="form-label">Comment</label>
                  <textarea name="comment" id="report-comment" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer gap-2">
                <button type="button" class="btn btn-sm btn-secondary gap-1" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i>Cancel</button>
                <a href="/report/delete" id="btn-report-delete" class="btn btn-sm btn-danger gap-1 btn-warn" data-waring=""><i class='bx bx-trash-alt'></i>Delete</a>
                <button type="submit" id="btn-report-submit" class="btn btn-sm btn-success gap-1"><i class='bx bx-mail-send' ></i>Send</button>
            </div>
        </div>
        </form>
    </div>
</div>
<!-- modal report end -->

@push('scripts')
<script type="text/javascript">
const modalReport = (book_id) => {
  $('#btn-report-delete').attr('href', '/report/'+ book_id +'/delete');
  $('#report-book_id').val(book_id);
  $('#select-report-subject option[value="'+$('#report-user-subject').val()+'"]').prop('selected', true);
  $('#report-comment').val($('#report-user-comment').val());
  $('#modal-report').modal('show');
}

const modalReview = (book_id) => {
  let rating = $('#review-user-rating').val();
  $('#form-review').trigger('clear');
  $('#btn-review-delete').attr('href', '/review/'+ book_id +'/delete');
  $('#review-book_id').val(book_id);
  if(rating) {
      $('#review-star-'+ rating).prop('checked', true);
  }
  $('#review-comment').val($('#review-user-comment').val());
  $('#modal-review').modal('show');
};

</script>
@endpush