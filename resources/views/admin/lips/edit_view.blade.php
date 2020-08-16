@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Lip Edit') ?></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/admin/lip_list" title="Lips"><?= ('Lips') ?></a>
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
            <h3 class="card-title"><?= ('Edit Lip') ?></h3>
          </div>
          <!-- /.card-header -->
          @if(!empty($lip_result))
          <!-- form start -->
          <form role="form" name="lip_edit" id="lip_edit" method="post" action="{{ url('admin/lip_update',[$lip_result->lip_id]) }}" enctype="multipart/form-data">
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            @method('PUT')
            <div class="card-body">
              <div class="form-group required">
                <label for="lip_name"><?= ('Name') ?></label>
                <input type="text" class="form-control" name="lip_name" id="lip_name" placeholder="Enter Lip Name" value="{{ (is_array(old()) && !empty(old('lip_name')))? old('lip_name') : $lip_result->lip_name }}" required />
              </div>
              <div class="form-group required">
                <label for="lip_color"><?= ('Color') ?></label>
                <input type="text" class="form-control" name="lip_color" id="lip_color" placeholder="Select Lip Color" value="{{ (is_array(old()) && !empty(old('lip_color')))? old('lip_color') : $lip_result->lip_color }}" required />
              </div>
              <div class="form-group required">
                <label for="lip_description"><?= ('Description') ?></label>
                <textarea class="form-control" name="lip_description" id="lip_description" rows="3" placeholder="Enter Lip Description" required>{{ (is_array(old()) && !empty(old('lip_description')))? old('lip_description') : $lip_result->lip_description }}</textarea>
              </div>
              <div class="form-group custom-file mb-3">
                <input type="file" class="custom-file-input" id="lip_img" name="filename">
                <label class="custom-file-label" for="customFile"><?= ('Choose file') ?></label>
                <input type="hidden" class="form-control" id="lip_img_hidden" name="filename_hidden" value="{{ (is_array(old()) && !empty(old('lip_img')))? old('lip_img') : $lip_result->lip_img }}">
                <!-- File preview Starts -->
                <img class="file_preview mb-5 {{ (!empty($lip_result->lip_img))? '' : 'd-none' }}" id="img_view" alt="Image Preview" src="{{ (is_array(old()) && !empty(old('lip_img')))? old('lip_img') : $lip_result->lip_img }}" height="70" width="70">
                <button type="button" class="file_preview close float-left {{ (!empty($lip_result->lip_img))? '' : 'd-none' }}" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <!-- File preview Ends -->
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" name="status" id="status" @if(is_array(old()) && old('status')=='on' ) checked @elseif((is_array(old()) && empty(old())) && $lip_result->status)
                  checked
                  @endif>
                  <label class="custom-control-label" for="status"><?= ('Status') ?></label>
                </div>
              </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{ url('admin/lip_list') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> <?= ('Back') ?></a> &nbsp;
              <button type="submit" class="btn btn-primary"><?= ('Submit') ?></button>
            </div>
          </form>
          @else
          <center>
            <h6 class="mt-5 mb-5"> <?= ('Unable to Update Records') ?> </h6>
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
<script src="{{ asset('js/admin/lip_master.js') }}" defer></script>
@stop