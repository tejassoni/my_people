@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Ear Edit') ?></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/admin/ear_list" title="Ears"><?= ('Ears') ?></a>
        </li>
        <li class="breadcrumb-item active"><?= ('Edit') ?></li>
      </ol>
    </nav>
  </div>
</div>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><?= ('Edit Ear') ?></h3>
          </div>
          <!-- /.card-header -->
          @if(!empty($ear_result))
          <!-- form start -->
          <form role="form" name="ear_edit" id="ear_edit" method="post" action="{{ url('admin/ear_update',[$ear_result->ear_id]) }}" enctype="multipart/form-data">
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            @method('PUT')
            <div class="card-body">
              <div class="form-group required">
                <label for="ear_name">Name</label>
                <input type="text" class="form-control" name="ear_name" id="ear_name" placeholder="Enter Ear Name" value="{{ (is_array(old()) && !empty(old('ear_name')))? old('ear_name') : $ear_result->ear_name }}">
              </div>
              <div class="form-group required">
                <label for="ear_color"><?= ('Color') ?></label>
                <input type="text" class="form-control" name="ear_color" id="ear_color" placeholder="Select Ear Color" value="{{ (is_array(old()) && !empty(old('ear_color')))? old('ear_color') : $ear_result->ear_color }}" />
              </div>
              <div class="form-group required">
                <label for="ear_description">Description</label>
                <textarea class="form-control" name="ear_description" id="ear_description" rows="3" placeholder="Enter Ear Description" required>{{ (is_array(old()) && !empty(old('ear_description')))? old('ear_description') : $ear_result->ear_description }}</textarea>
              </div>
              <div class="form-group custom-file mb-3">
                <input type="file" class="custom-file-input" id="ear_img" name="filename">
                <label class="custom-file-label" for="customFile">Choose file</label>
                <input type="hidden" class="form-control" id="ear_img_hidden" name="filename_hidden" value="{{ (is_array(old()) && !empty(old('ear_img')))? old('ear_img') : $ear_result->ear_img }}">
                <!-- File preview Starts -->
                <img class="file_preview mb-5 {{ (!empty($ear_result->ear_img))? '' : 'd-none' }}" id="img_view" alt="Image Preview" src="{{ (is_array(old()) && !empty(old('ear_img')))? old('ear_img') : $ear_result->ear_img }}" height="70" width="70">
                <button type="button" class="file_preview close float-left {{ (!empty($ear_result->ear_img))? '' : 'd-none' }}" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <!-- File preview Ends -->
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" name="status" id="status" @if(is_array(old()) && old('status')=='on' ) checked @elseif((is_array(old()) && empty(old())) && $ear_result->status)
                  checked
                  @endif>
                  <label class="custom-control-label" for="status">Status</label>
                </div>
              </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{ url('admin/role_list') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> Back</a> &nbsp;
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
          @else
          <center>
            <h6 class="mt-5 mb-5"> Unable to Update Records </h6>
          </center>
          @endif
        </div>
        <!-- /.card -->



      </div>
      <!--/.col (left) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<script src="{{ asset('vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}" defer></script>
<script src="{{ asset('js/admin/ear_master.js') }}" defer></script>
@stop