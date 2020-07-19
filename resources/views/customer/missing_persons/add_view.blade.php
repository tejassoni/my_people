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
                <label for="first_name"><?= ('First Name') ?></label>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name" value="{{ old('first_name') }}" required />
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
                <label for="birth_date"> Birth Date </label>
                <input type="text" class="form-control" name="birth_date" id="birth_date" placeholder="Enter Birth Date" value="{{ old('birth_date') }}" />
              </div>

              <div class="form-group required">
                <label for="age"><?= ('Age') ?></label>
                <input type="number" class="form-control" name="age" id="age" placeholder="Enter Age" value="{{ old('age') }}" required min="0" />
              </div>

              <div class="form-group required">
                <label for="address"><?= ('Address') ?></label>
                <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter Address" required>{{ old('address') }}</textarea>
              </div>

              <div class="form-group w-120 required">
                <label><?= ('Select Country') ?></label>
                <select class="form-control" name="country_select" id="country_select" required>
                  <option value="" disabled selected><?= ('Select Country') ?></option>
                  <option value="none"><?= ('None') ?></option>
                </select>
              </div>

              <div class="form-group w-120 required">
                <label><?= ('Select State') ?></label>
                <select class="form-control" name="state_select" id="state_select" required>
                  <option value="" disabled selected><?= ('Select State') ?></option>
                  <option value="none"><?= ('None') ?></option>
                </select>
              </div>

              <div class="form-group w-120 required">
                <label><?= ('Select City') ?></label>
                <select class="form-control" name="city_select" id="city_select" required>
                  <option value="" disabled selected><?= ('Select City') ?></option>
                  <option value="none"><?= ('None') ?></option>
                </select>
              </div>

              <div class="form-group required">
                <label for="pincode"><?= ('Pincode') ?></label>
                <input type="number" class="form-control" name="pincode" id="pincode" placeholder="Enter Pincode" value="{{ old('pincode') }}" required />
              </div>

              <div class="form-group required">
                <label for="missing_date"> Missing Date </label>
                <input type="text" class="form-control" name="missing_date" id="missing_date" placeholder="Enter Missing Date" value="{{ old('missing_date') }}" />
              </div>

              <div class="form-group w-120">
                <label><?= ('Select Hair') ?></label>
                <select class="form-control" name="hair_select" id="hair_select" required>
                  <option value="" disabled selected><?= ('Select Hair') ?></option>
                  <option value="none"><?= ('None') ?></option>
                </select>
              </div>

              <div class="form-group w-120">
                <label><?= ('Select Eye') ?></label>
                <select class="form-control" name="eye_select" id="eye_select" required>
                  <option value="" disabled selected><?= ('Select Eye') ?></option>
                  <option value="none"><?= ('None') ?></option>
                </select>
              </div>

              <div class="form-group w-120">
                <label><?= ('Select Eye Brow') ?></label>
                <select class="form-control" name="eyebrow_select" id="eyebrow_select" required>
                  <option value="" disabled selected><?= ('Select Eye Brow') ?></option>
                  <option value="none"><?= ('None') ?></option>
                </select>
              </div>

              <div class="form-group w-120">
                <label><?= ('Select Lip') ?></label>
                <select class="form-control" name="lip_select" id="lip_select" required>
                  <option value="" disabled selected><?= ('Select Lip') ?></option>
                  <option value="none"><?= ('None') ?></option>
                </select>
              </div>
              <div class="form-group w-120">
                <label><?= ('Select Face / Jaw') ?></label>
                <select class="form-control" name="face_jaw_select" id="face_jaw_select" required>
                  <option value="" disabled selected><?= ('Select Face Jaw') ?></option>
                  <option value="none"><?= ('None') ?></option>
                </select>
              </div>
              <div class="form-group w-120">
                <label><?= ('Select Skin') ?></label>
                <select class="form-control" name="skin_select" id="skin_select" required>
                  <option value="" disabled selected><?= ('Select Skin') ?></option>
                  <option value="none"><?= ('None') ?></option>
                </select>
              </div>
              <div class="form-group w-120">
                <label><?= ('Select Ear') ?></label>
                <select class="form-control" name="ear_select" id="ear_select" required>
                  <option value="" disabled selected><?= ('Select Ear') ?></option>
                  <option value="none"><?= ('None') ?></option>
                </select>
              </div>

              <div class="form-group w-120">
                <label><?= ('Select Nose') ?></label>
                <select class="form-control" name="nose_select" id="nose_select" required>
                  <option value="" disabled selected><?= ('Select Nose') ?></option>
                  <option value="none"><?= ('None') ?></option>
                </select>
              </div>


              <div class="form-group required">
                <label for="remark"><?= ('Remark') ?></label>
                <textarea class="form-control" name="remark" id="remark" rows="3" placeholder="Enter Remark" required>{{ old('remark') }}</textarea>
              </div>

              <div class="form-group required">
                <label for="remark"><?= ('Cloth Description') ?></label>
                <textarea class="form-control" name="cloth_description" id="cloth_description" rows="3" placeholder="Enter Cloth Description" required>{{ old('cloth_description') }}</textarea>
              </div>

              <div class="form-group has-error">
                <label for="reward_amount"><?= ('Reward Amount') ?></label>
                <input type="number" class="form-control" min="0" name="reward_amount" id="reward_amount" placeholder="Enter Reward Amount" value="{{ (is_array(old()) && !empty(old('reward_amount')))? old('reward_amount') : 0 }}" />
              </div>

              <div class="form-group w-120">
                <label><?= ('Select Currency Type For Reward') ?></label>
                <select class="form-control" name="currency_select" id="currency_select" required>
                  <option value="" disabled selected><?= ('Select Currency') ?></option>
                  <option value="none"><?= ('None') ?></option>
                </select>
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