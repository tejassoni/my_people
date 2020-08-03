@extends('adminlte::page')

@section('title', 'AdminLTE')
@include('vendor.adminlte.partials.header_response_messages')
@section('content_header')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><a href='{{ url("/customer/missing_person_add") }}' class="btn-success btn-sm" title="Add New Button"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?= ('Add New') ?></a></h1>
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
        <li class="breadcrumb-item active"><?= ('List') ?></li>
      </ol>
    </nav>
  </div>
</div>
@stop

@section('content')
<!-- Search Section Starts -->
<section class="content">
  <div class="card">
    <div class="card-body">
      <!-- First Row Starts -->
      <div class="row">
        <div class="col-sm">
          <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
              <input type="checkbox" name="missdate_validity_chkbx" class="missdate_validity_chkbx" id="missdate_validity_chkbx" value="0">
              <label for="missdate_validity_chkbx"> <?= ('Missing Date') ?> </label>
            </div>
            <input type="text" class="form-control" name="missing_date_filter" id="missing_date_filter" placeholder="Enter Dates" value="{{ old('missing_date') }}" disabled />
          </div>
        </div>
        <div class="col-sm">
          <div class="form-group">
            <label for="missing_name"><?= ('Name') ?></label>
            <input type="text" class="form-control" name="missing_name" id="missing_name" placeholder="Enter Missing Name" value="{{ old('missing_name') }}" />
          </div>
        </div>
        <div class="col-sm">
          <div class="form-group">
            <label><?= ('Select Gender') ?></label>
            <select class="form-control" name="gender_select" id="gender_select">
              <option value="" disabled selected><?= ('Select Gender') ?></option>
              <option value="all"><?= ('All') ?></option>
              <option value="male"><?= ('Male') ?></option>
              <option value="female"><?= ('Female') ?></option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="missing_age"><?= ('Age') ?></label>
          <input type="number" class="form-control" name="missing_age" id="missing_age" placeholder="Enter Age" value="{{ old('missing_age') }}" />
        </div>
      </div>
      <!-- First Row Ends -->
      <!-- Second Row Starts -->
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label><?= ('Select Country') ?></label>
            <select class="form-control" name="country_select" id="country_select" required>
              @if(isset($country_list) && !empty($country_list))
              <option value="" disabled selected><?= ('Select Country') ?></option>
              @foreach ($country_list as $country_key => $country_val)
              <option value="{{ $country_val['country_id'] }}" {{ (is_array(old()) && !empty(old('country_select')) && old('country_select') == $country_val['country_id'])? 'selected' : '' }}>{{ ucwords($country_val['name']).' - '.$country_val['sortname'] }}</option>
              @endforeach
              @else
              <option value="" disabled selected><?= ('No Records found..') ?></>
                @endif
            </select>
            <!-- Dynamic Dependend Validation Selected -->
            <input type='hidden' id='select_country_hidden' name='select_country_hidden' value='{{ (is_array(old()) && !empty(old('country_select')))?old('country_select'):'' }}'>
          </div>
        </div>
        <div class="col-sm">
          <div class="form-group">
            <label><?= ('Select State') ?></label>
            <select class="form-control" name="state_select" id="state_select">
              <option value="" disabled selected><?= ('Select State') ?></option>
            </select>
            <!-- Dynamic Dependend Validation Selected -->
            <input type='hidden' id='select_state_hidden' name='select_state_hidden' value='{{ (is_array(old()) && !empty(old('state_select')))?old('state_select'):'' }}'>
          </div>
        </div>

        <div class="col-sm">
          <div class="form-group">
            <label><?= ('Select City') ?></label>
            <select class="form-control" name="city_select" id="city_select">
              <option value="" disabled selected><?= ('Select City') ?></option>
            </select>
            <!-- Dynamic Dependend Validation Selected -->
            <input type='hidden' id='select_city_hidden' name='select_city_hidden' value='{{ (is_array(old()) && !empty(old('city_select')))?old('city_select'):'' }}'>
          </div>
        </div>

        <div class="col-sm">
          <div class="form-group" style="margin-top: 30px;">
            <button type="button" class="btn btn-primary btn_sm btn_person_search"><?= ('Search') ?></button> &nbsp;
            <button type="button" class="btn btn-warning btn_sm btn_clear_search"><?= ('Clear') ?></button>
          </div>
        </div>

      </div>
      <!-- Second Row Ends -->

    </div>
  </div>
</section>
<!-- Search Section Ends -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <!-- <div class="card-header">
              <h3 class="card-title">DataTable with minimal features &amp; hover style</h3>
            </div> -->
        <!-- /.card-header -->
        <div class="card-body">
          <table id="missing_person_list_table" class="display datatables table table-striped table-bordered w-100">
            <thead>
              <tr>
                <th><?= ('Name') ?></th>
                <th><?= ('Image') ?></th>
                <th><?= ('Location') ?></th>
                <th><?= ('Age') ?></th>
                <th><?= ('Missing Date') ?></th>
                <th><?= ('Emergency Contact') ?></th>
                <th><?= ('Missing Status') ?></th>
                <th><?= ('Action') ?></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div> <!-- /.card-body -->
      </div> <!-- /.card -->

    </div> <!-- /.col -->
  </div> <!-- /.col -->
  <!-- Modal -->

  <!-- Missing Person Details Bootstrap Modal Starts -->
  @include('vendor.adminlte.partials.modal_person_information')
  <!-- Missing Person Details Bootstrap Modal Ends -->

  <!-- Customer Request Find Details Bootstrap Modal Starts -->
  @include('vendor.adminlte.partials.modal_send_request_message')
  <!-- Customer Request Find  Bootstrap Modal Ends -->

</section>

@stop