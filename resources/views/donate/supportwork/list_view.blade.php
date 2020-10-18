@extends('adminlte::page')

@section('title', 'AdminLTE')
@include('vendor.adminlte.partials.header_response_messages')
@section('content_header')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <!-- <h1 class="m-0 text-dark"><a href='{{ url("/customer/missing_person_add") }}' class="btn-success btn-sm" title="Add New Button"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?= ('Add New') ?></a></h1> -->
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/supportwork/donate" title="Support Our Work"><?= ('Support Our Work') ?></a>
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
      </div>
      <!-- First Row Ends -->
      <!-- Second Row Starts -->
      <div class="row">
      </div>
      <!-- Second Row Ends -->

    </div>
  </div>
</section>
<!-- Search Section Ends -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><?= ('Donator Information') ?></h3>

          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" name="discount_add" id="discount_add" method="post" action="{{ url('admin/discount_insert') }}">
            <!-- csrf security starts -->
            @csrf
            <!-- csrf security ends -->
            <div class="card-body">
              <div class="form-group required">
                <label for="donate_name"><?= ('Name') ?></label>
                <input type="text" class="form-control" name="donate_name" id="donate_name" placeholder="Enter Donator Name" value="{{ old('donate_name') }}" required />
              </div>


              <div class="form-group">
                <label for="donate_email"><?= ('Email') ?></label>
                <input type="email" class="form-control" name="donate_email" id="donate_email" placeholder="Enter Donator Email" value="{{ old('donate_email') }}" />
              </div>

              <div class="form-group">
                <label for="donate_mobile"><?= ('Mobile') ?></label>
                <input type="text" class="form-control" name="donate_mobile" id="donate_mobile" placeholder="Enter Donator Mobile" value="{{ old('donate_mobile') }}" />
              </div>

              <div class="form-group">
                <label for="donate_amount"><?= ('Donate Amount') ?></label>
                <input type="number" class="form-control" name="donate_amount" id="donate_amount" placeholder="Enter Donator Amount" value="{{ old('donate_amount') }}" required />
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <a href="{{ url('supportwork/donate') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> <?= ('Back') ?></a> &nbsp;
                <button type="submit" class="btn btn-primary"><?= ('Donate') ?></button>
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