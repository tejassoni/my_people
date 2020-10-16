@extends('adminlte::page')
@section('title', 'AdminLTE')
@section('content_header')
@include('vendor.adminlte.partials.header_response_messages')
<div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    @if (isset($subscribe_order_list) && !empty($subscribe_order_list))
    <h1 class="m-0 text-dark"><a href='{{ url("/customer/missing_person_add") }}' class="btn-success btn-sm" title="Add New Button"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?= ('Add New') ?></a></h1>
    @else
    <h1 class="m-0 text-dark"><a href='{{ url("/customer/subscribe") }}' class="btn-warning btn-sm" title="Subscribe"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> <?= ('Subscribe') ?></a></h1>
    @endif
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

<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <!-- <div class="card-header">
              <h3 class="card-title">DataTable with minimal features &amp; hover style</h3>
            </div> -->
        <!-- /.card-header -->
        <div class="card-body">
          <table id="my_missing_person_list_table" class="display datatables table table-striped table-bordered w-100">
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
  @include('vendor.adminlte.partials.modal_send_response_message')
  <!-- Customer Request Find  Bootstrap Modal Ends -->
</section>
<script src="{{ asset('js/customer/my_missing_people.js') }}" defer></script>
@stop