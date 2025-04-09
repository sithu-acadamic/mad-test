<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="service_id">

                <div class="mb-3">
                    <label class="form-label">Title 1:</label>
                    <input type="text" id="title_one" name="title_one"  class="form-control">

                    <input type="checkbox" id="title_one_color" name="title_one_color">
                    <label for="title_one_color">Apply Color to Title One</label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Title 2:</label>
                    <input type="text" id="title_two" name="title_two"  class="form-control">

                    <input type="checkbox" id="title_two_color" name="title_two_color">
                    <label for="title_two_color">Apply Color to Title two</label>
                </div>


                <div class="mb-3">
                    <label class="form-label">Image:</label>
                    <input type="file" id="image" class="form-control">
                    <input type="hidden" id="existing_image">
                    <div class="mt-2">
{{--                        <img id="preview" src=""  class="img-thumbnail" style="width: 100px; display: none;">--}}
                        <img id="imagePreview" src="" width="100" height="100" style="display: none; margin-top: 10px;">
                    </div>

                </div>

                <div class="mb-3">
                    <label class="form-label">Description:</label>
                    <textarea id="description" class="form-control" name="description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="saveService()" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>
