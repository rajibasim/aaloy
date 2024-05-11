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
    @if($details->is_booked == 0)
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Image Upload</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <form method="post" action="{{ url($metadata['save_image']) }}" autocomplete="off" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="id" value="{{ isset($details->id) && $details->id ? $details->id : '' }}">
                  <div class="row">
                    <div class="col-6">
                      <input type="text" class="form-control" name="image_title" value="">
                    </div>
                    <div class="col-4">
                      <input type="file" class="form-control" name="property_image" value="" accept="image/png, image/gif, image/jpeg" required="">
                    </div>
                    <div class="col-1">
                      <button type="submit" class="btn btn-block btn-primary">Save</button>
                    </div>
                    <div class="col-1">
                      <a href="{{ url($metadata['page_details'].'/'.encrypt($details->id)) }}" class="btn btn-block btn-danger">Reset</a>
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
    @endif
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
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ isset($details->title) && $details->title ? $details->title : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Property For</label>
                        <input type="text" class="form-control" name="property_for" value="{{ isset($details->property_for) && $details->property_for ? $details->property_for : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Posted By</label>
                        <input type="text" class="form-control" name="posted_by" value="{{ isset($details->posted_by) && $details->posted_by ? $details->posted_by : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Posted By(User)</label>
                        <input type="text" class="form-control" name="posted_by_txt" value="{{ isset($details->posted_by_txt) && $details->posted_by_txt ? $details->posted_by_txt : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Property Type</label>
                        <input type="text" class="form-control" name="property_type" value="{{ isset($details->property_type) && $details->property_type ? $details->property_type : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Preferance</label>
                        <input type="text" class="form-control" name="preferance" value="{{ isset($details->preferance) && $details->preferance ? $details->preferance : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Gender</label>
                        <input type="text" class="form-control" name="gender" value="{{ isset($details->gender) && $details->gender ? $details->gender : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Location</label>
                        <input type="text" class="form-control" name="location" value="{{ isset($details->location) && $details->location ? $details->location : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="{{ isset($details->address) && $details->address ? $details->address : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Floor</label>
                        <input type="text" class="form-control" name="floor" value="{{ isset($details->floor) && $details->floor ? $details->floor : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Out Of Floor</label>
                        <input type="text" class="form-control" name="out_of_floor" value="{{ isset($details->out_of_floor) && $details->out_of_floor ? $details->out_of_floor : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Room Type</label>
                        <input type="text" class="form-control" name="no_of_room" value="{{ isset($details->no_of_room) && $details->no_of_room ? $details->no_of_room : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Bathroom</label>
                        <input type="number" class="form-control" name="bathroom" value="{{ isset($details->bathroom) && $details->bathroom ? $details->bathroom : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" name="price" value="{{ isset($details->price) && $details->price ? $details->price : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Booking Price</label>
                        <input type="number" class="form-control" name="booking_price" value="{{ isset($details->booking_price) && $details->booking_price ? $details->booking_price : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Maintenance Charge</label>
                        <input type="number" class="form-control" name="maintenance" value="{{ isset($details->maintenance) && $details->maintenance ? $details->maintenance : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Carpet Area</label>
                        <input type="number" class="form-control" name="carpet_area" value="{{ isset($details->carpet_area) && $details->carpet_area ? $details->carpet_area : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Car Parking</label>
                        <input type="text" class="form-control" name="car_parking" value="{{ isset($details->car_parking) && $details->car_parking ? $details->car_parking : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Furnishing Status</label>
                        <input type="text" class="form-control" name="furnishing_status" value="{{ isset($details->furnishing_status) && $details->furnishing_status ? $details->furnishing_status : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Positioning Status</label>
                        <input type="text" class="form-control" name="positioning_status" value="{{ isset($details->positioning_status) && $details->positioning_status ? $details->positioning_status : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Avalible From</label>
                        <input type="text" class="form-control datepicker3" name="avalible_from" value="{{ isset($details->avalible_from) && $details->avalible_from ? $details->avalible_from : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Address Visible</label>
                        <input type="text" class="form-control" name="is_address_visible" value="{{ isset($details->is_address_visible) && $details->is_address_visible == 1 ? 'Yes' : 'No' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Phone Visible</label>
                          <input type="text" class="form-control" name="is_phone_visible" value="{{ isset($details->is_phone_visible) && $details->is_phone_visible == 1 ? 'Yes' : 'No' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                          <label>Email Visible</label>
                          <input type="text" class="form-control" name="is_email_visible" value="{{ isset($details->is_email_visible) && $details->is_email_visible == 1 ? 'Yes' : 'No' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Admin Aprove</label>
                        <input type="text" class="form-control" name="is_admin_aproved" value="{{ isset($details->is_admin_aproved) && $details->is_admin_aproved == 1 ? 'Yes' : 'No' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Last Update</label>
                        <input type="text" class="form-control" name="updated_at" value="{{ isset($details->updated_at) && $details->updated_at ? $details->updated_at : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- select -->
                      <div class="form-group">
                        <label>Select</label>
                        <input type="text" class="form-control" name="status" value="{{ isset($details->status) && $details->status == 1 ? 'Active' : 'In-Active' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description" value="{{ isset($details->description) && $details->description ? $details->description : '' }}" disabled="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Note</label>
                        <input type="text" class="form-control" name="note" value="{{ isset($details->note) && $details->note ? $details->note : '' }}" disabled="">
                      </div>
                    </div> 
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Video URL</label>
                        <input type="text" class="form-control" name="video_url" value="{{ isset($details->video_url) && $details->video_url ? $details->video_url : '' }}" disabled="">
                      </div>
                    </div>                    
                  </div>
                </div>
                <!-- /.card-body -->
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
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h4 class="card-title">Images</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <?php
                  if(isset($details->property_image) && $details->property_image){
                  ?>
                  <div class="col-sm-2" style="padding-bottom: 10px; text-align: center;">
                    <a href="{{ url($details->property_image) }}" data-toggle="lightbox" data-title="Default" data-gallery="gallery">
                      <img src="{{ url($details->property_image) }}" class="img-fluid mb-2" alt="Default"/>
                    </a>
                  </div>
                  <?php
                  }
                  ?>
                  <?php
                  if($property_images){
                     foreach ($property_images as $key => $value) {
                     ?>
                     <div class="col-sm-2" style="padding-bottom: 10px; text-align: center;">
                        <a href="{{ url($value->property_image) }}" data-toggle="lightbox" data-title="{{ $value->image_title }}" data-gallery="gallery">
                          <img src="{{ url($value->property_image) }}" class="img-fluid mb-2" alt="{{ $value->image_title }}"/>
                        </a>
                        @if($details->is_booked == 0)
                        <a href="{{ url($metadata['delete_image'].'/'.$value->id) }}" class="btn btn-danger btn-sm delete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        @endif
                      </div>
                     <?php
                     }
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Food Info</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Description</th>
                      <th>View</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(isset($food_data) && $food_data)
                    @foreach ( $food_data as $key => $res )
                    <tr> 
                      <td>{{ $res->title }}</td>
                      <td>{{ $res->description }}</td>
                      <td>
                        <a href="{{ url($res->food_info_file) }}" target="_blank" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Details">
                          <i class="fas fa-eye" aria-hidden="true"></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  @else
                    <tr> 
                      <td colspan="4">No record found.</td>
                    </tr>
                  @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Request For Call Back</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Create Date & Time</th>
                      <th>Update Date & Time</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(isset($call_back) && $call_back)
                    @foreach ( $call_back as $key => $res )
                    <tr> 
                      <td>{{ $res->name }}</td>
                      <td>{{ $res->phone }}</td>
                      <td>{{ date('d/m/Y h:i A', strtotime($res->created_at)) }}</td>
                      <td>{{ date('d/m/Y h:i A', strtotime($res->updated_at)) }}</td>
                    </tr>
                    @endforeach
                  @else
                    <tr> 
                      <td colspan="4">No record found.</td>
                    </tr>
                  @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Request For Visit</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Create Date & Time</th>
                      <th>Update Date & Time</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(isset($request_visit) && $request_visit)
                    @foreach ( $request_visit as $key => $res )
                    <tr> 
                      <td>{{ $res->name }}</td>
                      <td>{{ $res->phone }}</td>
                      <td>{{ date('d/m/Y h:i A', strtotime($res->created_at)) }}</td>
                      <td>{{ date('d/m/Y h:i A', strtotime($res->updated_at)) }}</td>
                    </tr>
                    @endforeach
                  @else
                    <tr> 
                      <td colspan="4">No record found.</td>
                    </tr>
                  @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
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


    $(".delete").on("click", function(e) {
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

    $('#dataForm').validate({
      rules: {
          title: {
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
});
</script>
@endsection
