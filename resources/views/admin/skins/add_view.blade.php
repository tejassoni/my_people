@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Skin Add') ?></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/admin/skin_list" title="Skins"><?= ('Skins') ?></a>
        </li>
        <li class="breadcrumb-item active"><?= ('Add') ?></li>
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
            <h3 class="card-title"><?= ('Add Skin') ?></h3>

          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form ear="form" name="skin_add" id="skin_add" method="post" action="{{ url('admin/skin_insert') }}" enctype="multipart/form-data">
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            <div class="card-body">
              <div class="form-group required">
                <label for="skin_name"><?= ('Name') ?></label>
                <input type="text" class="form-control" name="skin_name" id="skin_name" placeholder="Enter Skin Name" value="{{ old('skin_name') }}" required />
              </div>
              <div class="form-group required">
                <label for="skin_color"><?= ('Color') ?></label>
                <input type="text" class="form-control" name="skin_color" id="skin_color" placeholder="Select Skin Color" value="{{ old('skin_color') }}" required />
              </div>

              <div class="form-group required">
                <label for="skin_description"><?= ('Description') ?></label>
                <textarea class="form-control" name="skin_description" id="skin_description" rows="3" placeholder="Enter Skin Description" required>{{ old('skin_description') }}</textarea>
              </div>


              <div class="form-group custom-file mb-3">
                <input type="file" class="custom-file-input" id="skin_img" name="filename">
                <label class="custom-file-label" for="customFile"><?= ('Choose file') ?></label>
                <!-- File preview Starts -->
                <img class="file_preview mb-5 d-none" id="img_view" src="#" height="70" width="70">
                <button type="button" class="file_preview close float-left d-none" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <!-- File preview Ends -->
              </div>


              <div class="form-group">
                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" name="status" id="status" @if(is_array(old()) && old('status')=='on' ) checked @endif>
                  <label class="custom-control-label" for="status"><?= ('Status') ?></label>
                </div>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <a href="{{ url('admin/skin_list') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> <?= ('Back') ?></a> &nbsp;
              <button type="submit" class="btn btn-primary"><?= ('Submit') ?></button>
            </div>
          </form>
        </div>
        <!-- /.card -->



      </div>
      <!--/.col (left) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@stop