@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Plan Edit') ?></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/admin/plan_list" title="Plans"><?= ('Plans') ?></a>
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
            <h3 class="card-title"><?= ('Edit Plans') ?></h3>
          </div>
          <!-- /.card-header -->
          @if(!empty($plan_result))
          <!-- form start -->
          <form role="form" name="plan_edit" id="plan_edit" method="post" action="{{ url('admin/plan_update',[$plan_result->plan_id]) }}" required>
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            @method('PUT')
            <div class="card-body">
              <div class="form-group">
                <label for="plan_name"><?= ('Name') ?></label>
                <input type="text" class="form-control" name="plan_name" id="plan_name" placeholder="Enter Plan Name" value="{{ (is_array(old()) && !empty(old('plan_name')))? old('plan_name') : $plan_result->plan_name }}" required>
              </div>
              <div class="form-group">
                <label for="plan_alias"><?= ('Alias') ?></label>
                <input type="text" class="form-control" name="plan_alias" id="plan_alias" placeholder="Enter Plan Alias" value="{{ (is_array(old()) && !empty(old('plan_alias')))? old('plan_alias') : $plan_result->plan_alias }}" maxlength="10" required>
              </div>
              <div class="form-group">
                <label for="plan_description"><?= ('Description') ?></label>
                <textarea class="form-control" name="plan_description" id="plan_description" rows="3" placeholder="Enter Plan Description" required>{{ (is_array(old()) && !empty(old('plan_description')))? old('plan_description') : $plan_result->plan_description }}</textarea>
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" name="status" id="status" @if(is_array(old()) && old('status')=='on' ) checked @elseif((is_array(old()) && empty(old())) && $plan_result->status)
                  checked
                  @endif>
                  <label class="custom-control-label" for="status"><?= ('Status') ?></label>
                </div>
              </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{ url('admin/plan_list') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> <?= ('Back') ?></a> &nbsp;
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