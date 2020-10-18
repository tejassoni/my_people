<div class="modal fade" id="personRequestModal" tabindex="-1" role="dialog" aria-labelledby="personRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">{{ __('Send Parents Message You Have Found Missing Person') }} </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="statusMsg"></p>
            <form id="request_form" name="request_form" action='' method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-group custom-file mb-3">
                            <input type="file" class="custom-file-input" id="find_person_img" name="filename">
                            <input type='hidden' id='missing_id' name='missing_id' value=''>
                            <label class="custom-file-label" for="customFile">{{ __('Upload Image Of Missing Person You Have Find') }} <span style="color:red;">*</span></span></label>
                            <!-- File preview Starts -->
                            <img class="file_preview mb-5 d-none" id="img_view" alt="Image Preview" src="#" height="70" width="70">
                            <button type="button" class="file_preview close float-left d-none" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <!-- File preview Ends -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">{{ __('Message:') }}</label>
                        <textarea class="form-control" id="message" name="message" placeholder="Enter Message"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_close" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary btn_request_submit">{{ __('Send Message') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>