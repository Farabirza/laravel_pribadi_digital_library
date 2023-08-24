@push('css-styles')
<style>
.modal .form-label { color: var(--bs-primary); font-size: 10pt; }
</style>
@endpush

<div class="modal fade" id="modal-category" aria-hidden="true"> 
    <div class="modal-dialog">
        <form action="/category" method="post" id="form-category" class="m-0">
        @csrf
        <input type="hidden" name="action" id="category-action" value="">
        <input type="hidden" name="category_id" id="category-id" value="">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title d-flex align-items-center gap-2"><i class='bx bx-category'></i><span>Category</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-floating">
                    <input type="text" id="category-name" name="name" class="form-control" placeholder="name">
                    <label for="category-name" class="form-label">Name</label>
                </div>
            </div>
            <div class="modal-footer gap-2">
                <button type="button" class="btn btn-sm btn-secondary gap-1" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i>Cancel</button>
                <a href="/category/0/delete" id="btn-category-delete" class="btn btn-sm btn-danger gap-1 btn-warn" data-warning="You wish to delete this category?"><i class='bx bx-trash-alt' ></i>Delete</a>
                <button type="submit" id="btn-category-submit" class="btn btn-sm btn-primary gap-1"><i class='bx bx-save' ></i>Save</button>
            </div>
        </div>
        </form>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
const modalCategory = (action, category_id, name) => {
    $('#form-category').trigger('reset');
    if(action == 'edit') {
        $('#btn-category-delete').attr('href', '/category/'+ category_id +'/delete');
        $('#category-action').val('update');
        $('#category-id').val(category_id);
        $('#category-name').val(name);
    } else {
        $('#category-action').val('store');
    }
    $('#modal-category').modal('show');
}
</script>
@endpush