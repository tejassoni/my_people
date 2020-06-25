@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Subscription Edit') ?></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/admin/subscription_list" title="Subscriptions"><?= ('Subscriptions') ?></a>
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
            <h3 class="card-title"><?= ('Edit Subscriptions') ?></h3>
          </div>
          <!-- /.card-header -->
          @if(!empty($subscription_result))
          <!-- form start -->
          <form role="form" name="subscription_edit" id="subscription_edit" method="post" action="{{ url('admin/subscription_update',[$subscription_result->sub_id]) }}" required>
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            @method('PUT')
            <div class="card-body">
              <div class="form-group">
                <label for="sub_name"><?= ('Name') ?></label>
                <input type="text" class="form-control" name="sub_name" id="sub_name" placeholder="Enter Subscription Name" value="{{ (is_array(old()) && !empty(old('sub_name')))? old('sub_name') : $subscription_result->sub_name }}" required>
              </div>
              <div class="form-group">
                <label for="sub_alias"><?= ('Alias') ?></label>
                <input type="text" class="form-control" name="sub_alias" id="sub_alias" placeholder="Enter Subscription Alias" value="{{ (is_array(old()) && !empty(old('sub_alias')))? old('sub_alias') : $subscription_result->sub_alias }}" maxlength="10" required>
              </div>
              <div class="form-group">
                <label for="sub_description"><?= ('Description') ?></label>
                <textarea class="form-control" name="sub_description" id="sub_description" rows="3" placeholder="Enter Subscription Description" required>{{ (is_array(old()) && !empty(old('sub_description')))? old('sub_description') : $subscription_result->sub_description }}</textarea>
              </div>
              <div class="form-group">
                <label><?= ('Select Plan') ?></label>
                <select class="form-control" name="plan_id_select" id="plan_id_select">
                  @if(isset($plan_result) && is_array($plan_result) && !empty($plan_result))
                  <option value="" disabled><?= ('Select Plan') ?></option>
                  @foreach ($plan_result as $plan_key => $plan_val)
                  <option value="{{ $plan_val['plan_id'] }}" {{ (is_array(old()) && !empty(old('plan_id_select')) && old('plan_id_select') == $plan_val['plan_id'])? 'selected' : (isset($subscription_result->plan_id) && !empty($subscription_result->plan_id) && $subscription_result->plan_id == $plan_val['plan_id']) ? 'selected' : '' }}>{{ ucwords($plan_val['plan_name']) }}</option>
                  @endforeach
                  @else
                  <option value="" disabled selected><?= ('No Records found..') ?></>
                    @endif
                </select>
              </div>
              <div class="form-group">
                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" name="status" id="status" @if(is_array(old()) && old('status')=='on' ) checked @elseif((is_array(old()) && empty(old())) && $subscription_result->status)
                  checked
                  @endif>
                  <label class="custom-control-label" for="status"><?= ('Status') ?></label>
                </div>
              </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer">
              <a href="{{ url('admin/subscription_list') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> <?= ('Back') ?></a> &nbsp;
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