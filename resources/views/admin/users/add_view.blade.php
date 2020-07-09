@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('User Add') ?></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/admin/user_list" title="User Management"><?= ('Users') ?></a>
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
            <h3 class="card-title"><?= ('Add User Management') ?></h3>

          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" name="user_add" id="user_add" method="post" action="{{ url('admin/user_insert') }}" enctype="multipart/form-data">
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            <div class="card-body">

              <div class="form-group custom-file mb-3">
                <input type="file" class="custom-file-input" id="user_img" name="filename">
                <label class="custom-file-label" for="customFile">Choose Profile Image</label>
                <!-- File preview Starts -->
                <img class="file_preview mb-5 d-none" id="img_view" src="#" height="70" width="70">
                <button type="button" class="file_preview close float-left d-none" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <!-- File preview Ends -->
              </div>
              <div class="form-group required">
                <label for="first_name"><?= ('First Name') ?></label>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter User Name" value="{{ old('first_name') }}" required />
              </div>
              <div class="form-group required">
                <label for="middle_name"><?= ('Middle Name') ?></label>
                <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Enter Middle Name" value="{{ old('middle_name') }}" required />
              </div>
              <div class="form-group required">
                <label for="last_name"><?= ('Last Name') ?></label>
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name" value="{{ old('last_name') }}" required />
              </div>
              <div class="form-group required">
                <label for="user_address"><?= ('Address') ?></label>
                <textarea class="form-control" name="user_address" id="user_address" rows="3" placeholder="Enter User Address" required />{{ old('user_address') }}</textarea>
              </div>
              <div class="form-group required">
                <label for="mobile"><?= ('Mobile') ?></label>
                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile" value="{{ old('mobile') }}" required />
              </div>
              <div class="form-group required">
                <label for="email"><?= ('Email') ?></label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{ old('email') }}" required />
              </div>
              <div class="form-group required">
                <label for="password"><?= ('Password') ?></label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" value="{{ old('password') }}" required />
              </div>

              <div class="form-group required">
                <label for="confirm_password"><?= ('Confirm Password') ?></label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter Confirm Password" value="{{ old('confirm_password') }}" required />
              </div>

              <div class="form-group w-120 required">
                <label><?= ('Select Role') ?></label>
                <select class="form-control" name="role_id_select" id="role_id_select" required>
                  @if(isset($role_result) && is_array($role_result) && !empty($role_result))
                  <option value="" disabled selected><?= ('Select Role') ?></option>
                  @foreach ($role_result as $role_key => $role_val)
                  <option value="{{ $role_val['role_id'] }}" {{ (is_array(old()) && !empty(old('role_id_select')) && old('role_id_select') == $role_val['role_id'])? 'selected' : '' }}>{{ ucwords($role_val['role_name']) }}</option>
                  @endforeach
                  @else
                  <option value="" disabled selected><?= ('No Records found..') ?>
                  </option>
                  @endif
                </select>
              </div>

              <div class="form-group w-120 required">
                <label><?= ('Select Subscription') ?></label>
                <select class="form-control" name="subscription_id_select" id="subscription_id_select" required>
                  @if(isset($subscription_result) && is_array($subscription_result) && !empty($subscription_result))
                  <option value="" disabled selected><?= ('Select Subscription') ?></option>
                  @foreach ($subscription_result as $sub_key => $sub_val)
                  <option value="{{ $sub_val['sub_id'] }}" {{ (is_array(old()) && !empty(old('subscription_id_select')) && old('subscription_id_select') == $sub_val['sub_id'])? 'selected' : '' }}>{{ ucwords($sub_val['sub_name']) }}</option>
                  @endforeach
                  @else
                  <option value="" disabled selected><?= ('No Records found..') ?>
                  </option>
                  @endif
                </select>
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
              <a href="{{ url('admin/role_list') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> <?= ('Back') ?></a> &nbsp;
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