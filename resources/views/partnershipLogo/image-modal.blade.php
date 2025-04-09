<div class="modal fade" id="logoModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Logo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="logo_id">
                <div class="mb-3">
                    <label class="form-label">Title:</label>
                    <input type="text" id="title" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Image:</label>
                    <input type="file" id="image" class="form-control">
                    <input type="hidden" id="existing_image">
                </div>
                <div class="mb-3">
                    <img id="preview" src="" class="img-thumbnail" style="width: 100px; display: none;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="saveLogo()" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>
