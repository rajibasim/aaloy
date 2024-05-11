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
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $metadata['page_title'] }}</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <div class="col-md-3 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{ $booked_amount[0]->total }}</h3>
                    <p>Booked Amount</p>
                  </div>
                  <a href="{{ url('booking-history') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-md-3 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{ $property[0]->total }}</h3>
                    <p>Property</p>
                  </div>
                  <a href="{{ url('property') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-md-3 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-secondary">
                  <div class="inner">
                    <h3>{{ $aproved_property[0]->total }}</h3>
                    <p>Aproved Property</p>
                  </div>
                  <a href="{{ url('property?is_admin_aproved=1') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-md-3 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{ $non_aproved_property[0]->total }}</h3>
                    <p>Request For Aprove</p>
                  </div>
                  <a href="{{ url('property?is_admin_aproved=2') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <div class="col-md-3 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-primary">
                  <div class="inner">
                    <h3>{{ $visit_request[0]->total }}</h3>
                    <p>Request For Visit</p>
                  </div>
                  <a href="{{ url('visit-request') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-md-3 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{ $call_request[0]->total }}</h3>
                    <p>Request For Call Back</p>
                  </div>
                  <a href="{{ url('call-back-request') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-md-3 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-dark">
                  <div class="inner">
                    <h3>{{ $user[0]->total }}</h3>
                    <p>Total User</p>
                  </div>
                  <a href="{{ url('users/user') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-md-3 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{ $booked_property[0]->total }}</h3>
                    <p>Total Booked</p>
                  </div>
                  <a href="{{ url('property') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('javascripts')

@endsection
