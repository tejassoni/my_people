<div class="modal fade" id="personRequestModal" tabindex="-1" role="dialog" aria-labelledby="personRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Parents Message </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <div class="form-group custom-file mb-3">
                            <input type="file" class="custom-file-input" id="find_person_img" name="filename">
                            <label class="custom-file-label" for="customFile">Upload Find Person Image</label>
                            <!-- File preview Starts -->
                            <img class="file_preview mb-5 d-none" id="img_view" alt="Image Preview" src="#" height="70" width="70">
                            <button type="button" class="file_preview close float-left d-none" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <!-- File preview Ends -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send Message</button>
            </div>
        </div>
    </div>
</div>