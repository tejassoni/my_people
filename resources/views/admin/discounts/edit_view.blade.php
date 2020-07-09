@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Discount Edit') ?></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/admin/discount_list" title="Discounts"><?= ('Discounts') ?></a>
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
            <h3 class="card-title"><?= ('Edit Discounts') ?></h3>
          </div>
          <!-- /.card-header -->
          @if(!empty($discount_result))
          <?php
          // dd($discount_result->discount_type);
          ?>
          <!-- form start -->
          <form role="form" name="discount_edit" id="discount_edit" method="post" action="{{ url('admin/discount_update',[$discount_result->discount_id]) }}">
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            @method('PUT')
            <div class="card-body">
              <div class="card-body">
                <div class="form-group required">
                  <label for="discount_name"><?= ('Name') ?></label>
                  <input type="text" class="form-control" name="discount_name" id="discount_name" placeholder="Enter Discount Name" value="{{ (is_array(old()) && !empty(old('discount_name')))? old('discount_name') : $discount_result->discount_name }}" required />
                </div>

                <div class="form-group required">
                  <label for="discount_description"><?= ('Description') ?></label>
                  <textarea class="form-control" name="discount_description" id="discount_description" rows="3" placeholder="Enter Discount Description" required>{{ (is_array(old()) && !empty(old('discount_description')))? old('discount_description') : $discount_result->discount_description }}</textarea>
                </div>
                <div class="form-group w-120 required">
                  <label><?= ('Select Discount Type') ?></label>
                  <select class="form-control" name="discount_type_select" id="discount_type_select" required>
                    <option value="" disabled><?= ('Select Discount Type') ?></option>
                    <option value="none" {{ (is_array(old()) && old('discount_type_select') == 'none') ? 'selected' : (isset($discount_result->discount_type) && !empty($discount_result->discount_type) && $discount_result->discount_type == "none")? "selected" : "" }}><?= ('None') ?></option>
                    <option value="fixed" {{ (is_array(old()) && old('discount_type_select') == 'fixed') ? 'selected' :(isset($discount_result->discount_type) && !empty($discount_result->discount_type) && $discount_result->discount_type == "fixed")? "selected" : "" }}><?= ('Fixed / Flat') ?></option>
                    <option value="percentage" {{ (is_array(old()) && old('discount_type_select') == 'percentage') ? 'selected' :(isset($discount_result->discount_type) && !empty($discount_result->discount_type) && $discount_result->discount_type == "percentage")? "selected" : "" }}><?= ('Percentage') ?></option>
                  </select>
                </div>

                <div class="form-group has-error">
                  <label for="discount_amount"><?= ('Discount Amount') ?></label>
                  <input type="number" class="form-control" min="0" name="discount_amount" id="discount_amount" placeholder="Enter Discount Amount" value="{{ (is_array(old()) && !empty(old('discount_amount')))? old('discount_amount') : $discount_result->amount }}" {{ (is_array(old()) && old('discount_type_select') == 'none') ? 'disabled' : (isset($discount_result->discount_type) && !empty($discount_result->discount_type) && $discount_result->discount_type == "none")? "disabled" : "" }} />
                </div>

                <div class="form-group clearfix">
                  <div class="icheck-primary d-inline">
                    <input type="checkbox" name="discount_validity_chkbx" class="discount_validity_chkbx" id="discount_validity_chkbx" value="{{ (is_array(old()) && old('discount_validity_chkbx') == 1) ? 1 : $discount_result->is_discount_validity }}" {{ (is_array(old()) && old('discount_validity_chkbx') == 1) ? 'checked' : (isset($discount_result->is_discount_validity) && $discount_result->is_discount_validity == 1)? "checked" : "" }}>
                    <label for="discount_validity_chkbx"> Date Range Available </label>
                  </div>
                  <input type="text" class="form-control" name="discount_validity" id="discount_validity" placeholder="Enter Discount Validity" value="{{ (is_array(old()) && !empty(old('discount_validity')))? old('discount_validity') : (isset($discount_result->startDate, $discount_result->endDate) && !empty($discount_result->startDate) || !empty($discount_result->endDate)) ? $discount_result->startDate . ' - ' . $discount_result->endDate : date('d/m/Y') . ' - ' . date('d/m/Y') }}" {{ (is_array(old()) && !empty(old()) && old('discount_validity_chkbx') == 0) ? 'disabled' : (isset($discount_result->is_discount_validity) && $discount_result->is_discount_validity == 1)? "" : "disabled" }} />
                </div>

                <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                    <input type="checkbox" class="custom-control-input" name="status" id="status" @if(is_array(old()) && old('status')=='on' ) checked @elseif((is_array(old()) && empty(old())) && $discount_result->status)
                    checked
                    @endif>
                    <label class="custom-control-label" for="status">Status</label>
                  </div>
                </div>
                </>
              </div>

              <!-- /.card-body -->
              <div class="card-footer">
                <a href="{{ url('admin/discount_list') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> <?= ('Back') ?></a> &nbsp;
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