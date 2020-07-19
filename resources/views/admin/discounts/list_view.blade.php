@extends('adminlte::page')

@section('title', 'AdminLTE')
@include('vendor.adminlte.partials.header_response_messages')
@section('content_header')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <h1 class="m-0 text-dark"><a href='{{ url("/admin/discount_add") }}' class="btn-success btn-sm" title="Add New Button"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?= ('Add New') ?></a></h1>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb float-right">
        <li class="breadcrumb-item">
          <a href="/home" title="MyPeople Dashboard"><?= ('Dashboard') ?></a>
        </li>
        <li class="breadcrumb-item">
          <a href="/admin/discount_list" title="User Discounts"><?= ('Discounts') ?></a>
        </li>
        <li class="breadcrumb-item active"><?= ('List') ?></li>
      </ol>
    </nav>
  </div>
</div>
@stop

@section('content')
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <!-- <div class="card-header">
              <h3 class="card-title">DataTable with minimal features &amp; hover style</h3>
            </div> -->
        <!-- /.card-header -->
        <div class="card-body">
          <table id="discount_list_table" class="display datatables table table-striped table-bordered w-100">
            <thead>
              <tr>
                <!-- Enable If First Column is Checkbox  -->
                <th>
                  <input type="checkbox" name="select_all_chkbox" class="select_all_chkbox" value="0" id="select_all_chkbox">
                </th>
                <th><?= ('Name') ?></th>
                <th><?= ('Type') ?></th>
                <th><?= ('Amount') ?></th>
                <th><?= ('StartDate') ?></th>
                <th><?= ('EndDate') ?></th>
                <th><?= ('Status') ?></th>
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
</section>

@stop