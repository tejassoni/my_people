@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Eye Edit') ?></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/admin/eye_list" title="Eyes"><?= ('Eyes') ?></a>
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
            <h3 class="card-title"><?= ('Edit Eye') ?></h3>
          </div>
          <!-- /.card-header -->
          @if(!empty($eye_result))
          <!-- form start -->
          <form role="form" name="eye_edit" id="eye_edit" method="post" action="{{ url('admin/eye_update',[$eye_result->eye_id]) }}" enctype="multipart/form-data">
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            @method('PUT')
            <div class="card-body">
              <div class="form-group">
                <label for="eye_name"><?= ('Name') ?></label>
                <input type="text" class="form-control" name="eye_name" id="eye_name" placeholder="Enter Eye Name" value="{{ (is_array(old()) && !empty(old('eye_name')))? old('eye_name') : $eye_result->eye_name }}">
              </div>
              <div class="form-group">
                <label for="eye_color"><?= ('Color') ?></label>
                <input type="text" class="form-control" name="eye_color" id="eye_color" placeholder="Select Eye Color" value="{{ (is_array(old()) && !empty(old('eye_color')))? old('eye_color') : $eye_result->eye_color }}" />
              </div>
              <div class="form-group">
                <label for="eye_description"><?= ('Description') ?></label>
                <textarea class="form-control" name="eye_description" id="eye_description" rows="3" placeholder="Enter Eye Description" required>{{ (is_array(old()) && !empty(old('eye_description')))? old('eye_description') : $eye_result->eye_description }}</textarea>
              </div>
              <div class="form-group custom-file mb-3">
                <input type="file" class="custom-file-input" id="eye_img" name="filename">
                <label class="custom-file-label" for="customFile"><?= ('Choose file') ?></label>
                <input type="hidden" class="form-control" id="eye_img_hidden" name="filename_hidden" value="{{ (is_array(old()) && !empty(old('eye_img')))? old('eye_img') : $eye_result->eye_img }}">
                <!-- File preview Starts -->
                <img class="file_preview mb-5 {{ (!empty($eye_result->eye_img))? '' : 'd-none' }}" id="img_view" src="{{ (is_array(old()) && !empty(old('eye_img')))? old('eye_img') : $eye_result->eye_img }}" height="70" width="70">
                <button type="button" class="file_preview close float-left {{ (!empty($eye_result->eye_img))? '' : 'd-none' }}" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <!-- File preview Ends -->
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" name="status" id="status" @if(is_array(old()) && old('status')=='on' ) checked @elseif((is_array(old()) && empty(old())) && $eye_result->status)
                  checked
                  @endif>
                  <label class="custom-control-label" for="status"><?= ('Status') ?></label>
                </div>
              </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{ url('admin/eye_list') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> <?= ('Back') ?></a> &nbsp;
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
@stop