@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@include('vendor.adminlte.partials.header_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><?= ('Missing Person Edit') ?></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/customer/mymissing_person_list" title="Missing Persons"><?= ('Missing Persons') ?></a>
        </li>
        <li class="breadcrumb-item active"><?= ('Edit') ?></li>
      </ol>
    </nav>
  </div>
</div>


@stop

@section('content')

<section class="content">
  <!-- .container-fluid -->
  <div class="container-fluid">
    <!-- .card card-default -->
    <div class="card card-default">
      <!-- /.card-header -->
      <div class="card-header">
        <h3 class="card-title"><?= ('Edit Missing Persons') ?></h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
      </div> <!-- /.card-header -->

      <!-- .card-body -->
      <div class="card-body">
        <!-- form start -->
        <form role="form" name="mymissing_person_edit" id="mymissing_person_edit" method="post" action="{{ url('customer/mymissing_update',[$missing_person_result->missing_id]) }}" enctype="multipart/form-data">
          <!-- csrf security starts -->
          @csrf
          <!-- csrf security ends -->
          @method('PUT')
          <div class="row">
            <!-- .col-md-6 Left Starts -->
            <div class="col-md-6">

              <div class="form-group custom-file mb-3">
                <input type="file" class="custom-file-input" id="missing_person_img" name="filename">
                <label class="custom-file-label" for="customFile">Upload Missing Person Image <span style="color:red;">*</span></label>
                <input type="hidden" class="form-control" id="missing_person_hidden" name="filename_hidden" value="{{ (is_array(old()) && !empty(old('missing_person_img')))? old('missing_person_img') : $missing_person_result->missing_person_img }}">
                <!-- File preview Starts -->
                <img class="file_preview mb-5 {{ (!empty($missing_person_result->missing_person_img))? '' : 'd-none' }}" id="img_view" alt="Image Preview" src="{{ (is_array(old()) && !empty(old('missing_person_img')))? old('missing_person_img') : $missing_person_result->missing_person_img }}" height="70" width="70">
                <button type="button" class="file_preview missing_close close float-left {{ (!empty($missing_person_result->missing_person_img))? '' : 'd-none' }}" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <!-- File preview Ends -->
              </div>

              <div class="form-group required">
                <label for="first_name"><?= ('First Name') ?></label>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name" value="{{ (is_array(old()) && !empty(old('first_name')))? old('first_name') : $missing_person_result->f_name }}" required />
              </div>
              <div class="form-group required">
                <label for="middle_name"><?= ('Middle Name') ?></label>
                <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Enter Middle Name" value="{{ (is_array(old()) && !empty(old('middle_name')))? old('middle_name') : $missing_person_result->m_name }}" required />
              </div>
              <div class="form-group required">
                <label for="last_name"><?= ('Last Name') ?></label>
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name" value="{{ (is_array(old()) && !empty(old('last_name')))? old('last_name') : $missing_person_result->l_name }}" required />
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group clearfix">
                    <div class="form-group required">
                      <label for="birth_date"> Birth Date </label>
                      <input type="text" class="form-control" name="birth_date" id="birth_date" placeholder="Enter Birth Date" value="{{ (is_array(old()) && !empty(old('birth_date')))? old('birth_date') : (isset($missing_person_result->birth_date) && !empty($missing_person_result->birth_date)) ? date('d/m/Y', strtotime($missing_person_result->birth_date)) : date('d/m/Y') }}" />
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label for="birth_date"> Gender </label>
                  <div class="form-group">
                    <!-- Verticle radio button replace class with .form-check -->
                    <div class="form-check-inline">
                      <input class="form-check-input" type="radio" name="gender" value="male" {{ (is_array(old()) && old('gender') == 'male') ? 'checked' : (isset($missing_person_result->gender) && $missing_person_result->gender == 'male')? "checked" : "" }}>
                      <label class="form-check-label">Male</label>
                    </div>
                    <div class="form-check-inline">
                      <input class="form-check-input" type="radio" name="gender" value="female" {{ (is_array(old()) && old('gender') == 'female') ? 'checked' : (isset($missing_person_result->gender) && $missing_person_result->gender == 'female')? "checked" : "" }}>
                      <label class="form-check-label">Female</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group required">
                    <label for="height"><?= ('Height') ?></label>
                    <input type="number" class="form-control" name="height" id="height" placeholder="Enter Height in cm" value="{{ (is_array(old()) && !empty(old('height')))? old('height') : $missing_person_result->height }}" required min="0" />
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group required">
                    <label for="weight"><?= ('Weight') ?></label>
                    <input type="number" class="form-control" name="weight" id="weight" placeholder="Enter Weight in kg" value="{{ (is_array(old()) && !empty(old('weight')))? old('weight') : $missing_person_result->weight }}" required min="0" />
                  </div>
                </div>
              </div>

              <div class="form-group required">
                <label for="age"><?= ('Age') ?></label>
                <input type="number" class="form-control" name="age" id="age" placeholder="Enter Age" value="{{ (is_array(old()) && !empty(old('age')))? old('age') : $missing_person_result->age }}" required min="0" />
              </div>
              <div class="form-group required">
                <label for="address"><?= ('Address') ?></label>
                <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter Address" required>{{ (is_array(old()) && !empty(old('address')))? old('address') : $missing_person_result->address }}</textarea>
              </div>
              <div class="form-group w-120 required">
                <label><?= ('Select Country') ?></label>
                <select class="form-control" name="country_select" id="country_select" required>
                  @if(isset($country_list) && !empty($country_list))
                  <option value="null" disabled selected><?= ('Select Country') ?></option>
                  @foreach ($country_list as $country_key => $country_val)
                  <option value="{{ $country_val['country_id'] }}" {{ (is_array(old()) && !empty(old('country_select')) && old('country_select') == $country_val['country_id'])? 'selected' : (isset($missing_person_result->country_id) && !empty($missing_person_result->country_id) && $missing_person_result->country_id == $country_val['country_id']) ? 'selected' : '' }}>{{ ucwords($country_val['name']).' - '.$country_val['sortname'] }}</option>
                  @endforeach
                  @else
                  <option value="null" disabled selected><?= ('No Records found..') ?></>
                    @endif
                </select>
                <!-- Dynamic Dependend Validation Selected -->
                <input type='hidden' id='select_country_hidden' name='select_country_hidden' value='{{ (is_array(old()) && !empty(old('country_select')))?old('country_select'):'' }}'>
              </div>
              <div class="form-group required">
                <label><?= ('Select State') ?></label>
                <select class="form-control" name="state_select" id="state_select" required>
                  @if(isset($state_list) && !empty($state_list))
                  <option value="null" disabled selected><?= ('Select State') ?></option>
                  @foreach ($state_list as $state_key => $state_val)
                  <option value="{{ $state_val['state_id'] }}" {{ (is_array(old()) && !empty(old('state_select')) && old('state_select') == $state_val['state_id'])? 'selected' : (isset($missing_person_result->state_id) && !empty($missing_person_result->state_id) && $missing_person_result->state_id == $state_val['state_id']) ? 'selected' : '' }}>{{ ucwords($state_val['name']) }}</option>
                  @endforeach
                  @else
                  <option value="null" disabled selected><?= ('No Records found..') ?></>
                    @endif
                </select>
                <!-- Dynamic Dependend Validation Selected -->
                <input type='hidden' id='select_state_hidden' name='select_state_hidden' value='{{ (is_array(old()) && !empty(old('state_select')))?old('state_select'):'' }}'>
              </div>
              <div class="form-group">
                <label><?= ('Select City') ?></label>
                <select class="form-control" name="city_select" id="city_select">
                  @if(isset($city_list) && !empty($city_list))
                  <option value="null" disabled selected><?= ('Select City') ?></option>
                  @foreach ($city_list as $city_key => $city_val)
                  <option value="{{ $city_val['city_id'] }}" {{ (is_array(old()) && !empty(old('state_select')) && old('state_select') == $city_id['city_id'])? 'selected' : (isset($missing_person_result->city_id) && !empty($missing_person_result->city_id) && $missing_person_result->city_id == $city_val['city_id']) ? 'selected' : '' }}>{{ ucwords($city_val['name']) }}</option>
                  @endforeach
                  @else
                  <option value="null" disabled selected><?= ('No Records found..') ?></>
                    @endif
                </select>
                <!-- Dynamic Dependend Validation Selected -->
                <input type='hidden' id='select_city_hidden' name='select_city_hidden' value='{{ (is_array(old()) && !empty(old('city_select')))?old('city_select'):'' }}'>
              </div>
              <div class="form-group required">
                <label for="pincode"><?= ('Pincode') ?></label>
                <input type="number" class="form-control" name="pincode" id="pincode" placeholder="Enter Pincode" value="{{ (is_array(old()) && !empty(old('pincode')))? old('pincode') : $missing_person_result->pincode }}" required />
              </div>
              <div class="form-group required">
                <label for="missing_date"> Missing Date </label>
                <input type="text" class="form-control" name="missing_date" id="missing_date" placeholder="Enter Missing Date" value="{{ (is_array(old()) && !empty(old('missing_date')))? old('missing_date') : (isset($missing_person_result->missed_date) && !empty($missing_person_result->missed_date)) ? date('d/m/Y', strtotime($missing_person_result->missed_date)) : date('d/m/Y') }}" />
              </div>
              <div class="form-group required">
                <label for="remark"><?= ('Cloth Description') ?></label>
                <textarea class="form-control" name="cloth_description" id="cloth_description" rows="3" placeholder="Enter Cloth Description" required>{{ (is_array(old()) && !empty(old('cloth_description')))? old('cloth_description') : $missing_person_result->cloth_description }}</textarea>
              </div>
            </div>
            <!-- /.col-md-6 Left Ends-->

            <!-- .col-md-6 Right Starts -->
            <div class="col-md-6">

              <div class="row">
                <div class="col-sm-9">
                  <div class="form-group clearfix">
                    <label><?= ('Select Hair') ?></label>
                    <select class="form-control" name="hair_select" id="hair_select">
                      @if(isset($hair_list) && !empty($hair_list))
                      <option value="" disabled selected><?= ('Select Hair') ?></option>
                      @foreach ($hair_list as $hair_key => $hair_val)
                      <option value="{{ $hair_val['hair_id'] }}" {{ (is_array(old()) && !empty(old('hair_select')) && old('hair_select') == $hair_val['hair_id'])? 'selected' : (isset($missing_person_result->hair_id) && !empty($missing_person_result->hair_id) && $missing_person_result->hair_id == $hair_val['hair_id']) ? 'selected' : '' }}>{{ ucwords($hair_val['hair_style_name']) }}</option>
                      @endforeach
                      @else
                      <option value="" disabled selected><?= ('No Records found..') ?></>
                        @endif
                    </select>
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="">
                    <img class="file_preview_select mb-5" id="hair_img_view" alt="Image Preview" src="{{ (is_array(old()) && !empty(old('hair_select')))? url('uploads/hairs/thumbnail/thumb_'.App\Models\hair_master::find(old('hair_select'))->hair_img) : (isset($missing_person_result->hair_id) && !empty($missing_person_result->hair_id)) ? url('uploads/hairs/thumbnail/thumb_'.App\Models\hair_master::find($missing_person_result->hair_id)->hair_img) : asset('assets/no-preview.jpg') }}" height="70" width="70">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-9">
                  <div class="form-group clearfix">
                    <label><?= ('Select Eye') ?></label>
                    <select class="form-control" name="eye_select" id="eye_select">
                      @if(isset($eye_list) && !empty($eye_list))
                      <option value="" disabled selected><?= ('Select Eye') ?></option>
                      @foreach ($eye_list as $eye_key => $eye_val)
                      <option value="{{ $eye_val['eye_id'] }}" {{ (is_array(old()) && !empty(old('eye_select')) && old('eye_select') == $eye_val['eye_id'])? 'selected' : (isset($missing_person_result->eye_id) && !empty($missing_person_result->eye_id) && $missing_person_result->eye_id == $eye_val['eye_id']) ? 'selected' : '' }}>{{ ucwords($eye_val['eye_name']) }}</option>
                      @endforeach
                      @else
                      <option value="" disabled selected><?= ('No Records found..') ?></>
                        @endif
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="">
                    <img class="file_preview_select mb-5" id="eye_img_view" alt="Image Preview" src="{{ (is_array(old()) && !empty(old('eye_select')))? url('uploads/eyes/thumbnail/thumb_'.App\Models\eye_master::find(old('eye_select'))->eye_img) : (isset($missing_person_result->eye_id) && !empty($missing_person_result->eye_id)) ? url('uploads/eyes/thumbnail/thumb_'.App\Models\eye_master::find($missing_person_result->eye_id)->eye_img) : asset('assets/no-preview.jpg') }}" height="70" width="70">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-9">
                  <div class="form-group clearfix">
                    <label><?= ('Select Eye Brow') ?></label>
                    <select class="form-control" name="eyebrow_select" id="eyebrow_select">
                      @if(isset($eyebrow_list) && !empty($eyebrow_list))
                      <option value="" disabled selected><?= ('Select EyeBrow') ?></option>
                      @foreach ($eyebrow_list as $eyebrow_key => $eyebrow_val)
                      <option value="{{ $eyebrow_val['eye_brow_id'] }}" {{ (is_array(old()) && !empty(old('eyebrow_select')) && old('eyebrow_select') == $eyebrow_val['eye_brow_id'])? 'selected' : (isset($missing_person_result->eye_brow_id) && !empty($missing_person_result->eye_brow_id) && $missing_person_result->eye_brow_id == $eyebrow_val['eye_brow_id']) ? 'selected' : '' }}>{{ ucwords($eyebrow_val['eye_brow_name']) }}</option>
                      @endforeach
                      @else
                      <option value="" disabled selected><?= ('No Records found..') ?></>
                        @endif
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="">
                    <img class="file_preview_select mb-5" id="eye_brow_view" alt="Image Preview" src="{{ (is_array(old()) && !empty(old('eyebrow_select')))? url('uploads/eyebrows/thumbnail/thumb_'.App\Models\eyebrow_master::find(old('eyebrow_select'))->eye_brow_img) : (isset($missing_person_result->eye_brow_id) && !empty($missing_person_result->eye_brow_id)) ? url('uploads/eyebrows/thumbnail/thumb_'.App\Models\eyebrow_master::find($missing_person_result->eye_brow_id)->eye_brow_img) : asset('assets/no-preview.jpg') }}" height="70" width="70">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-9">
                  <div class="form-group clearfix">
                    <label><?= ('Select Lip') ?></label>
                    <select class="form-control" name="lip_select" id="lip_select">
                      @if(isset($lip_list) && !empty($lip_list))
                      <option value="" disabled selected><?= ('Select Lip') ?></option>
                      @foreach ($lip_list as $lip_key => $lip_val)
                      <option value="{{ $lip_val['lip_id'] }}" {{ (is_array(old()) && !empty(old('lip_select')) && old('lip_select') == $lip_val['lip_id'])? 'selected' : (isset($missing_person_result->lip_id) && !empty($missing_person_result->lip_id) && $missing_person_result->lip_id == $lip_val['lip_id']) ? 'selected' : '' }}>{{ ucwords($lip_val['lip_name']) }}</option>
                      @endforeach
                      @else
                      <option value="" disabled selected><?= ('No Records found..') ?></>
                        @endif
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="">
                    <img class="file_preview_select mb-5" id="lip_view" alt="Image Preview" src="{{ (is_array(old()) && !empty(old('lip_select')))? url('uploads/lips/thumbnail/thumb_'.App\Models\lip_master::find(old('lip_select'))->lip_img) : (isset($missing_person_result->lip_id) && !empty($missing_person_result->lip_id)) ? url('uploads/lips/thumbnail/thumb_'.App\Models\lip_master::find($missing_person_result->lip_id)->lip_img) : asset('assets/no-preview.jpg') }}" height="70" width="70">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-9">
                  <div class="form-group clearfix">
                    <label><?= ('Select Face / Jaw') ?></label>
                    <select class="form-control" name="face_jaw_select" id="face_jaw_select">
                      @if(isset($jaw_list) && !empty($jaw_list))
                      <option value="" disabled selected><?= ('Select Face Jaw') ?></option>
                      @foreach ($jaw_list as $jaw_key => $jaw_val)
                      <option value="{{ $jaw_val['jaw_id'] }}" {{ (is_array(old()) && !empty(old('face_jaw_select')) && old('face_jaw_select') == $jaw_val['jaw_id'])? 'selected' : (isset($missing_person_result->jaw_id) && !empty($missing_person_result->jaw_id) && $missing_person_result->jaw_id == $jaw_val['jaw_id']) ? 'selected' : '' }}>{{ ucwords($jaw_val['jaw_name']) }}</option>
                      @endforeach
                      @else
                      <option value="" disabled selected><?= ('No Records found..') ?></>
                        @endif
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="">
                    <img class="file_preview_select mb-5" id="jaw_view" alt="Image Preview" src="{{ (is_array(old()) && !empty(old('face_jaw_select')))? url('uploads/jaws/thumbnail/thumb_'.App\Models\jaw_master::find(old('face_jaw_select'))->jaw_img) : (isset($missing_person_result->jaw_id) && !empty($missing_person_result->jaw_id)) ? url('uploads/jaws/thumbnail/thumb_'.App\Models\jaw_master::find($missing_person_result->jaw_id)->jaw_img) : asset('assets/no-preview.jpg') }}" height="70" width="70">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-9">
                  <div class="form-group clearfix">
                    <label><?= ('Select Skin') ?></label>
                    <select class="form-control" name="skin_select" id="skin_select">
                      @if(isset($skin_list) && !empty($skin_list))
                      <option value="" disabled selected><?= ('Select Skin') ?></option>
                      @foreach ($skin_list as $skin_key => $skin_val)
                      <option value="{{ $skin_val['skin_id'] }}" {{ (is_array(old()) && !empty(old('skin_select')) && old('skin_select') == $skin_val['skin_id'])? 'selected' : (isset($missing_person_result->skin_id) && !empty($missing_person_result->skin_id) && $missing_person_result->skin_id == $skin_val['skin_id']) ? 'selected' : '' }}>{{ ucwords($skin_val['skin_name']) }}</option>
                      @endforeach
                      @else
                      <option value="" disabled selected><?= ('No Records found..') ?></>
                        @endif
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="">
                    <img class="file_preview_select mb-5" id="skin_view" alt="Image Preview" src="{{ (is_array(old()) && !empty(old('skin_select')))? url('uploads/skins/thumbnail/thumb_'.App\Models\skin_master::find(old('skin_select'))->skin_img) : (isset($missing_person_result->skin_id) && !empty($missing_person_result->skin_id)) ? url('uploads/skins/thumbnail/thumb_'.App\Models\skin_master::find($missing_person_result->skin_id)->skin_img) : asset('assets/no-preview.jpg') }}" height="70" width="70">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-9">
                  <div class="form-group clearfix">
                    <label><?= ('Select Ear') ?></label>
                    <select class="form-control" name="ear_select" id="ear_select">
                      @if(isset($ear_list) && !empty($ear_list))
                      <option value="" disabled selected><?= ('Select Ear') ?></option>
                      @foreach ($ear_list as $ear_key => $ear_val)
                      <option value="{{ $ear_val['ear_id'] }}" {{ (is_array(old()) && !empty(old('ear_select')) && old('ear_select') == $ear_val['ear_id'])? 'selected' : (isset($missing_person_result->ear_id) && !empty($missing_person_result->ear_id) && $missing_person_result->ear_id == $ear_val['ear_id']) ? 'selected' : '' }}>{{ ucwords($ear_val['ear_name']) }}</option>
                      @endforeach
                      @else
                      <option value="" disabled selected><?= ('No Records found..') ?></>
                        @endif
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="">
                    <img class="file_preview_select mb-5" id="ear_view" alt="Image Preview" src="{{ (is_array(old()) && !empty(old('eyebrow_select')))? url('uploads/ears/thumbnail/thumb_'.App\Models\ear_master::find(old('ear_select'))->ear_img) : (isset($missing_person_result->ear_id) && !empty($missing_person_result->ear_id)) ? url('uploads/ears/thumbnail/thumb_'.App\Models\ear_master::find($missing_person_result->ear_id)->ear_img) : asset('assets/no-preview.jpg') }}" height="70" width="70">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-9">
                  <div class="form-group clearfix">
                    <label><?= ('Select Nose') ?></label>
                    <select class="form-control" name="nose_select" id="nose_select">
                      @if(isset($nose_list) && !empty($nose_list))
                      <option value="" disabled selected><?= ('Select Nose') ?></option>
                      @foreach ($nose_list as $nose_key => $nose_val)
                      <option value="{{ $nose_val['nose_id'] }}" {{ (is_array(old()) && !empty(old('nose_select')) && old('nose_select') == $nose_val['nose_id'])? 'selected' : (isset($missing_person_result->nose_id) && !empty($missing_person_result->nose_id) && $missing_person_result->nose_id == $nose_val['nose_id']) ? 'selected' : '' }}>{{ ucwords($nose_val['nose_name']) }}</option>
                      @endforeach
                      @else
                      <option value="" disabled selected><?= ('No Records found..') ?></>
                        @endif
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="">
                    <img class="file_preview_select mb-5" id="nose_view" alt="Image Preview" src="{{ (is_array(old()) && !empty(old('nose_select')))? url('uploads/noses/thumbnail/thumb_'.App\Models\nose_master::find(old('nose_select'))->nose_img) : (isset($missing_person_result->nose_id) && !empty($missing_person_result->nose_id)) ? url('uploads/noses/thumbnail/thumb_'.App\Models\nose_master::find($missing_person_result->nose_id)->nose_img) : asset('assets/no-preview.jpg') }}" height="70" width="70">
                  </div>
                </div>
              </div>
              <div class="form-group required">
                <label for="remark"><?= ('Remark') ?></label>
                <textarea class="form-control" name="remark" id="remark" rows="3" placeholder="Enter Remark" required>{{ (is_array(old()) && !empty(old('remark')))? old('remark') : $missing_person_result->remark }}</textarea>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group clearfix">
                    <label for="reward_amount"><?= ('Reward Amount') ?></label>
                    <input type="number" class="form-control" min="0" name="reward_amount" id="reward_amount" placeholder="Enter Reward Amount" value="{{ (is_array(old()) && !empty(old('reward_amount')))? old('reward_amount') : $missing_person_result->amount }}" />
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group w-120 clearfix">
                    <label><?= ('Currency Type For Reward') ?></label>
                    <select class="form-control" name="currency_select" id="currency_select">
                      @if(isset($currency_list) && !empty($currency_list))
                      <option value="" disabled selected><?= ('Select Currency') ?></option>
                      @foreach ($currency_list as $currency_key => $currency_val)
                      <option value="{{ $currency_val['currency_id'] }}" {{ (is_array(old()) && !empty(old('currency_select')) && old('currency_select') == $currency_val['currency_id'])? 'selected' : (isset($missing_person_result->currency_id) && !empty($missing_person_result->currency_id) && $missing_person_result->currency_id == $currency_val['currency_id']) ? 'selected' : '' }}>{{ ucwords($currency_val['code']).' - '.$currency_val['symbol'] }}</option>
                      @endforeach
                      @else
                      <option value="" disabled selected><?= ('No Records found..') ?></>
                        @endif
                    </select>
                  </div>
                </div>
              </div>


            </div>
            <!-- /.col-md-6 Right Ends-->

            <div class="row">
              <div class="col-md-12">
                <a href="{{ url('customer/missing_person_list') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> <?= ('Back') ?></a> &nbsp;
                <button type="submit" class="btn btn-primary"><?= ('Submit') ?></button>
              </div>
            </div>

          </div> <!-- /.row -->
        </form>
        <!-- form end -->
      </div> <!-- /.card-body -->
      <!-- /.row -->
    </div><!-- /.card card-default -->
  </div><!-- /.container-fluid -->
  <div class="row mt-30">
  </div>
</section>
<script src="{{ asset('js/customer/my_missing_people.js') }}" defer></script>
@stop