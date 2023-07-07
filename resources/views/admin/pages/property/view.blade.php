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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-body ">
                <div class="float-right">
                    <a href="{{ url($metadata['page_delete_url']) }}" class="btn btn-danger btn-sm multiple" data-toggle="tooltip" data-placement="top" title="Delete">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                    <a href="{{ url($metadata['page_form_url']) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="New Records">
                      <i class="fa fa-plus" aria-hidden="true"></i> Add New Property
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
              @endphp
              <div class="card-body">
                <form method="get" action="" autocomplete="off" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-4">
                      <input type="text" class="form-control" placeholder="Title" name="title" value="{{ isset($serach_data['title']) && $serach_data['title'] ? $serach_data['title'] : '' }}">
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <select class="form-control select2" name="location_id" id="location_id">
                          <option value="">Select Location</option>
                           @if($location)
                               @foreach ($location as $val)
                                <option value="{{ $val->id }}" {{ isset($serach_data['location_id']) && $serach_data['location_id'] == $val->id ? 'selected' : '' }}>{{ $val->location }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <select class="form-control select2" name="property_for" id="property_for">
                          <option value="">Select One</option>
                          <option value="1" {{ isset($serach_data['property_for']) && $serach_data['property_for'] == 1 ? 'selected' : '' }}>Rent</option>
                          <option value="2" {{ isset($serach_data['property_for']) && $serach_data['property_for'] == 2 ? 'selected' : '' }}>Sell</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <select class="form-control select2" name="posted_by" id="posted_by">
                          <option value="">Select One</option>
                          <option value="1" {{ isset($serach_data['posted_by']) && $serach_data['posted_by'] == 1 ? 'selected' : '' }}>Broker</option>
                          <option value="2" {{ isset($serach_data['posted_by']) && $serach_data['posted_by'] == 2 ? 'selected' : '' }}>User</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <select class="form-control select2" name="posted_by_id" id="posted_by_id">
                          <option value="">Posted By(User)</option>
                          <?php
                          if($users){
                            foreach ($users as $key => $val) {
                          ?>
                                 <option value="{{ $val->id }}" {{ isset($serach_data['posted_by_id']) && $serach_data['posted_by_id'] == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
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
                        <select class="form-control select2" name="property_type_id" id="property_type_id" >
                          <option value="">Select Property Type</option>
                           @if($property_type)
                               @foreach ($property_type as $val)
                                <option value="{{ $val->id }}" {{ isset($serach_data['property_type_id']) && $serach_data['property_type_id'] == $val->id ? 'selected' : '' }}>{{ $val->property_type }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <select class="form-control select2" name="preferance" id="preferance">
                          <option value="">Select One</option>
                          <option value="1" {{ isset($serach_data['preferance']) && $serach_data['preferance'] == 1 ? 'selected' : '' }}>Bachelor</option>
                          <option value="2" {{ isset($serach_data['preferance']) && $serach_data['preferance'] == 2 ? 'selected' : '' }}>Family</option>
                          <option value="3" {{ isset($serach_data['preferance']) && $serach_data['preferance'] == 3 ? 'selected' : '' }}>No Preferance</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-4">
                      <select class="form-control" name="status">
                        <option value="">Select Status</option>
                        <option value="1" {{ isset($serach_data['status']) && $serach_data['status'] == 1 ? 'selected' : '' }}>Active</option>
                        <option value="2" {{ isset($serach_data['status']) && $serach_data['status'] == 2 ? 'selected' : '' }}>In-Active</option>
                      </select>
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
                      <th><input class="checkall" type="checkbox" value=""></th>
                      <th>Title</th>
                      <th>Property Type</th>
                      <th>Property For</th>
                      <th>Posted By</th>
                      <th>Admin Aprove</th>
                      <!-- <th>Created At</th> -->
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(isset($rows) && $rows)
                    @foreach ( $rows as $key => $res )
                    <tr> 
                      <td style="width: 20px;"><input class="checkbox" type="checkbox" value="{{ $res->id }}"></td>
                      <td>{{ $res->title }}</td>
                      <td>{{ $res->property_type }}</td>
                      <td>{{ $res->property_for == 1 ? 'Rent' : 'Sell' }}</td>
                      <td>{{ $res->posted_by == 1 ? 'Broker' : 'Owner' }}</td>
                      <td>{{ $res->status == 1 ? 'Yes' : 'No' }}</td>
                      <!-- <td>{{ $res->created_at }}</td> -->
                      <td>{{ $res->status == 1 ? 'Active' : 'In-Active' }}</td>
                      <td style="width: 130px;">
                        <a href="{{ url($metadata['page_details'].'/'.encrypt($res->id)) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Details">
                          <i class="fas fa-eye" aria-hidden="true"></i>
                        </a>
                        <a href="{{ url($metadata['page_form_url'].'/'.encrypt($res->id)) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                          <i class="fas fa-edit" aria-hidden="true"></i>
                        </a>
                        <a href="{{ url($metadata['page_delete_url'].'/'.$res->id) }}" class="btn btn-danger btn-sm single" data-toggle="tooltip" data-placement="top" title="Delete">
                          <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  @else
                    <tr> 
                      <td colspan="8">No record found.</td>
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
$(document).ready(function() {
    @if(Session::has('flash_data')) 
      @php 
        $flash_data = Session::pull('flash_data');
      @endphp
      toastr.{{ $flash_data['status'] }}("{{ $flash_data['message'] }}");
    @endif

    var clicked = false;
    $(".checkall").on("click", function() {
        $(".checkbox").prop("checked", !clicked);
        clicked = !clicked;
        this.innerHTML = clicked ? 'Deselect' : 'Select';
    });
    
    $(".multiple").on("click", function(e) {
        e.preventDefault();
        var checkedVals = $('.checkbox:checkbox:checked').map(function() {
            return this.value;
        }).get();
        var ids = checkedVals.join(",");
        var delete_url = $(this).attr('href');

        Swal.fire({
          title: 'Are you sure you want to delete this?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
              if(ids){
                  window.location.href = delete_url+'/'+ids;
              }else{
                  toastr.error('Sorry! No records selected.');
              }
          }
        })
    });

    $(".single").on("click", function(e) {
        e.preventDefault();
        var delete_url = $(this).attr('href');
        Swal.fire({
          title: 'Are you sure you want to delete this?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = delete_url;
          }
        })
    });
});
</script>
@endsection
