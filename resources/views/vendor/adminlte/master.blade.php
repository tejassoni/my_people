<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))</title>
    @if(! config('adminlte.enabled_laravel_mix'))
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    @include('adminlte::plugins', ['type' => 'css'])
    @yield('adminlte_css_pre')

    <!-- Header Ajax URL Setup -->
    <script type="text/javascript">
        var APPURL = '{{ url("") }}';
    </script>

    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/fontawesome.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Admin Backend Page wise CSS Load -->
    @if(strpos(Request::url(), 'ear_add') !== false ||
    strpos(Request::url(), 'ear_list') !== false ||
    strpos(Request::url(), 'ear_edit') !== false ||
    strpos(Request::url(), 'eyebrow_add') !== false ||
    strpos(Request::url(), 'eyebrow_list') !== false ||
    strpos(Request::url(), 'eyebrow_edit') !== false ||
    strpos(Request::url(), 'eye_add') !== false ||
    strpos(Request::url(), 'eye_list') !== false ||
    strpos(Request::url(), 'eye_edit') !== false ||
    strpos(Request::url(), 'hair_add') !== false ||
    strpos(Request::url(), 'hair_list') !== false ||
    strpos(Request::url(), 'hair_edit') !== false ||
    strpos(Request::url(), 'jaw_add') !== false ||
    strpos(Request::url(), 'jaw_list') !== false ||
    strpos(Request::url(), 'jaw_edit') !== false ||
    strpos(Request::url(), 'lip_add') !== false ||
    strpos(Request::url(), 'lip_list') !== false ||
    strpos(Request::url(), 'nose_add') !== false ||
    strpos(Request::url(), 'nose_list') !== false ||
    strpos(Request::url(), 'nose_edit') !== false ||
    strpos(Request::url(), 'skin_add') !== false ||
    strpos(Request::url(), 'skin_list') !== false ||
    strpos(Request::url(), 'skin_edit') !== false )
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    @endif

    @yield('adminlte_css')

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @else
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/admin/admin-css.css') }}">
</head>

<body class="@yield('classes_body')" @yield('body_data')>

    @yield('body')

    @if(! config('adminlte.enabled_laravel_mix'))
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
    @include('adminlte::plugins', ['type' => 'js'])

    @yield('adminlte_js')
    @else
    <script src="{{ asset('js/app.js') }}"></script>


    @endif
    <script src="{{ asset('js/admin/admin-js.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>

    <!-- Minimum Datatables JS Requires Starts -->
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Minimum Datatables JS Requires Ends -->

    <!-- Export Buttons Datatables JS Requires Starts -->
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/buttons/js/buttons.print.min.js') }}"></script>
    <!-- Export Buttons Datatables JS Requires Starts -->

    <!-- Admin Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'ear_add') !== false ||
    strpos(Request::url(), 'ear_list') !== false ||
    strpos(Request::url(), 'ear_edit') !== false ||
    strpos(Request::url(), 'eyebrow_add') !== false ||
    strpos(Request::url(), 'eyebrow_list') !== false ||
    strpos(Request::url(), 'eyebrow_edit') !== false ||
    strpos(Request::url(), 'eye_add') !== false ||
    strpos(Request::url(), 'eye_list') !== false ||
    strpos(Request::url(), 'eye_edit') !== false ||
    strpos(Request::url(), 'hair_add') !== false ||
    strpos(Request::url(), 'hair_list') !== false ||
    strpos(Request::url(), 'hair_edit') !== false ||
    strpos(Request::url(), 'jaw_add') !== false ||
    strpos(Request::url(), 'jaw_list') !== false ||
    strpos(Request::url(), 'jaw_edit') !== false ||
    strpos(Request::url(), 'lip_add') !== false ||
    strpos(Request::url(), 'lip_list') !== false ||
    strpos(Request::url(), 'lip_edit') !== false ||
    strpos(Request::url(), 'nose_add') !== false ||
    strpos(Request::url(), 'nose_list') !== false ||
    strpos(Request::url(), 'nose_edit') !== false ||
    strpos(Request::url(), 'skin_add') !== false ||
    strpos(Request::url(), 'skin_list') !== false ||
    strpos(Request::url(), 'skin_edit') !== false)
    <script src="{{ asset('vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    @endif

    <!-- Admin Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'role_add') !== false ||
    strpos(Request::url(), 'role_list') !== false ||
    strpos(Request::url(), 'role_edit') !== false)
    <script src="{{ asset('js/admin/role_master.js') }}"></script>
    @endif

    <!-- Admin Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'eyebrow_add') !== false ||
    strpos(Request::url(), 'eyebrow_list') !== false ||
    strpos(Request::url(), 'eyebrow_edit') !== false)
    <script src="{{ asset('js/admin/eyebrow_master.js') }}"></script>
    @endif

    <!-- Admin Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'eye_add') !== false ||
    strpos(Request::url(), 'eye_list') !== false ||
    strpos(Request::url(), 'eye_edit') !== false)
    <script src="{{ asset('js/admin/eye_master.js') }}"></script>
    @endif

    <!-- Admin Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'ear_add') !== false ||
    strpos(Request::url(), 'ear_list') !== false ||
    strpos(Request::url(), 'ear_edit') !== false )
    <script src="{{ asset('js/admin/ear_master.js') }}"></script>
    @endif

    <!-- Admin Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'hair_add') !== false ||
    strpos(Request::url(), 'hair_list') !== false ||
    strpos(Request::url(), 'hair_edit') !== false )
    <script src="{{ asset('js/admin/hair_master.js') }}"></script>
    @endif

    <!-- Admin Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'jaw_add') !== false ||
    strpos(Request::url(), 'jaw_list') !== false ||
    strpos(Request::url(), 'jaw_edit') !== false )
    <script src="{{ asset('js/admin/jaw_master.js') }}"></script>
    @endif

    <!-- Admin Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'lip_add') !== false ||
    strpos(Request::url(), 'lip_list') !== false ||
    strpos(Request::url(), 'lip_edit') !== false )
    <script src="{{ asset('js/admin/lip_master.js') }}"></script>
    @endif

    <!-- Admin Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'nose_add') !== false ||
    strpos(Request::url(), 'nose_list') !== false ||
    strpos(Request::url(), 'nose_edit') !== false )
    <script src="{{ asset('js/admin/nose_master.js') }}"></script>
    @endif

    <!-- Admin Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'skin_add') !== false ||
    strpos(Request::url(), 'skin_list') !== false ||
    strpos(Request::url(), 'skin_edit') !== false )
    <script src="{{ asset('js/admin/skin_master.js') }}"></script>
    @endif

    <!-- Admin Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'plan_add') !== false ||
    strpos(Request::url(), 'plan_list') !== false ||
    strpos(Request::url(), 'plan_edit') !== false)
    <script src="{{ asset('js/admin/plan_master.js') }}"></script>
    @endif

    <!-- Admin Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'subscription_add') !== false ||
    strpos(Request::url(), 'subscription_list') !== false ||
    strpos(Request::url(), 'subscription_edit') !== false)
    <script src="{{ asset('js/admin/subscription_master.js') }}"></script>
    @endif

    <!-- Admin Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'user_add') !== false ||
    strpos(Request::url(), 'user_list') !== false ||
    strpos(Request::url(), 'user_edit') !== false)
    <script src="{{ asset('js/admin/user_master.js') }}"></script>
    @endif

    <!-- Discount Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'discount_add') !== false ||
    strpos(Request::url(), 'discount_list') !== false ||
    strpos(Request::url(), 'discount_edit') !== false)
    <script src="{{ asset('js/admin/discount_master.js') }}"></script>
    @endif


    <!-- Discount Backend Page wise JS Load -->
    @if(strpos(Request::url(), 'missing_person_add') !== false ||
    strpos(Request::url(), 'discount_list') !== false ||
    strpos(Request::url(), 'discount_edit') !== false)
    <script src="{{ asset('js/customer/missing_people.js') }}"></script>
    @endif

</body>
@include('vendor.adminlte.partials.modal_messages')
@extends('adminlte::admin-footer')

</html>