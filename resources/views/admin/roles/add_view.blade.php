@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Role Add') ?></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/admin/role_list" title="User Roles"><?= ('Roles') ?></a>
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
            <h3 class="card-title"><?= ('Add User Roles') ?></h3>

          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" name="role_add" id="role_add" method="post" action="{{ url('admin/role_insert') }}">
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            <div class="card-body">
              <div class="form-group required">
                <label for="role_name"><?= ('Name') ?></label>
                <input type="text" class="form-control" name="role_name" id="role_name" placeholder="Enter Role Name" value="{{ old('role_name') }}" required />
              </div>
              <div class="form-group required">
                <label for="role_alias"><?= ('Alias') ?></label>
                <input type="text" class="form-control" name="role_alias" id="role_alias" placeholder="Enter Role Alias" value="{{ old('role_alias') }}" maxlength="10" required />
              </div>
              <div class="form-group required">
                <label for="role_description"><?= ('Description') ?></label>
                <textarea class="form-control" name="role_description" id="role_description" rows="3" placeholder="Enter Role Description" required>{{ old('role_description') }}</textarea>
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
<script src="{{ asset('js/admin/role_master.js') }}" defer></script>
@stop