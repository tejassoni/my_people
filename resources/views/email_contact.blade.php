@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Email Contact Inquery</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">You are logged in!</p>
                </div>
            </div>
        </div>
        <form role="form" name="role_add" id="role_add" method="post" action="{{ url('admin/role_insert') }}">
                   <!-- csrf security starts -->
                      @csrf
                   <!-- csrf security ends -->
                <div class="card-body">
                  <div class="form-group">
                    <label for="role_name">Name</label>
                    <input type="text" class="form-control" name="role_name" id="role_name" placeholder="Enter Role Name" value="{{ old('role_name') }}" required>
                  </div>
                  <div class="form-group">
                    <label for="role_alias">Alias</label>
                    <input type="text" class="form-control" name="role_alias" id="role_alias" placeholder="Enter Role Alias" value="{{ old('role_alias') }}" maxlength="10" required>
                  </div>  
                  <div class="form-group">
                        <label for="role_description">Description</label>
                        <textarea class="form-control" name="role_description" id="role_description" rows="3" placeholder="Enter Role Description" required>{{ old('role_description') }}</textarea>
                  </div>
                 
                  <div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" name="status" id="status" @if(is_array(old()) && old('status') == 'on') checked @endif>
                      <label class="custom-control-label" for="status">Status</label>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <a href="{{ url('admin/role_list') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> Back</a> &nbsp;
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
    </div>
@stop
