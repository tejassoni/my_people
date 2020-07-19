@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Missing Person Add') ?></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/customer/missing_person_list" title="Missing Persons"><?= ('Missing Persons') ?></a>
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
            <h3 class="card-title"><?= ('Add Missing Persons') ?></h3>

          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" name="missing_person_add" id="missing_person_add" method="post" action="{{ url('customer/missing_person_insert') }}">
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            <div class="card-body">
              <div class="form-group required">
                <label for="discount_name"><?= ('Name') ?></label>
                <input type="text" class="form-control" name="discount_name" id="discount_name" placeholder="Enter Missing Person Name" value="{{ old('discount_name') }}" required />
              </div>

              <div class="form-group required">
                <label for="discount_description"><?= ('Description') ?></label>
                <textarea class="form-control" name="discount_description" id="discount_description" rows="3" placeholder="Enter Missing Person Description" required>{{ old('discount_description') }}</textarea>
              </div>

              <div class="form-group w-120 required">
                <label><?= ('Select Missing Person Type') ?></label>
                <select class="form-control" name="discount_type_select" id="discount_type_select" required>
                  <option value="" disabled selected><?= ('Select Missing Person Type') ?></option>
                  <option value="none"><?= ('None') ?></option>
                  <option value="fixed"><?= ('Fixed / Flat') ?></option>
                  <option value="percentage"><?= ('Percentage') ?></option>
                </select>
              </div>

              <div class="form-group has-error">
                <label for="discount_amount"><?= ('Missing Person Amount') ?></label>
                <input type="number" class="form-control" min="0" name="discount_amount" id="discount_amount" placeholder="Enter Missing Person Amount" value="{{ (is_array(old()) && !empty(old('discount_amount')))? old('discount_amount') : 0 }}" disabled />
              </div>

              <div class="form-group clearfix">
                <div class="icheck-primary d-inline">
                  <input type="checkbox" name="discount_validity_chkbx" class="discount_validity_chkbx" id="discount_validity_chkbx" value="0">
                  <label for="discount_validity_chkbx"> Date Range Available </label>
                </div>
                <input type="text" class="form-control" name="discount_validity" id="discount_validity" placeholder="Enter Missing Person Validity" value="{{ old('discount_validity') }}" disabled />
              </div>

              <div class=" form-group">
                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" name="status" id="status" @if(is_array(old()) && old('status')=='on' ) checked @endif>
                  <label class="custom-control-label" for="status"><?= ('Status') ?></label>
                </div>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <a href="{{ url('customer/missing_person_list') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> <?= ('Back') ?></a> &nbsp;
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