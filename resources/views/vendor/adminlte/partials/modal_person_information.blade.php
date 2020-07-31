<div class="modal fade bd-example-modal-lg" id="personViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Missing Person Details</h5>
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
                                    <th scope='col' colspan="4">Personal Information</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope='col' class="person_name_label">Name :</th>
                                    <td scope='col' class="person_name">Mark Tesla Patel</td>
                                    <th scope='col' class="person_gender_label">Gender :</th>
                                    <td scope='col' class="person_gender">Male</td>
                                </tr>
                                <tr>
                                    <th scope='col' class="person_birthdate_label">BirthDate:</th>
                                    <td scope='col' class="person_birthdate">31/01/1989</td>
                                    <th scope='col' class="person_age_label">Age :</th>
                                    <td scope='col' class="person_age">29</td>
                                </tr>
                                <tr>
                                    <th scope='col' class="person_height_label">Height:</th>
                                    <td scope='col' class="person_height">156</td>
                                    <th scope='col' class="person_weight_label">Weight :</th>
                                    <td scope='col' class="person_weight">88</td>
                                </tr>
                                <tr>
                                    <th scope='col' class="person_address_label">Address :</th>
                                    <td scope='col' class="person_address" colspan="3">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</td>
                                </tr>
                                <tr>
                                    <th scope='col' class="person_pincode_label">Pincode :</th>
                                    <td scope='col' class="person_pincode">390021</td>
                                    <th scope='col' class="person_country_label">Country :</th>
                                    <td scope='col' class="person_country">India</td>
                                </tr>
                                <tr>
                                    <th scope='col' class="person_state_label">State :</th>
                                    <td scope='col' class="person_state">Gujarat</td>
                                    <th scope='col' class="person_city_label">City :</th>
                                    <td scope='col' class="person_city">Surat</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">Face / Jaw</span>
                        <img class="file_preview_select mb-5" id="missing_person_face_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">Skin</span>
                        <img class="file_preview_select mb-5" id="missing_person_skin_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">Hair</span>
                        <img class="file_preview_select mb-5" id="missing_person_hair_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">Nose</span>
                        <img class="file_preview_select mb-5" id="missing_person_nose_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">EyeBrow</span>
                        <img class="file_preview_select mb-5" id="missing_person_eyebrow_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">Eye</span>
                        <img class="file_preview_select mb-5" id="missing_person_eye_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">Ear</span>
                        <img class="file_preview_select mb-5" id="missing_person_ear_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                    <div class="col-sm-2 person_additional_details">
                        <span class="d-block text-center">Lip</span>
                        <img class="file_preview_select mb-5" id="missing_person_lip_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <h5><b>Cloths Description</b></h5>
                        <p class="cloths_description">Lorem Ipsum is simply dummy text of the printing and typesetting
                            industry. Lorem Ipsum has been the industry's standard dummy
                            text ever since the 1500s, when an unknown printer took a galley
                            of type and scrambled it to make a type specimen book. It has
                            survived not only five centuries, but also the leap into electronic
                            typesetting, remaining essentially unchanged. It was popularised in
                            the 1960s with the release of Letraset sheets containing Lorem
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <h5><b>Remarks</b></h5>
                        <p class="remarks_description">Lorem Ipsum is simply dummy text of the printing and typesetting
                            industry. Lorem Ipsum has been the industry's standard dummy
                            text ever since the 1500s, when an unknown printer took a galley
                            of type and scrambled it to make a type specimen book. It has
                            survived not only five centuries, but also the leap into electronic
                            typesetting, remaining essentially unchanged. It was popularised in
                            the 1960s with the release of Letraset sheets containing Lorem
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class='table' id='missing_person_tbl'>
                            <thead>
                                <tr>
                                    <th scope='col' colspan="4">Parents / Relatives Information</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope='col' class="parent_name_label" width="20%">Parents Name :</th>
                                    <td scope='col' class="parent_name" width="25%">Parents Tesla Patel</td>
                                    <th scope='col' class="parent_address_label" width="15%">Parents Address :</th>
                                    <td scope='col' class="parent_address" width="35%">Lorem Ipsum is simply dummy text of the printing and typesetting
                                        industry. Lorem Ipsum has been the industry's standard dummy
                                        text ever since the 1500s, when an unknown printer took a galley
                                        of type and scrambled it to make a type specimen book. It has
                                        survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in
                                        the 1960s with the release of Letraset sheets containing Lorem</td>
                                </tr>
                                <tr>
                                    <th scope='col' class="parent_email_label" width="20%">Parents Email :</th>
                                    <td scope='col' class="parent_email">parent@gmail.com</td>
                                    <th scope='col' class="parent_mobile_label" width="15%">Parents Contact :</th>
                                    <td scope='col' class="parent_mobile" width="35%">+94 91919191911</td>
                                </tr>
                                <tr>
                                    <th scope='col' class="parent_rewards_label">Rewards :</th>
                                    <td scope='col' class="parent_rewards" colspan="3">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>