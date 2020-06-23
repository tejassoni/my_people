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
          <form role="form" name="user_add" id="user_add" method="post" action="{{ url('admin/user_insert') }}">
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            <div class="card-body">
              <div class="form-group">
                <label for="first_name"><?= ('First Name') ?></label>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter User Name" value="{{ old('first_name') }}" required />
              </div>
              <div class="form-group">
                <label for="middle_name"><?= ('Middle Name') ?></label>
                <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Enter Middle Name" value="{{ old('middle_name') }}" required />
              </div>
              <div class="form-group">
                <label for="last_name"><?= ('Last Name') ?></label>
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name" value="{{ old('last_name') }}" required />
              </div>
              <div class="form-group">
                <label for="user_address"><?= ('Address') ?></label>
                <textarea class="form-control" name="user_address" id="user_address" rows="3" placeholder="Enter User Address" required>{{ old('user_address') }}</textarea>
              </div>
              <div class="form-group">
                <label for="mobile"><?= ('Mobile') ?></label>
                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile" value="{{ old('mobile') }}" required />
              </div>
              <div class="form-group">
                <label for="email"><?= ('Email') ?></label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{ old('email') }}" required />
              </div>
              <div class="form-group">
                <label for="password"><?= ('Password') ?></label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" value="{{ old('password') }}" required />
              </div>

              <div class="form-group w-120">
                <label><?= ('Select Role') ?></label>
                <select class="form-control">
                  @if(is_array($role_result) && !empty($role_result))
                  <option value="" disabled selected><?= ('Select Role') ?></option>
                  @foreach ($role_result as $role_key => $role_val)
                  <option value="{{ $role_val['role_id'] }}">{{ $role_val['role_name'] }}</option>
                  @endforeach
                  @else
                  <option value="" disabled selected><?= ('No Role Records..') ?></>
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