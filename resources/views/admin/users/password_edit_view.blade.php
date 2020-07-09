@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Update Password') ?></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
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
            <h3 class="card-title"><?= ('Change Password') ?></h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" name="update_password_edit" id="update_password_edit" method="post" action="{{ url('admin/password_update',[$user_result->id]) }}" enctype="multipart/form-data">
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            @method('PUT')
            <div class="card-body">

              <div class="form-group required">
                <label for="current_password"><?= ('Current Password') ?></label>
                <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Enter Current Password" value="{{ (is_array(old()) && !empty(old('current_password')))? old('current_password') : '' }}" required />
              </div>

              <div class="form-group required">
                <label for="new_password"><?= ('New Password') ?></label>
                <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter New Password" value="{{ (is_array(old()) && !empty(old('new_password')))? old('new_password') : '' }}" required />
              </div>

              <div class="form-group required">
                <label for="confirm_password"><?= ('Confirm Password') ?></label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter Confirm Password" value="{{ (is_array(old()) && !empty(old('confirm_password')))? old('confirm_password') : '' }}" required />
              </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{ url('/home') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> <?= ('Back') ?></a> &nbsp;
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