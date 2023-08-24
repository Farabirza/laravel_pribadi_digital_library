@push('css-styles')
<style>
#modal-quickEdit .form-label { color: var(--bs-primary); font-size: 10pt; }
#modal-quickEdit input { font-size: 9pt; }
</style>
@endpush

<div class="modal fade" id="modal-help" aria-hidden="true"> 
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title d-flex align-items-center gap-2 fs-14" style="font-weight:500"><i class='bx bx-help-circle'></i><span id="modal-help-title">Help</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="modal-help-body" class="modal-body fs-11">
            </div>
            <div class="modal-footer gap-2">
                <button type="button" class="btn btn-sm btn-secondary gap-1" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-arrow-back'></i>Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
const modalHelp = (topic) => {
    let modal_title = '';
    let modal_content = '';
    switch(topic) {
        case 'book_access':
            modal_title = 'About book access';
            modal_content = `
                <p class="mb-1">This option will determine who can view and access the book:</p>
                <ul>
                    <li><b>Open</b>, anyone can view and access this book including guest. If you choose this option, you have to make sure that <b>you have the permission of the publisher</b>. You also have to attach the source info in the provided input field.</li>
                    <li><b>Limited</b>, only registered user can view and access this book. This is the <b>default</b> setting.</li>
                    <li><b>Teacher only</b>, student can't view or access this book.</li>
                </ul>
            `;
        break;
        case 'upload_disclaimer':
            modal_title = 'Disclaimer for uploading book';
            modal_content = `
            <p>By uploading a book to the school web application, you confirm that you have the legal right to do so and that the content of the uploaded book does not violate any copyright laws or contain inappropriate content. You, as the uploader, acknowledge and agree to the following terms and conditions:</p>
            <ol>
                <li><strong>Copyright Ownership and Permissions:</strong> You certify that you are the copyright owner of the uploaded book, or you have obtained explicit permission from the copyright owner to upload the book to the school web application. You understand that any violation of copyright laws is your sole responsibility and could result in legal actions.</li>
                <li><strong>Inappropriate Content:</strong> You affirm that the uploaded book does not contain any content that is defamatory, offensive, discriminatory, obscene, or otherwise inappropriate for educational purposes. You understand that the school administration reserves the right to remove any content that is deemed inappropriate.</li>
                <li><strong>Responsibility for Uploaded Content:</strong> You take full responsibility for the accuracy, quality, and legality of the uploaded book and its content. The school and the web application developers shall not be held liable for any claims, losses, or damages arising from the uploaded content.</li>
                <li><strong>Indemnification:</strong> You agree to indemnify and hold harmless the school, its staff, and the web application developers from any claims, demands, or actions arising out of or related to the content you have uploaded.</li>
                <li><strong>Compliance with Policies:</strong> You agree to comply with all school policies, including copyright and content guidelines, when uploading books to the web application.</li>
            </ol>
            <p>By proceeding to upload a book, you acknowledge that you have read and understood this disclaimer and that you will adhere to its terms and conditions. The school reserves the right to remove any uploaded content that does not adhere to these terms.</p>
            `;
    }
    $('#modal-help-title').html(modal_title);
    $('#modal-help-body').html(modal_content);
    $('#modal-help').modal('show');
};
</script>
@endpush