@extends('adminlte::page')

@section('title', 'AdminLTE')
@include('vendor.adminlte.partials.header_response_messages')
@section('content_header')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><a href='{{ url("/customer/missing_person_add") }}' class="btn-success btn-sm" title="Add New Button"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?= ('Add New') ?></a></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/customer/missing_person_list" title="Missing Persons"><?= ('Missing Persons') ?></a>
        </li>
        <li class="breadcrumb-item active"><?= ('List') ?></li>
      </ol>
    </nav>
  </div>
</div>
@stop

@section('content')
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <!-- <div class="card-header">
              <h3 class="card-title">DataTable with minimal features &amp; hover style</h3>
            </div> -->
        <!-- /.card-header -->
        <div class="card-body">
          <table id="missing_person_list_table" class="display datatables table table-striped table-bordered w-100">
            <thead>
              <tr>
                <th><?= ('Name') ?></th>
                <th><?= ('Image') ?></th>
                <th><?= ('Location') ?></th>
                <th><?= ('Age') ?></th>
                <th><?= ('Missing Date') ?></th>
                <th><?= ('Emergency Contact') ?></th>
                <th><?= ('Missing Status') ?></th>
                <th><?= ('Action') ?></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div> <!-- /.card-body -->
      </div> <!-- /.card -->

    </div> <!-- /.col -->
  </div> <!-- /.col -->
  <!-- Modal -->

  <!-- Missing Person Details Bootstrap Modal Starts -->
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
              <img class="file_preview_select mb-5" id="missing_person_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="250" width="auto">
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
                    <td scope='col' class="person_name">Mark Tesla Patel</th>
                    <th scope='col' class="person_gender_label">Gender :</th>
                    <td scope='col' class="person_gender">Male</th>
                  </tr>
                  <tr>
                    <th scope='col' class="person_birthdate_label">BirthDate:</th>
                    <td scope='col' class="person_name">31/01/1989</th>
                    <th scope='col' class="person_gender_label">Age :</th>
                    <td scope='col' class="person_gender">29</th>
                  </tr>
                  <tr>
                    <th scope='col' class="person_address_label">Address :</th>
                    <td scope='col' class="person_address" colspan="3">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</th>
                  </tr>
                  <tr>
                    <th scope='col' class="person_birthdate_label">Pincode :</th>
                    <td scope='col' class="person_name">390021</th>
                    <th scope='col' class="person_gender_label">Country :</th>
                    <td scope='col' class="person_gender">India</th>
                  </tr>
                  <tr>
                    <th scope='col' class="person_birthdate_label">State :</th>
                    <td scope='col' class="person_name">Gujarat</th>
                    <th scope='col' class="person_gender_label">City :</th>
                    <td scope='col' class="person_gender">Surat</th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2 person_additional_details">
              <span class="d-block text-center">Face / Jaw</span>
              <img class="file_preview_select mb-5" id="missing_person_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
            </div>
            <div class="col-sm-2 person_additional_details">
              <span class="d-block text-center">Skin</span>
              <img class="file_preview_select mb-5" id="missing_person_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
            </div>
            <div class="col-sm-2 person_additional_details">
              <span class="d-block text-center">Hair</span>
              <img class="file_preview_select mb-5" id="missing_person_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
            </div>
            <div class="col-sm-2 person_additional_details">
              <span class="d-block text-center">Nose</span>
              <img class="file_preview_select mb-5" id="missing_person_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
            </div>
          </div>

          <div class="row">
            <div class="col-sm-2 person_additional_details">
              <span class="d-block text-center">EyeBrow</span>
              <img class="file_preview_select mb-5" id="missing_person_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
            </div>
            <div class="col-sm-2 person_additional_details">
              <span class="d-block text-center">Eye</span>
              <img class="file_preview_select mb-5" id="missing_person_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
            </div>
            <div class="col-sm-2 person_additional_details">
              <span class="d-block text-center">Ear</span>
              <img class="file_preview_select mb-5" id="missing_person_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
            </div>
            <div class="col-sm-2 person_additional_details">
              <span class="d-block text-center">Lip</span>
              <img class="file_preview_select mb-5" id="missing_person_view" alt="Image Preview" src="{{ asset('assets/no-preview.jpg') }}" height="150" width="auto">
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <h5><b>Cloths Description</b></h5>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting
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
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting
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
                      </th>
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
  <!-- Missing Person Details Bootstrap Modal Ends -->

  <!-- Customer Request Find Details Bootstrap Modal Starts -->
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
  <!-- Customer Request Find  Bootstrap Modal Ends -->

</section>

@stop