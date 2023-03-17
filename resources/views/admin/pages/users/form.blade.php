@extends('admin.layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $metadata['page_title'] }}</h1>
                </div>
                <!-- /.col -->
                @if(isset($metadata['breadcumb']) && $metadata['breadcumb'])
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @foreach ( $metadata['breadcumb'] as $key => $breadcumb ) 
                        <li class="breadcrumb-item {{ $breadcumb['url'] ? '' : 'active' }}">
                            @if(isset($breadcumb['url']) && $breadcumb['url'])
                            <a href="{{ url($breadcumb['url']) }}">{{ $breadcumb['title'] }}</a>
                            @else
                                {{ $breadcumb['title'] }}
                            @endif
                        </li>
                        @endforeach
                    </ol>
                </div>
                @endif
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- right column -->
          <div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{ $metadata['page_title'] }}</h3>
              </div>
              <!-- /.card-header -->
              <form id="dataForm" method="post" action="{{ url($metadata['page_data_store_url']) }}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="session_id" value="{{ Session::has('admin_id') ? Session::get('admin_id') : 0 }}">
                <input type="hidden" name="id" value="{{ isset($details->id) && $details->id ? $details->id : '' }}">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ old('name', isset($details->name) && $details->name ? $details->name : '') }}">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" placeholder="Enter email" name="email" value="{{ old('email', isset($details->email) && $details->email ? $details->email : '') }}">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" placeholder="Enter phone" name="phone" value="{{ old('phone', isset($details->phone) && $details->phone ? $details->phone : '') }}">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>In-Charge Name</label>
                        <input type="text" class="form-control" placeholder="Enter incharge name" name="incharge" value="{{ old('incharge', isset($details->incharge) && $details->incharge ? $details->incharge : '') }}">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Designation</label>
                        <select class="form-control select2" name="designation_id" id="designation_id" required="">
                          <option value="">Select a Designation</option>
                          <?php
                          if(isset($designation) && $designation){
                              foreach ($designation as $key => $value) {
                              ?>
                                <option value="{{ $value->id }}" data-designation="{{ $value->name }}" {{ isset($details->designation_id) && $details->designation_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                              <?php
                              }
                          }
                          ?>
                        </select>
                        <input type="hidden" name="designation" id="designation" value="{{ isset($details->designation) && $details->designation ? $details->designation : '' }}" >
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Type Of Store</label>
                        <select class="form-control select2" name="type" id="type" required="">
                          <option value="">Select Store</option>
                          <?php
                          $permission = session()->get('permission_array');
                          if(isset($permission['is_admin']) && $permission['is_admin']){
                          ?>
                            <option value="1" {{ isset($details->type) && $details->type == 1 ? 'selected' : '' }}>District</option>
                            <option value="2" {{ isset($details->type) && $details->type == 2 ? 'selected' : '' }}>Main</option>
                            <option value="3" {{ isset($details->type) && $details->type == 3 ? 'selected' : '' }}>Sub-Seed</option>
                          <?php
                          }
                          ?>
                          <?php
                          if(isset($permission['is_district']) && $permission['is_district']){
                          ?>
                            <option value="2" {{ isset($details->type) && $details->type == 2 ? 'selected' : '' }}>Main</option>
                            <!-- <option value="3" {{ isset($details->type) && $details->type == 3 ? 'selected' : '' }}>Sub-Seed</option> -->
                          <?php
                          }
                          if(isset($permission['is_main']) && $permission['is_main']){
                          ?>
                            <option value="3" {{ isset($details->type) && $details->type == 3 ? 'selected' : '' }}>Sub-Seed</option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Store Name</label>
                        <select class="form-control select2" name="store_id" id="store_id" required="">
                          <option value="">Select Store</option>
                          <?php
                          if(isset($stores) && $stores){
                              foreach ($stores as $key => $value) {
                              ?>
                                <option value="{{ $value->id }}" {{ isset($details->stores_id) && $details->stores_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                              <?php
                              }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="Enter password" name="password">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" id="status">
                          <option value="1" {{ isset($details->status) && $details->status == 1 ? 'selected' : '' }}>Active</option>
                          <option value="2" {{ isset($details->status) && $details->status == 2 ? 'selected' : '' }}>In-Active</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="{{ url($metadata['page_url']) }}" class="btn btn-danger">Reset</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('javascripts')
<script type="text/javascript">
$(document).ready(function() {
    @if($errors->any())
      @foreach ($errors->all() as $error)
        @php
        $errors = $error;
        @endphp
      @endforeach
      toastr.error("{{ $errors }}");
    @endif

    $('#dataForm').validate({
      rules: {
          name: {
            required: true,
          },
          email: {
            required: true,
            email: true,
          },
          phone: {
            required: true,
            number: true,
            minlength: 10,
            maxlength: 10,
          },
          incharge: {
            required: true,
          },
          designation_id: {
            required: true,
          },
          designation: {
            required: true,
          },
          type: {
            required: true,
          },
          store_id: {
            required: true,
          },
          password: {
            required: <?=isset($details->password) && $details->password ? 'false' : 'true'?>,
          },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
    });

    $(document).on('change', '#type', function() {
        var type = $(this).val();
        if(type == 1){
            var data = '<?php echo json_encode($districtstore)?>';
        }

        if(type == 2){
            var data = '<?php echo json_encode($mainstore)?>';
        }

        if(type == 3){
            var data = '<?php echo json_encode($subseedstore)?>';
        }

        var html = '<option value="">Select Store</option>';
        $("#store_id").select2("destroy");
        if(data){
            $.each(JSON.parse(data), function (key, val) {
                html = html + '<option value="'+val.id+'">'+val.name+'</option>';
            });
        }

        $("#store_id").html(html);
        $('#store_id').select2({
              theme: 'bootstrap4'
        });
    });

    $(document).on('change', '#designation_id', function() {
      var designation = $(this).find(':selected').attr('data-designation');
      $("#designation").val(designation);
    });
});
</script>
@endsection
