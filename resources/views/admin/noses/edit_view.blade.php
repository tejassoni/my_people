@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Nose Edit') ?></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/admin/nose_list" title="Noses"><?= ('Noses') ?></a>
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
            <h3 class="card-title"><?= ('Edit Nose') ?></h3>
          </div>
          <!-- /.card-header -->
          @if(!empty($nose_result))
          <!-- form start -->
          <form role="form" name="nose_edit" id="nose_edit" method="post" action="{{ url('admin/nose_update',[$nose_result->nose_id]) }}" enctype="multipart/form-data">
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            @method('PUT')
            <div class="card-body">
              <div class="form-group required">
                <label for="nose_name"><?= ('Name') ?></label>
                <input type="text" class="form-control" name="nose_name" id="nose_name" placeholder="Enter Nose Name" value="{{ (is_array(old()) && !empty(old('nose_name')))? old('nose_name') : $nose_result->nose_name }}" required />
              </div>
              <div class="form-group required">
                <label for="nose_color"><?= ('Color') ?></label>
                <input type="text" class="form-control" name="nose_color" id="nose_color" placeholder="Select Nose Color" value="{{ (is_array(old()) && !empty(old('nose_color')))? old('nose_color') : $nose_result->nose_color }}" required />
              </div>
              <div class="form-group required">
                <label for="nose_description"><?= ('Description') ?></label>
                <textarea class="form-control" name="nose_description" id="nose_description" rows="3" placeholder="Enter Nose Description" required>{{ (is_array(old()) && !empty(old('nose_description')))? old('nose_description') : $nose_result->nose_description }}</textarea>
              </div>
              <div class="form-group custom-file mb-3">
                <input type="file" class="custom-file-input" id="nose_img" name="filename">
                <label class="custom-file-label" for="customFile"><?= ('Choose file') ?></label>
                <input type="hidden" class="form-control" id="nose_img_hidden" name="filename_hidden" value="{{ (is_array(old()) && !empty(old('nose_img')))? old('nose_img') : $nose_result->nose_img }}">
                <!-- File preview Starts -->
                <img class="file_preview mb-5 {{ (!empty($nose_result->nose_img))? '' : 'd-none' }}" id="img_view" src="{{ (is_array(old()) && !empty(old('nose_img')))? old('nose_img') : $nose_result->nose_img }}" height="70" width="70">
                <button type="button" class="file_preview close float-left {{ (!empty($nose_result->nose_img))? '' : 'd-none' }}" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <!-- File preview Ends -->
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" name="status" id="status" @if(is_array(old()) && old('status')=='on' ) checked @elseif((is_array(old()) && empty(old())) && $nose_result->status)
                  checked
                  @endif>
                  <label class="custom-control-label" for="status"><?= ('Status') ?></label>
                </div>
              </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{ url('admin/nose_list') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> <?= ('Back') ?></a> &nbsp;
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