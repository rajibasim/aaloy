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
                <input type="hidden" name="district_name" id="district_name" value="">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Date</label>
                        <input type="text" class="form-control datepicker" placeholder="Date" name="date" value="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>District Store</label>
                        <select class="form-control select2" name="districtstore_id" id="districtstore_id" required="">
                          <option value="">Select Store</option>
                           @if($district_store)
                               @foreach ($district_store as $val)
                                <option value="{{ $val->id }}" data-district = "{{ $val->district }}">{{ $val->name }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="type" id="type">
                          <option value="1">Entry</option>
                          <option value="2">Distribute</option>
                          <!-- <option value="3">Add Adjusment</option> -->
                          <option value="4">Substruct Adjusment</option>
                          <option value="5">Wastage</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4" id="main_store_div" style="display: none;">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Main Store</label>
                        <select class="form-control select2" name="mainstore_id" id="mainstore_id" required="">
                          <option value="">Select Main Store</option>
                           @if($main_store)
                               @foreach ($main_store as $val)
                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Type of comodity</label>
                        <select class="form-control select2" name="category_id" id="category_id" required="">
                          <option value="">Select Type of comodity</option>
                           @if($category)
                               @foreach ($category as $val)
                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Manufacturer</label>
                        <select class="form-control select2" name="brand_id" id="brand_id" required="">
                          <option value="">Select Manufacturer</option>
                           @if($brand)
                               @foreach ($brand as $val)
                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Comodity</label>
                        <select class="form-control select2" name="product_id" id="product_id" required="">
                          <option value="">Select Comodity</option>
                           @if($products)
                               @foreach ($products as $val)
                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Quentity(kg)</label>
                         <input type="text" class="form-control" id="quentity" placeholder="Quentity" name="quentity">
                      </div>
                    </div>
                    <div class="col-sm-8">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Note</label>
                        <input type="text" class="form-control" id="note" placeholder="Note" name="note">
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
function productFilter(brand_id = '', category_id = ''){
    var products = '<?php echo json_encode($products)?>';
    if(brand_id && category_id){
        $("#product_id").select2("destroy");
        var html = '<option value="">Select Comodity</option>';
        if(products){
            $.each(JSON.parse(products), function (key, val) {
                if((val.brand_id == brand_id) && (val.category_id == category_id)){
                    html = html + '<option value="'+val.id+'">'+val.name+'</option>';
                }
            });
        }
        $("#product_id").html(html);
        $('#product_id').select2({
              theme: 'bootstrap4'
        });
    }
}
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
          date: {
            required: true,
          },
          districtstore_id: {
            required: true,
          },
          mainstore_id: {
            required: true,
          },
          category_id: {
            required: true,
          },
          brand_id: {
            required: true,
          },
          product_id: {
            required: true,
          },
          quentity: {
            required: true,
            digits: true,
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
        var district_name = $(this).find(':selected').attr('data-district');
        var districtstore_id = $(this).val();
        var main_store = '<?php echo json_encode($main_store)?>';
        $("#mainstore_id").select2("destroy");
        var html = '<option value="">Select Main Store</option>';
        if(main_store){
            $.each(JSON.parse(main_store), function (key, val) {
                if(val.districtstore_id == districtstore_id){
                    html = html + '<option value="'+val.id+'">'+val.name+'</option>';
                }
            });
        }

        $("#district_name").val(district_name);
        $("#mainstore_id").html(html);
        $('#mainstore_id').select2({
              theme: 'bootstrap4'
        });
    });


    $(document).on('change', '#type', function() {
        var type = $(this).val();
        if(type == 2){
          $("#main_store_div").show();
        }else{
          $("#main_store_div").hide();
        }
    });

    $(document).on('change', '#brand_id', function() {
        var brand_id = $(this).val();
        var category_id = $("#category_id").val();
        productFilter(brand_id, category_id);
    });

    $(document).on('change', '#category_id', function() {
        var category_id = $(this).val();
        var brand_id = $("#brand_id").val();
        productFilter(brand_id, category_id);
    });

    /*$(document).on('change', '#product_id', function() {
        var category_id = $("#category_id").val();
        var brand_id = $("#brand_id").val();
        productFilter(brand_id, category_id);
    }); */

    
});


</script>
@endsection
