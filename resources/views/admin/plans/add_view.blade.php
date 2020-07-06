@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Plan Add') ?></h1>
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
            <h3 class="card-title"><?= ('Add Plans') ?></h3>

          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" name="plan_add" id="plan_add" method="post" action="{{ url('admin/plan_insert') }}">
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            <div class="card-body">
              <div class="form-group">
                <label for="plan_name"><?= ('Name') ?></label>
                <input type="text" class="form-control" name="plan_name" id="plan_name" placeholder="Enter Plan Name" value="{{ old('plan_name') }}" required />
              </div>
              <div class="form-group">
                <label for="plan_alias"><?= ('Alias') ?></label>
                <input type="text" class="form-control" name="plan_alias" id="plan_alias" placeholder="Enter Plan Alias" value="{{ old('plan_alias') }}" maxlength="10" required />
              </div>
              <div class="form-group">
                <label for="plan_description"><?= ('Description') ?></label>
                <textarea class="form-control" name="plan_description" id="plan_description" rows="3" placeholder="Enter Plan Description" required>{{ old('plan_description') }}</textarea>
              </div>

              <div class="form-group">
                <label for="plan_amount"><?= ('Amount') ?></label>
                <input type="number" class="form-control" min="0" name="plan_amount" id="plan_amount" placeholder="Enter Plan Amount" value="{{ (is_array(old()) && !empty(old('plan_amount')))? old('plan_amount') : 0 }}" required />
              </div>

              <div class="form-group w-120">
                <label><?= ('Select Discount') ?></label>
                <select class="form-control" name="discount_id_select" id="discount_id_select">
                  @if(isset($discount_result) && is_array($discount_result) && !empty($discount_result))
                  <option value="" disabled selected><?= ('Select Discount') ?></option>
                  @foreach ($discount_result as $discount_key => $discount_val)
                  <option value="{{ $discount_val['discount_id'] }}" {{ (is_array(old()) && !empty(old('discount_id_select')) && old('discount_id_select') == $discount_val['discount_id'])? 'selected' : '' }}>{{ ucwords($discount_val['discount_name']) .' - '.ucwords($discount_val['discount_type']).' - '.$discount_val['amount'] }}</option>
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
              <a href="{{ url('admin/plan_list') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> <?= ('Back') ?></a> &nbsp;
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