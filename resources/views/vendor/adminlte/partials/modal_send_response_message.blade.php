<div class="modal fade" id="personResponseModal" tabindex="-1" role="dialog" aria-labelledby="personResponseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Send Response To Person Who Found') }} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class="statusMsg"></p>
            <form id="response_form" name="response_form" action='' method="post">
                <div class="modal-body">

                    <div class="row">
                        <h6><b>{{ __('Missing Person Details') }}</b></h6>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <img class="file_preview_select mb-1 img-fluid" id="missing_person_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="180" width="auto">
                        </div>
                        <div class="col-sm-6">
                            <span><b>{{ __('Message : ') }}</b></span><span id="missing_message"></span><br>
                        </div>
                    </div>

                    <div class="row">
                        <h6><b>{{ __('Response Person Details') }}</b></h6>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <img class="file_preview_select mb-1 img-fluid" id="find_img_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="180" width="auto">
                        </div>
                        <input type='hidden' id='find_id_hidden' name='find_id_hidden' value=''>
                        <input type='hidden' id='missing_id_hidden' name='missing_id_hidden' value=''>

                        <div class="col-sm-6">
                            <span><b>{{ __('Name : ') }}</b></span><span id="response_name"></span><br>
                            <span><b>{{ __('Email : ') }}</b></span><span id="response_email"></span><br>
                            <span><b>{{ __('Mobile : ') }}</b></span><span id="response_mobile"></span><br>
                            <span><b>{{ __('Address : ') }}</b></span><span id="response_address"></span>
                        </div>
                    </div>
                    <div class="row"></div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group required">
                                <label><?= ('Select Status') ?></label>
                                <select class="form-control" name="status_select" id="status_select" required>
                                    <option value="" disabled selected><?= ('Select Status') ?></option>
                                    <option value="accept"><?= ('Accept') ?></option>
                                    <option value="reject"><?= ('Reject') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_close" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary btn_response_submit">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>