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
              <?php
              $permission = session()->get('permission_array');
              ?>
              <!-- /.card-header -->
              <form id="dataForm" method="post" action="{{ url($metadata['page_data_store_url']) }}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="session_id" value="{{ Session::has('admin_id') ? Session::get('admin_id') : 0 }}">
                <input type="hidden" name="main_store_name" id="main_store_name" value="">
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
                        <label>Main Store</label>
                        <select class="form-control select2" name="mainstore_id" id="mainstore_id" required="">
                          <option value="">Select Main Store</option>
                           @if($main_store)
                               @foreach ($main_store as $val)
                                <option value="{{ $val->id }}" data-mainstore = "{{ $val->name }}">{{ $val->name }}</option>
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
                          <!-- <option value="1">Entry</option> -->
                          <?php
                          if((isset($permission['is_main_store']) && $permission['is_main_store'] == '0') || (isset($permission['is_admin']) && $permission['is_admin'])){
                          ?>
                          <option value="2">Distribute</option>
                          <?php
                          }
                          ?>
                          <?php
                          if((isset($permission['is_main_store']) && $permission['is_main_store'] == '1') || (isset($permission['is_admin']) && $permission['is_admin'])){
                          ?>
                          <option value="3">Add Adjusment</option>
                          <option value="4">Substruct Adjusment</option>
                          <?php
                          }
                          ?>
                          <option value="5">Wastage</option>
                        </select>
                      </div>
                    </div>
                    <?php
                    if((isset($permission['is_main_store']) && $permission['is_main_store'] == '0') || (isset($permission['is_admin']) && $permission['is_admin'])){
                    ?>
                    <div class="col-sm-4" id="subseedstore_id_div">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Sub-Seed Store</label>
                        <select class="form-control select2" name="subseedstore_id" id="subseedstore_id" required="">
                          <option value="">Select Sub-Seed Store</option>
                        </select>
                      </div>
                    </div>
                    <?php
                    }
                    ?>
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
                    <div class="col-sm-12">
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
          subseedstore_id: {
            required: true,
          },
          mainstore_id: {
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

    $(document).on('change', '#mainstore_id', function() {
        var main_store_name = $(this).find(':selected').attr('data-mainstore');
        var mainstore_id = $(this).val();
        var subseed_store = '<?php echo json_encode($subseed_store)?>';
        $("#subseedstore_id").select2("destroy");
        var html = '<option value="">Select Sub-Seed Store</option>';
        if(subseed_store){
            $.each(JSON.parse(subseed_store), function (key, val) {
                if(val.mainstore_id == mainstore_id){
                    html = html + '<option value="'+val.id+'">'+val.name+'</option>';
                }
            });
        }

        $("#main_store_name").val(main_store_name);
        $("#subseedstore_id").html(html);
        $('#subseedstore_id').select2({
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
    });*/

    <?php
    if((isset($permission['is_main_store']) && $permission['is_main_store'] == '0') || (isset($permission['is_admin']) && $permission['is_admin'])){
    ?>
      $(document).on('change', '#type', function() {
          var type = $(this).val();
          if(type == 5){
              $("#subseedstore_id_div").hide();
          }else{
              $("#subseedstore_id_div").show();
          }
      });
    <?php
    }
    ?>

    
});
</script>
@endsection
