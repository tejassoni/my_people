@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Role List</h1>
@stop

@section('content')
    <section class="content">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">DataTable with minimal features &amp; hover style</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table id="role_list_table" class="display datatables table table-striped table-bordered w-100" sty>
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>Alias</th>
                          <th>Description</th>
                          <th>Status</th>
                          <th>Action</th>
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
