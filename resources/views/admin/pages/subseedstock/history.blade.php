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
                            <a href="{{ $breadcumb['url'] }}">{{ $breadcumb['title'] }}</a>
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
    <section class="content" style="display: none;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-body ">
                <div class="float-right">
                    <!-- <a href="{{ url($metadata['page_delete_url']) }}" class="btn btn-danger btn-sm multiple" data-toggle="tooltip" data-placement="top" title="Delete">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a> -->
                    <a href="{{ url($metadata['page_form_url']) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="New Records">
                      <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Search</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              @php
                $serach_data = isset($metadata['serach_data']) && $metadata['serach_data'] ? $metadata['serach_data'] : '';
                $permission_array = session()->get('permission_array');
                $user_data = session()->get('user_data');
              @endphp
              <div class="card-body">
                <form method="get" action="" autocomplete="off" enctype="multipart/form-data">
                  <div class="row">
                    <?php
                    if(isset($permission_array['is_admin']) && $permission_array['is_admin']){
                    ?>
                      <div class="col-sm-4">
                        <!-- select -->
                        <div class="form-group">
                          <select class="form-control select2" name="district_id" id="district_id">
                            <option value="">Select District</option>
                            @if($district)
                               @foreach ($district as $val)
                                <option value="{{ $val->id }}" {{ isset($serach_data['district_id']) && $serach_data['district_id'] == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
                               @endforeach
                            @endif
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <!-- select -->
                        <div class="form-group">
                          <select class="form-control select2" name="districtstore_id" id="districtstore_id">
                            <option value="">Select District Store</option>
                            @if($districtstore)
                               @foreach ($districtstore as $val)
                                <option value="{{ $val->id }}" {{ isset($serach_data['districtstore_id']) && $serach_data['districtstore_id'] == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
                               @endforeach
                            @endif
                          </select>
                        </div>
                      </div>
                    <?php
                    }
                    ?>
                    <?php
                    if((isset($permission_array['is_admin']) && $permission_array['is_admin']) || isset($permission_array['is_district']) && $permission_array['is_district']){
                    ?>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <select class="form-control select2" name="mainstore_id" id="mainstore_id">
                          <option value="">Select Main store</option>
                          @if($mainstore)
                             @foreach ($mainstore as $val)
                              <option value="{{ $val->id }}" {{ isset($serach_data['mainstore_id']) && $serach_data['mainstore_id'] == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
                             @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <select class="form-control select2" name="subseedstore_id" id="subseedstore_id">
                          <option value="">Select Sub-seed store</option>
                          @if($subseedstore)
                             @foreach ($subseedstore as $val)
                              <option value="{{ $val->id }}" {{ isset($serach_data['subseedstore_id']) && $serach_data['subseedstore_id'] == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
                             @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <select class="form-control select2" name="category_id" id="category_id">
                          <option value="">Select type of comodity</option>
                          @if($category)
                             @foreach ($category as $val)
                              <option value="{{ $val->id }}" {{ isset($serach_data['category_id']) && $serach_data['category_id'] == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
                             @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <select class="form-control select2" name="brand_id" id="brand_id">
                          <option value="">Select manufacturer</option>
                          @if($brand)
                             @foreach ($brand as $val)
                              <option value="{{ $val->id }}" {{ isset($serach_data['brand_id']) && $serach_data['brand_id'] == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
                             @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <select class="form-control select2" name="product_id" id="product_id">
                          <option value="">Select comodity</option>
                          @if($product)
                             @foreach ($product as $val)
                              <option value="{{ $val->id }}" {{ isset($serach_data['product_id']) && $serach_data['product_id'] == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
                             @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-1">
                      <button type="submit" class="btn btn-block btn-primary">Search</button>
                    </div>
                    <div class="col-1">
                      <a href="{{ URL($metadata['page_url']) }}" class="btn btn-block btn-danger">Reset</a>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">{{ $metadata['page_title'] }}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Sl No</th>
                      <th>Sub Seed Store</th>
                      <th>Product Name</th>
                      <th>Entry Date</th>
                      <th>Type</th>
                      <th>Quentity</th>
                      <th>Stock</th>
                      <th>Note</th>
                      <th>Update Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(isset($rows) && $rows)
                      @foreach ( $rows as $key => $res )
                      <tr> 
                        <td>{{ $key+1 }}</td>
                        <td>{{ $res->subseedstore_name }}</td>
                        <td>{{ $res->product_name }}</td>
                        <td>{{ $res->entry_date }}</td>
                        <td>
                          <?php
                          if($res->type == 1){
                              echo "Entry";
                          }else if($res->type == 2){
                              echo "Distribute";
                          }else if($res->type == 3){
                              echo "Add Adjusment";
                          }else{
                              echo "Substruct Adjusment";
                          }
                          ?>
                        </td>
                        <td>{{ $res->quentity }}</td>
                        <td>{{ $res->adjust_stock }}</td>
                        <td>{{ $res->note }}</td>
                        <td>{{ $res->updated_at }}</td>
                      </tr>
                      @endforeach
                    @else
                      <tr> 
                        <td colspan="9">No record found.</td>
                      </tr>
                    @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <div class="float-right">
                  @if(isset($rows) && $rows)
                    {!! $rows->appends(Request::all())->links() !!}
                  @endif
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
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
    var products = '<?php echo json_encode($product)?>';
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

    $(document).on('change', '#district_id', function() {
        var district_id = $(this).val();
        var districtstore = '<?php echo json_encode($districtstore)?>';
        $("#districtstore_id").select2("destroy");
        var html = '<option value="">Select District Store</option>';
        if(districtstore){
            $.each(JSON.parse(districtstore), function (key, val) {
                if(val.district_id == district_id){
                    html = html + '<option value="'+val.id+'">'+val.name+'</option>';
                }
            });
        }

        $("#districtstore_id").html(html);
        $('#districtstore_id').select2({
              theme: 'bootstrap4'
        });
    });

    $(document).on('change', '#districtstore_id', function() {
        var main_store_name = $(this).find(':selected').attr('data-district');
        var districtstore_id = $(this).val();
        var mainstore = '<?php echo json_encode($mainstore)?>';
        $("#mainstore_id").select2("destroy");
        var html = '<option value="">Select Main Store</option>';
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

    $(document).on('change', '#mainstore_id', function() {
        var main_store_name = $(this).find(':selected').attr('data-district');
        var mainstore_id = $(this).val();
        var subseedstore = '<?php echo json_encode($subseedstore)?>';
        $("#subseedstore_id").select2("destroy");
        var html = '<option value="">Select Sub-seed store</option>';
        if(subseedstore){
            $.each(JSON.parse(subseedstore), function (key, val) {
                if(val.mainstore_id == mainstore_id){
                    html = html + '<option value="'+val.id+'">'+val.name+'</option>';
                }
            });
        }

        $("#subseedstore_id").html(html);
        $('#subseedstore_id').select2({
              theme: 'bootstrap4'
        });
    });
});
</script>
@endsection
