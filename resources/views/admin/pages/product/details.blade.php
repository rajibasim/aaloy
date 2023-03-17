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
             <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                   <div class="card-body box-profile">
                      <h3 class="profile-username text-center"><?=$details->name?></h3>
                      <p class="text-muted text-center">Last Update : <?=$details->updated_at?></p>
                      <ul class="list-group list-group-unbordered mb-3">
                         <li class="list-group-item">
                            <b>Current Stock</b> <a class="float-right"><?=$details->current_stock?><?=$details->unit?></a>
                         </li>
                         <li class="list-group-item">
                            <b>Category</b> <a class="float-right"><?=$details->category?></a>
                         </li>
                         <li class="list-group-item">
                            <b>Brand</b> <a class="float-right"><?=$details->brand?></a>
                         </li>
                      </ul>
                   </div>
                   <!-- /.card-body -->
                </div>
                <!-- /.card -->
             </div>
             <!-- /.col -->
             <div class="col-md-9">
                <div class="card">
                   <div class="card-header p-2">
                      <ul class="nav nav-pills">
                         <li class="nav-item"><a class="nav-link active" href="#transuction" data-toggle="tab">Transuction</a></li>
                         <li class="nav-item"><a class="nav-link" href="#update-stock" data-toggle="tab">Update Stock</a></li>
                      </ul>
                   </div>
                   <!-- /.card-header -->
                   <div class="card-body">
                      <div class="tab-content">
                         <div class="tab-pane active" id="transuction">
                            <!-- Post -->
                            <!-- <form method="get" action="" autocomplete="off" enctype="multipart/form-data">
                              <div class="row">
                                <div class="col-4">
                                  <input type="text" class="form-control" placeholder="Start date" name="start_date" value="{{ isset($serach_data['start_date']) && $serach_data['start_date'] ? $serach_data['start_date'] : '' }}">
                                </div>
                                <div class="col-4">
                                  <input type="text" class="form-control" placeholder="End date" name="end_date" value="{{ isset($serach_data['end_date']) && $serach_data['end_date'] ? $serach_data['end_date'] : '' }}">
                                </div>
                                <div class="col-2">
                                  <button type="submit" class="btn btn-block btn-primary">Search</button>
                                </div>
                                <div class="col-">
                                  <a href="" class="btn btn-block btn-danger">Reset</a>
                                </div>
                              </div>
                            </form> -->
                            <!-- /.card-header -->
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>Sl No</th>
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
                                  <td>{{ $res->entry_date }}</td>
                                  <td>
                                    <?php
                                    if($res->type == 1){
                                        echo "Entry";
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
                                  <td colspan="6">No record found.</td>
                                </tr>
                              @endif
                              </tbody>
                            </table>
                            <!-- /.card-body -->
                            <div class="float-right">
                              @if(isset($rows) && $rows)
                                {!! $rows->appends(Request::all())->links() !!}
                              @endif
                            </div>
                            
                            <!-- /.post -->
                         </div>
                         <!-- /.tab-pane -->
                         <!-- /.tab-pane -->
                         <div class="tab-pane" id="update-stock">
                            <form id="dataForm" method="post" action="{{ url('admin-product/update-stock') }}" autocomplete="off" enctype="multipart/form-data">
                               @csrf
                               <input type="hidden" name="product_id" value="<?=$details->id?>">
                               <input type="hidden" name="session_id" value="{{ Session::has('admin_id') ? Session::get('admin_id') : 0 }}">
                               <div class="form-group row">
                                  <label for="inputName" class="col-sm-2 col-form-label">Date</label>
                                  <div class="col-sm-10">
                                     <input type="text" class="form-control datepicker" id="date" placeholder="Date" name="date">
                                  </div>
                               </div>
                               <div class="form-group row">
                                  <label for="inputEmail" class="col-sm-2 col-form-label">Type</label>
                                  <div class="col-sm-10">
                                      <select class="form-control" name="type" id="type">
                                        <option value="1">Entry</option>
                                        <!-- <option value="2">Distribute</option> -->
                                        <option value="3">Add Adjusment</option>
                                        <option value="4">Substruct Adjusment</option>
                                      </select>
                                  </div>
                               </div>
                               <div class="form-group row">
                                  <label for="quentity" class="col-sm-2 col-form-label">Quentity(kg)</label>
                                  <div class="col-sm-10">
                                     <input type="text" class="form-control" id="quentity" placeholder="Quentity" name="quentity">
                                  </div>
                               </div>
                               <div class="form-group row">
                                  <label for="note" class="col-sm-2 col-form-label">Note</label>
                                  <div class="col-sm-10">
                                     <input type="text" class="form-control" id="note" placeholder="Note" name="note">
                                  </div>
                               </div>
                               <div class="form-group row">
                                  <div class="offset-sm-2 col-sm-10">
                                     <button type="submit" class="btn btn-danger">Submit</button>
                                  </div>
                               </div>
                            </form>
                         </div>
                         <!-- /.tab-pane -->
                      </div>
                      <!-- /.tab-content -->
                   </div>
                   <!-- /.card-body -->
                </div>
                <!-- /.card -->
             </div>
             <!-- /.col -->
          </div>
          <!-- /.row -->
       </div>
       <!-- /.container-fluid -->
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

    @if(Session::has('flash_data')) 
      @php 
        $flash_data = Session::pull('flash_data');
      @endphp
      toastr.{{ $flash_data['status'] }}("{{ $flash_data['message'] }}");
    @endif

    $('#dataForm').validate({
      rules: {
          date: {
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
});
</script>
@endsection
