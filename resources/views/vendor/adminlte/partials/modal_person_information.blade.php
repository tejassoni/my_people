<div class="modal fade bd-example-modal-lg" id="personViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">{{ __('Missing Person Details') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-4">
                        <img class="file_preview_select mb-5" id="missing_person_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="180" width="auto">
                    </div>
                    <div class="col-sm-8">
                        <table class='table' id='missing_person_tbl'>
                            <thead>
                                <tr>
                                    <th scope='col' colspan="4">{{ __('Personal Information') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope='col' class="person_name_label">{{ __('Name :') }}</th>
                                    <td scope='col' class="person_name"></td>
                                    <th scope='col' class="person_gender_label">{{ __('Gender :') }}</th>
                                    <td scope='col' class="person_gender"></td>
                                </tr>
                                <tr>
                                    <th scope='col' class="person_birthdate_label">{{ __('BirthDate:') }}</th>
                                    <td scope='col' class="person_birthdate"></td>
                                    <th scope='col' class="person_age_label">{{ __('Age :') }}</th>
                                    <td scope='col' class="person_age"></td>
                                </tr>
                                <tr>
                                    <th scope='col' class="person_height_label">{{ __('Height:') }}</th>
                                    <td scope='col' class="person_height"></td>
                                    <th scope='col' class="person_weight_label">{{ __('Weight :') }}</th>
                                    <td scope='col' class="person_weight"></td>
                                </tr>
                                <tr>
                                    <th scope='col' class="person_address_label">{{ __('Address :') }}</th>
                                    <td scope='col' class="person_address" colspan="3"></td>
                                </tr>
                                <tr>
                                    <th scope='col' class="person_pincode_label">{{ __('Pincode :') }}</th>
                                    <td scope='col' class="person_pincode"></td>
                                    <th scope='col' class="person_country_label">{{ __('Country :') }}</th>
                                    <td scope='col' class="person_country"></td>
                                </tr>
                                <tr>
                                    <th scope='col' class="person_state_label">{{ __('State :') }}</th>
                                    <td scope='col' class="person_state"></td>
                                    <th scope='col' class="person_city_label">{{ __('City :') }}</th>
                                    <td scope='col' class="person_city"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row d-block text-center">
                    <div class="border-bottom">
                        <h4>{{ __('Person Identity Hint / Guide Images For Easy to Find') }}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">{{ __('Face / Jaw Shape') }}</span>
                        <img class="file_preview_select mb-5 img-fluid" id="missing_person_face_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">{{ __('Skin Type') }}</span>
                        <img class="file_preview_select mb-5 img-fluid" id="missing_person_skin_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">{{ __('Hair Style Type') }}</span>
                        <img class="file_preview_select mb-5 img-fluid" id="missing_person_hair_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">{{ __('Nose Shape') }}</span>
                        <img class="file_preview_select mb-5 img-fluid" id="missing_person_nose_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">{{ __('EyeBrow Shape') }}</span>
                        <img class="file_preview_select mb-5 img-fluid" id="missing_person_eyebrow_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">{{ __('Eye Shape') }}</span>
                        <img class="file_preview_select mb-5 img-fluid" id="missing_person_eye_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">{{ __('Ear Shape') }}</span>
                        <img class="file_preview_select mb-5 img-fluid" id="missing_person_ear_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">{{ __('Lip Shape') }}</span>
                        <img class="file_preview_select mb-5 img-fluid" id="missing_person_lip_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                </div>

                <div class="row d-block text-center">
                    <div class="border-top">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <h6><b>{{ __('Cloths Description') }}</b></h6>
                        <p class="cloths_description"></p>
                    </div>
                    <div class="col-sm-6">
                        <h6><b>{{ __('Remarks') }}</b></h6>
                        <p class="remarks_description"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class='table' id='missing_person_tbl'>
                            <thead>
                                <tr>
                                    <th scope='col' colspan="4">{{ __('Parents / Relatives Information') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope='col' class="parent_name_label" width="20%">{{ __('Parents Name :') }}</th>
                                    <td scope='col' class="parent_name" width="25%"></td>
                                    <th scope='col' class="parent_address_label" width="15%">{{ __('Parents Address :') }}</th>
                                    <td scope='col' class="parent_address" width="35%"></td>
                                </tr>
                                <tr>
                                    <th scope='col' class="parent_email_label" width="20%">{{ __('Parents Email :') }}</th>
                                    <td scope='col' class="parent_email"></td>
                                    <th scope='col' class="parent_mobile_label" width="15%">{{ __('Parents Contact :') }}</th>
                                    <td scope='col' class="parent_mobile" width="35%"></td>
                                </tr>
                                <tr>
                                    <th scope='col' class="parent_rewards_label">{{ __('Rewards Amount') }}:</th>
                                    <td scope='col' class="parent_rewards" colspan="3">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _('Close') }}</button>
            </div>
        </div>
    </div>
</div>