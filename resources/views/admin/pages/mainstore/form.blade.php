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
                    <div class="col-sm-3">
                      <!-- select -->
                      <div class="form-group">
                        <label>Select District Store</label>
                        <select class="form-control select2" name="districtstore_id" id="districtstore_id">
                          <option value="">Select District Store</option>
                          <?php
                          if(isset($districtstore) && $districtstore){
                              foreach ($districtstore as $key => $value) {
                              ?>
                                <option value="{{ $value->id }}" data-district_id = {{ $value->district_id }}  {{ isset($details->districtstore_id) && $details->districtstore_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                              <?php
                              }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <!-- select -->
                      <div class="form-group">
                        <label>Select Sub-Division</label>
                        <select class="form-control select2" name="subdevision_id" id="subdevision_id">
                          <option value="">Select District Store</option>
                          <?php
                          if(isset($details) && $details->subdevision_id){
                              if($subdevision){
                                  foreach ($subdevision as $key => $value) {
                                  ?>
                                  <option value="<?=$value->id?>" data-subdivision_name = "<?=$value->name?>" {{ isset($details->subdevision_id) && $details->subdevision_id == $value->id ? 'selected' : '' }}><?=$value->name?></option>
                                  <?php
                                  }
                              }
                          }
                          ?>
                        </select>
                        <input type="hidden" name="subdivision_name" value="{{ isset($details->subdivision_name) && $details->subdivision_name ? $details->subdivision_name : '' }}" id="subdivision_name">
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Store Name</label>
                        <input type="text" class="form-control" placeholder="Enter store name" name="name" value="{{ old('name', isset($details->name) && $details->name ? $details->name : '') }}">
                      </div>
                    </div>
                    <div class="col-sm-3">
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
          district_id: {
            required: true,
          },
          name: {
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

    $(document).on('change', '#districtstore_id', function() {
        var district_id = $(this).find(':selected').attr('data-district_id');
        var subdevision = '<?php echo json_encode($subdevision)?>';
        $("#subdevision_id").select2("destroy");
        var html = '<option value="">Select Sub-Seed Store</option>';
        if(subdevision){
            $.each(JSON.parse(subdevision), function (key, val) {
                if(val.district_id == district_id){
                    html = html + '<option value="'+val.id+'" data-subdivision_name = "'+val.name+'">'+val.name+'</option>';
                }
            });
        }

        $("#subdevision_id").html(html);
        $('#subdevision_id').select2({
              theme: 'bootstrap4'
        });
    });

    $(document).on('change', '#subdevision_id', function() {
        var subdivision_name = $(this).find(':selected').attr('data-subdivision_name');
        $("#subdivision_name").val(subdivision_name);
    });
});
</script>
@endsection
