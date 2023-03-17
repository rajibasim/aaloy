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
                        <label>Sub-Seed Store Name</label>
                        <input type="text" class="form-control" placeholder="Enter Sub-Seed Store name" name="name" value="{{ old('name', isset($details->name) && $details->name ? $details->name : '') }}">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>District Store</label>
                        <select class="form-control select2" name="districtstore_id" id="districtstore_id">
                          <option value="">Select District Store</option>
                          <?php
                          if($districtstore){
                              foreach ($districtstore as $key => $value) {
                              ?>
                                <option value="{{ $value->id }}" {{ isset($details->districtstore_id) && $details->districtstore_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                              <?php
                              }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Main Store</label>
                        <select class="form-control select2" name="mainstore_id" id="mainstore_id">
                          <option value="">Select Main Store</option>
                          <?php
                          if(isset($details->mainstore_id) && $details->mainstore_id && $mainstore){
                              foreach ($mainstore as $key => $value) {
                                if(isset($details->districtstore_id) && $details->districtstore_id == $value->id){
                              ?>
                                <option value="{{ $value->id }}" {{ isset($details->mainstore_id) && $details->mainstore_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                              <?php
                                }
                              }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Select Sub Devision</label>
                        <select class="form-control select2" name="subdevision_id" id="subdevision_id">
                          <option value="">Select Sub Devision</option>
                          <?php
                          if($subdevision){
                              foreach ($subdevision as $key => $value) {
                              ?>
                                <option value="{{ $value->id }}" {{ isset($details->subdevision_id) && $details->subdevision_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                              <?php
                              }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Select Block</label>
                        <select class="form-control select2" name="block_id" id="block_id">
                          <option value="">Select Block</option>
                          <?php
                          if(isset($details->block_id) && $details->block_id && $block){
                              foreach ($block as $key => $value) {
                                if(isset($details->subdevision_id) && $details->subdevision_id == $value->subdevision_id){
                              ?>
                                <option value="{{ $value->id }}" {{ isset($details->block_id) && $details->block_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                              <?php
                                }
                              }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Select Panchanyat</label>
                        <select class="form-control select2" name="panchanyat_id" id="panchanyat_id">
                          <option value="">Select Panchanyat</option>
                          <?php
                          if(isset($details->panchanyat_id) && $details->panchanyat_id && $panchanyat){
                              foreach ($panchanyat as $key => $value) {
                                if(isset($details->block_id) && $details->block_id == $value->block_id){
                              ?>
                                <option value="{{ $value->id }}" {{ isset($details->panchanyat_id) && $details->panchanyat_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                              <?php
                                }
                              }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Pin Code</label>
                        <input type="text" class="form-control" placeholder="Enter pin name" name="pincode" value="{{ old('name', isset($details->pincode) && $details->pincode ? $details->pincode : '') }}">
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
          districtstore_id: {
            required: true,
          },
          mainstore_id: {
            required: true,
          },
          subdevision_id: {
            required: true,
          },
          block_id: {
            required: true,
          },
          panchanyat_id: {
            required: true,
          },
          name: {
            required: true,
          },
          pincode: {
            required: true,
            number: true,
            minlength: 6,
            maxlength: 6,
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

   /* $("#Input_Id").change(function(){   // 1st way
        alert("hhhh");
    });*/

    $(document).on('change', '#districtstore_id', function() {
        var mainstore = '<?php echo json_encode($mainstore)?>';
        var html = '<option value="">Select Main Store</option>';
        var districtstore_id = $(this).val();
        $("#mainstore_id").select2("destroy");
        if(mainstore){
            $.each(JSON.parse(mainstore), function (key, val) {
                if(val.districtstore_id == districtstore_id){
                    html = html + '<option value="'+val.id+'">'+val.name+'</option>';
                }
            });
        }

        $("#mainstore_id").html(html);
        $('#mainstore_id').select2({
              theme: 'bootstrap4'
        });
    });

    $(document).on('change', '#subdevision_id', function() {
        var block = '<?php echo json_encode($block)?>';
        var html = '<option value="">Select Block</option>';
        var subdevision_id = $(this).val();
        $("#block_id").select2("destroy");
        if(block){
            $.each(JSON.parse(block), function (key, val) {
                if(val.subdevision_id == subdevision_id){
                    html = html + '<option value="'+val.id+'">'+val.name+'</option>';
                }
            });
        }

        $("#block_id").html(html);
        $('#block_id').select2({
              theme: 'bootstrap4'
        });
    });

    $(document).on('change', '#block_id', function() {
        var panchanyat = '<?php echo json_encode($panchanyat)?>';
        var html = '<option value="">Select Panchanyat</option>';
        var block_id = $(this).val();
        $("#panchanyat_id").select2("destroy");
        if(panchanyat){
            $.each(JSON.parse(panchanyat), function (key, val) {
                if(val.block_id == block_id){
                    html = html + '<option value="'+val.id+'">'+val.name+'</option>';
                }
            });
        }

        $("#panchanyat_id").html(html);
        $('#panchanyat_id').select2({
              theme: 'bootstrap4'
        });
    });
});
</script>
@endsection
