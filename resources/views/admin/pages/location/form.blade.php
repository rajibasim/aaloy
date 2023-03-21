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
                        <input type="text" class="form-control" placeholder="Enter location name" name="location" value="{{ old('location', isset($details->location) && $details->location ? $details->location : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>District Store</label>
                        <select class="form-control select2" name="country_id" id="country_id" required="">
                          <option value="">Select Country</option>
                           @if($country)
                               @foreach ($country as $val)
                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>District Store</label>
                        <select class="form-control select2" name="state_id" id="state_id" required="">
                          <option value="">Select State</option>
                           @if($state)
                               @foreach ($state as $val)
                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Latitude</label>
                        <input type="text" class="form-control" placeholder="Enter latitude" name="latitude" value="{{ old('latitude', isset($details->latitude) && $details->latitude ? $details->latitude : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Longitude</label>
                        <input type="text" class="form-control" placeholder="Enter longitude" name="longitude" value="{{ old('longitude', isset($details->longitude) && $details->longitude ? $details->longitude : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Select</label>
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
          registration_address: {
            required: true,
          },
          licence_address: {
            required: true,
          },
          licence_number: {
            required: true,
          },
          issue_date: {
            required: true,
          },
          expiry_date: {
            required: true,
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

    $(document).on('change', '#country_id', function() {
        var country_id = $(this).val();
        var state = '<?php echo json_encode($state)?>';
        $("#state_id").select2("destroy");
        var html = '<option value="">Select State</option>';
        if(state){
            $.each(JSON.parse(state), function (key, val) {
                if(val.country_id == country_id){
                    html = html + '<option value="'+val.id+'">'+val.name+'</option>';
                }
            });
        }

        $("#state_id").html(html);
        $('#state_id').select2({
              theme: 'bootstrap4'
        });
    });
});
</script>
@endsection
