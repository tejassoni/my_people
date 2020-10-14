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
          <a href="/home" title="MyPeople Dashboard"><?= ('Subscription') ?></a>
        </li>
      </ol>
    </nav>
  </div>
</div>
@stop

@section('content')
<section class="content">
  <div class="container">
    <div class="card-deck mb-3 text-center">
      @if(isset($subscription_list) && !empty($subscription_list))
      @foreach ($subscription_list as $subscription_key => $subscription_val)
      <div class="card mb-4 box-shadow">
        <div class="card-header">
          <h4 class="my-0 font-weight-normal">{{ $subscription_val['sub_name'] }}</h4>
        </div>
        <div class="card-body">
          <ul class="list-unstyled mt-3 mb-4">
            <li>{{ $subscription_val['sub_description'] }}</li>
            <li>1 Missing Person Add</li>
            <li> <b>Price : </b>
              @if(isset($subscription_val['discount_amount']) && !empty($subscription_val['discount_amount']))
              <strike> {{ $subscription_val['plan_amount'] }}</strike>
              @else
              {{ $subscription_val['plan_amount'] }}
              @endif
              &#8377; </li>
            <li> <b>Discount : </b>{{ (isset($subscription_val['discount_amount']) && !empty($subscription_val['discount_amount'])) ? $subscription_val['discount_amount'] : 0 }} &#8377; </li>
            <li> <b>Total Price : </b>{{ $subscription_val['plan_amount'] - $subscription_val['discount_amount'] }} &#8377; </li>
          </ul>
          <a href="{{ url("/payment/dopayment/".$subscription_val['sub_id']) }}" class="btn btn-lg btn-block btn-outline-primary">Subscribe Now</a>
        </div>
      </div>
      @endforeach
      @endif
    </div>
  </div>
</section>
<script src="{{ asset('js/customer/missing_people.js') }}" defer></script>
@stop