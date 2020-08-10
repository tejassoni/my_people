@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Role Edit') ?></h1>
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
            <h3 class="card-title"><?= ('Edit User Roles') ?></h3>
          </div>
          <!-- /.card-header -->
          @if(!empty($role_result))
          <!-- form start -->
          <form role="form" name="role_edit" id="role_edit" method="post" action="{{ url('admin/role_update',[$role_result->role_id]) }}" required>
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            @method('PUT')
            <div class="card-body">
              <div class="form-group required">
                <label for="role_name"><?= ('Name') ?></label>
                <input type="text" class="form-control" name="role_name" id="role_name" placeholder="Enter Role Name" value="{{ (is_array(old()) && !empty(old('role_name')))? old('role_name') : $role_result->role_name }}" required />
              </div>
              <div class="form-group required">
                <label for="role_alias"><?= ('Alias') ?></label>
                <input type="text" class="form-control" name="role_alias" id="role_alias" placeholder="Enter Role Alias" value="{{ (is_array(old()) && !empty(old('role_alias')))? old('role_alias') : $role_result->role_alias }}" maxlength="10" required />
              </div>
              <div class="form-group required">
                <label for="role_description"><?= ('Description') ?></label>
                <textarea class="form-control" name="role_description" id="role_description" rows="3" placeholder="Enter Role Description" required>{{ (is_array(old()) && !empty(old('role_description')))? old('role_description') : $role_result->role_description }}</textarea>
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" name="status" id="status" @if(is_array(old()) && old('status')=='on' ) checked @elseif((is_array(old()) && empty(old())) && $role_result->status)
                  checked
                  @endif>
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
<script src="{{ asset('js/admin/role_master.js') }}" defer></script>
@stop