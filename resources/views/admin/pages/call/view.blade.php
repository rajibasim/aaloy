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
                    <div class="col-3">
                      <input type="text" class="form-control datepicker3" placeholder="Start Date" name="start_date" value="{{ isset($serach_data['start_date']) && $serach_data['start_date'] ? $serach_data['start_date'] : '' }}">
                    </div>
                    <div class="col-3">
                      <input type="text" class="form-control datepicker3" placeholder="End Date" name="end_date" value="{{ isset($serach_data['end_date']) && $serach_data['end_date'] ? $serach_data['end_date'] : '' }}">
                    </div>
                    <div class="col-3">
                      <select class="form-control" name="call_status">
                        <option value="">Select Status</option>
                        <option value="1" {{ isset($serach_data['call_status']) && $serach_data['call_status'] == 1 ? 'selected=""' : '' }}>Called</option>
                        <option value="2" {{ isset($serach_data['call_status']) && $serach_data['call_status'] == 2 ? 'selected=""' : '' }}>Cancelled</option>
                        <option value="3" {{ isset($serach_data['call_status']) && $serach_data['call_status'] == 3 ? 'selected=""' : '' }}>No Responce</option>
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
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Property</th>
                      <th>Posted By</th>
                      <th>Property For</th>
                      <th>Date & Time</th>
                      <th>View</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(isset($rows) && $rows)
                    @foreach ( $rows as $key => $res )
                    <tr> 
                      <td>{{ $res->name }}</td>
                      <td>{{ $res->phone }}</td>
                      <td>{{ $res->title }}</td>
                      <td>{{ $res->posted_by_name }}</td>
                      <td>{{ $res->property_for == 1 ? 'Rent' : 'Sell' }}</td>
                      <td>{{ date('d/m/Y h:i A', strtotime($res->created_at)) }}</td>
                      <td style="width: 20px;">
                        <a href="{{ 'property/details/'.encrypt($res->property_id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Details">
                          <i class="fas fa-eye" aria-hidden="true"></i>
                        </a>
                      </td>
                      <td style="width: 200px;">
                        <select id="{{ $res->id }}" class="form-control select2 changeStatus">
                          <option value="0">Please select</option>
                          <option value="1" {{ $res->call_status == 1 ? 'selected=""' : '' }}>Called</option>
                          <option value="2" {{ $res->call_status == 2 ? 'selected=""' : '' }}>Cancelled</option>
                          <option value="3" {{ $res->call_status == 3 ? 'selected=""' : '' }}>No Responce</option>
                        </select>
                      </td>
                    </tr>
                    @endforeach
                  @else
                    <tr> 
                      <td colspan="3">No record found.</td>
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

    $(".changeStatus").on("change", function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        var value = $(this).val();
        Swal.fire({
          title: 'Are you sure you want to change this?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, do it!'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = 'call-back-request/change-status?id='+id+'&value='+value;
          }
        })
    });
});
</script>
@endsection
