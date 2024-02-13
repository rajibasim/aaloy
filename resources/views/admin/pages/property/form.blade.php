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
                        <label>Select Image</label>
                        <input type="file" class="form-control" placeholder="Select Image" name="property_image" value="" accept="image/png, image/gif, image/jpeg">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" placeholder="Title" name="title" value="{{ old('title', isset($details->title) && $details->title ? $details->title : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Property For</label>
                        <select class="form-control select2" name="property_for" id="property_for" required="">
                          <option value="1" {{ isset($details->property_for) && $details->property_for == 1 ? 'selected' : '' }}>Rent</option>
                          <option value="2" {{ isset($details->property_for) && $details->property_for == 2 ? 'selected' : '' }}>Sell</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Posted By</label>
                        <select class="form-control select2" name="posted_by" id="posted_by" required="">
                          <option value="">Select One</option>
                          <option value="1" {{ isset($details->posted_by) && $details->posted_by == 1 ? 'selected' : '' }}>Broker</option>
                          <option value="2" {{ isset($details->posted_by) && $details->posted_by == 2 ? 'selected' : '' }}>User</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Posted By(User)</label>
                        <select class="form-control select2" name="posted_by_id" id="posted_by_id" required="">
                          <option value="">Select One</option>
                          <?php
                          if(isset($details->posted_by_id) && $details->posted_by_id){
                              if($users){
                                  foreach ($users as $key => $val) {
                                      if(isset($details->posted_by) && $details->posted_by == $val->type){
                                  ?>
                                     <option value="{{ $val->id }}" {{ isset($details->posted_by_id) && $details->posted_by_id == $val->id ? 'selected' : '' }}>{{ $val->name }}</option>
                                  <?php
                                      }
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
                        <label>Property Type</label>
                        <select class="form-control select2" name="property_type_id" id="property_type_id" required="">
                          <option value="">Select Property Type</option>
                           @if($property_type)
                               @foreach ($property_type as $val)
                                <option value="{{ $val->id }}" {{ isset($details->property_type_id) && $details->property_type_id == $val->id ? 'selected' : '' }}>{{ $val->property_type }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Preferance</label>
                        <select class="form-control select2" name="preferance" id="preferance" required="">
                          <option value="">Select One</option>
                          <option value="1" {{ isset($details->preferance) && $details->preferance == 1 ? 'selected' : '' }}>Bachelor</option>
                          <option value="2" {{ isset($details->preferance) && $details->preferance == 2 ? 'selected' : '' }}>Family</option>
                          <option value="3" {{ isset($details->preferance) && $details->preferance == 3 ? 'selected' : '' }}>No Preferance</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Gender</label>
                        <select class="form-control select2" name="gender" id="gender">
                          <option value="">Select One</option>
                          <option value="1" {{ isset($details->gender) && $details->gender == 1 ? 'selected' : '' }}>Male</option>
                          <option value="2" {{ isset($details->gender) && $details->gender == 2 ? 'selected' : '' }}>Female</option>
                          <option value="3" {{ isset($details->gender) && $details->gender == 3 ? 'selected' : '' }}>Transgender</option>
                          <option value="4" {{ isset($details->gender) && $details->gender == 4 ? 'selected' : '' }}>No Choice</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Location</label>
                        <select class="form-control select2" name="location_id" id="location_id" required="">
                          <option value="">Select Location</option>
                           @if($location)
                               @foreach ($location as $val)
                                <option value="{{ $val->id }}" {{ isset($details->location_id) && $details->location_id == $val->id ? 'selected' : '' }}>{{ $val->location }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" placeholder="Address" name="address" id="address" value="{{ old('address', isset($details->address) && $details->address ? $details->address : '') }}" autocomplete="off" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Latitude</label>
                        <input type="text" class="form-control" placeholder="Enter latitude" id="latitude" name="latitude" value="{{ old('latitude', isset($details->latitude) && $details->latitude ? $details->latitude : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Longitude</label>
                        <input type="text" class="form-control" placeholder="Enter longitude" id="longitude" name="longitude" value="{{ old('longitude', isset($details->longitude) && $details->longitude ? $details->longitude : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Pin Code</label>
                        <input type="text" class="form-control" placeholder="Enter Pin Code" id="postcode" name="pin_code" value="{{ old('pin_code', isset($details->pin_code) && $details->pin_code ? $details->pin_code : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Floor</label>
                        <select class="form-control select2" name="floor_id" id="floor_id" required="">
                          <option value="">Select Floor</option>
                          <?php
                          for ($i=1; $i < 11 ; $i++) { 
                          ?>
                            <option value="{{  $i }}" {{ isset($details->floor) && $details->floor ==  $i ? 'selected' : '' }}>{{  $i }}</option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Out Of Floor</label>
                        <select class="form-control select2" name="out_of_floor_id" id="out_of_floor_id" required="">
                          <option value="">Select Floor</option>
                           <?php
                            for ($i=1; $i < 11 ; $i++) { 
                            ?>
                              <option value="{{  $i }}" {{ isset($details->out_of_floor) && $details->out_of_floor ==  $i ? 'selected' : '' }}>{{  $i }}</option>
                            <?php
                            }
                            ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Room Type</label>
                        <select class="form-control select2" name="no_of_room_id" id="no_of_room_id" required="">
                          <option value="">Select One</option>
                           @if($no_of_room)
                               @foreach ($no_of_room as $val)
                                <option value="{{ $val->id }}" {{ isset($details->no_of_room_id) && $details->no_of_room_id == $val->id ? 'selected' : '' }}>{{ $val->no_of_room }}BHK</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Bathroom</label>
                        <input type="number" class="form-control" placeholder="Bathroom" name="bathroom" value="{{ old('bathroom', isset($details->bathroom) && $details->bathroom ? $details->bathroom : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" placeholder="Price" name="price" value="{{ old('price', isset($details->price) && $details->price ? $details->price : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Booking Price</label>
                        <input type="number" class="form-control" placeholder="Booking Price" name="booking_price" value="{{ old('booking_price', isset($details->booking_price) && $details->booking_price ? $details->booking_price : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Maintenance Charge</label>
                        <input type="number" class="form-control" placeholder="Maintenance Charge" name="maintenance" value="{{ old('maintenance', isset($details->maintenance) && $details->maintenance ? $details->maintenance : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Carpet Area(sqft)</label>
                        <input type="number" class="form-control" placeholder="Carpet Area" name="carpet_area" value="{{ old('carpet_area', isset($details->carpet_area) && $details->carpet_area ? $details->carpet_area : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Car Parking</label>
                        <select class="form-control select2" name="car_parking_id" id="car_parking_id" required="">
                          <option value="">Select One</option>
                           @if($car_parking)
                               @foreach ($car_parking as $val)
                                <option value="{{ $val->id }}" {{ isset($details->car_parking_id) && $details->car_parking_id == $val->id ? 'selected' : '' }}>{{ $val->car_parking }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Furnishing Status</label>
                        <select class="form-control select2" name="furnishing_status_id" id="furnishing_status_id" required="">
                          <option value="">Select One</option>
                           @if($furnishing_status)
                               @foreach ($furnishing_status as $val)
                                <option value="{{ $val->id }}" {{ isset($details->furnishing_status_id) && $details->furnishing_status_id == $val->id ? 'selected' : '' }}>{{ $val->furnishing_status }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Positioning Status</label>
                        <select class="form-control select2" name="positioning_status_id" id="positioning_status_id" required="">
                          <option value="">Select One</option>
                           @if($positioning_status)
                               @foreach ($positioning_status as $val)
                                <option value="{{ $val->id }}" {{ isset($details->positioning_status_id) && $details->positioning_status_id == $val->id ? 'selected' : '' }}>{{ $val->positioning_status }}</option>
                               @endforeach
                            @endif
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Avalible From</label>
                        <input type="text" class="form-control datepicker3" placeholder="Avalible From" name="avalible_from" value="{{ old('avalible_from', isset($details->avalible_from) && $details->avalible_from ? $details->avalible_from : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Address Visible</label>
                        <select class="form-control select2" name="is_address_visible" id="is_address_visible" required="">
                          <option value="0" {{ isset($details->is_address_visible) && $details->is_address_visible == 0 ? 'selected' : '' }}>No</option>
                          <option value="1" {{ isset($details->is_address_visible) && $details->is_address_visible == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Phone Visible</label>
                          <select class="form-control select2" name="is_phone_visible" id="is_phone_visible" required="">
                            <option value="0" {{ isset($details->is_phone_visible) && $details->is_phone_visible == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ isset($details->is_phone_visible) && $details->is_phone_visible == 1 ? 'selected' : '' }}>Yes</option>
                          </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                          <label>Email Visible</label>
                          <select class="form-control select2" name="is_email_visible" id="is_email_visible" required="">
                            <option value="0" {{ isset($details->is_email_visible) && $details->is_email_visible == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ isset($details->is_email_visible) && $details->is_email_visible == 1 ? 'selected' : '' }}>Yes</option>
                          </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Admin Aprove</label>
                        <select class="form-control select2" name="is_admin_aproved" id="is_admin_aproved" required="">
                          <option value="0" {{ isset($details->is_admin_aproved) && $details->is_admin_aproved == 0 ? 'selected' : '' }}>No</option>
                          <option value="1" {{ isset($details->is_admin_aproved) && $details->is_admin_aproved == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
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
                    <div class="col-sm-12" id="avalible_beds" style="display: none;">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Avalible Beds</label>
                        <input type="text" class="form-control" placeholder="Avalible Beds" name="avalible_beds" value="{{ old('avalible_beds', isset($details->avalible_beds) && $details->avalible_beds ? $details->avalible_beds : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" placeholder="Description" name="description" value="{{ old('description', isset($details->description) && $details->description ? $details->description : '') }}" required="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Note</label>
                        <input type="text" class="form-control" placeholder="Note" name="note" value="{{ old('note', isset($details->note) && $details->note ? $details->note : '') }}" >
                      </div>
                    </div>   
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Video URL</label>
                        <input type="text" class="form-control" placeholder="Video URL" name="video_url" value="{{ old('video_url', isset($details->video_url) && $details->video_url ? $details->video_url : '') }}" >
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>SEO Description</label>
                        <textarea class="form-control" id="" name="seo_description">
                          {{ old('seo_description', isset($details->seo_description) && $details->seo_description ? $details->seo_description : '') }}
                        </textarea>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>SEO Keywords</label>
                        <textarea class="form-control" id="" name="seo_keyword">
                          {{ old('seo_keyword', isset($details->seo_keyword) && $details->seo_keyword ? $details->seo_keyword : '') }}
                        </textarea>
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
          subdevision_id: {
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

    $(document).on('change', '#posted_by', function() {
        var posted_by = $(this).val();
        var users = '<?php echo json_encode($users)?>';
        $("#posted_by_id").select2("destroy");
        var html = '<option value="">Select One</option>';
        if(users){
            $.each(JSON.parse(users), function (key, val) {
                if(val.type == posted_by){
                    html = html + '<option value="'+val.id+'">'+val.name+'</option>';
                }
            });
        }

        $("#posted_by_id").html(html);
        $('#posted_by_id').select2({
              theme: 'bootstrap4'
        });
    });

    $(document).on('change', '#property_type_id', function() {
        if($(this).val() == 3) {
            $("#avalible_beds").show();
        }else{
            $("#avalible_beds").hide();
        }
    });
});

let autocomplete;
let address;
let postalField;

function initAutocomplete() {
    address = document.querySelector("#address");
    postalField = document.querySelector("#postcode");
    autocomplete = new google.maps.places.Autocomplete(address, {
        componentRestrictions: {
            country: ["in"]
        },
        fields: ["address_components", "geometry"],
        types: ["address"],
    });
    address.focus();
    autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
    const place = autocomplete.getPlace();
    for (const component of place.address_components) {
        // @ts-ignore remove once typings fixed
        const componentType = component.types[0];

        switch (componentType) {
            case "postal_code": {
                document.querySelector("#postcode").value = `${component.long_name}`;
                break;
            }
        }
    }

    $("#latitude").val(place.geometry.location.lat());
    $("#longitude").val(place.geometry.location.lng());
}

window.initAutocomplete = initAutocomplete;
</script>
@endsection
