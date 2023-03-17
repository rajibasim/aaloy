<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ env('APP_NAME') }} || Login</title>
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('public/assets/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('public/assets/css/adminlte.min.css') }}">
         <!-- Toastr -->
        <link rel="stylesheet" href="{{ asset('public/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css?version='.config('app.version')) }}">
        <link rel="stylesheet" href="{{ asset('public/assets/plugins/toastr/toastr.min.css?version='.config('app.version')) }}">
        <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
   </head>
   </head>
   <body class="hold-transition login-page">
      <div class="login-box" id="app">
         <!-- /.login-logo -->
         <div class="card card-outline card-primary">
            <div class="card-header text-center">
               <a href="admin-login" class="h1">
                  <b>{{ env('APP_NAME') }}</b> System
               </a>
            </div>
            <div class="card-body">
               <p class="login-box-msg">Department of Agriculture and Farmer's Affairs, Govt. of Tripura</p>
               <form id="login-form" action=" {{url('admin-post-login')}}" method="post">
                  @csrf
                 <!--  <div class="input-group mb-3">
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-user"></span>
                        </div>
                     </div>
                     <select class="form-control" name="user_type" id="user_type">
                        <option value="1" selected="">Super Admin</option>
                        <option value="2">District Store</option>
                        <option value="3">Main Store</option>
                     </select>
                  </div> -->
                  <div class="input-group mb-3">
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-envelope"></span>
                        </div>
                     </div>
                     <input type="email" class="form-control" placeholder="E-mail address" id="admin_user_name" name="admin_user_name" />
                  </div>
                  <div class="input-group mb-3">
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-lock"></span>
                        </div>
                     </div>
                     <input type="password" class="form-control" placeholder="Password" id="admin_password" name="admin_password" required />
                  </div>
                  <div class="row">
                     <div class="col-8">
                        <div class="icheck-primary">
                           <input class="form-check-input" type="checkbox" name="remember" id="remember">
                           <label for="remember">
                           Remember Me
                           </label>
                        </div>
                     </div>
                     <!-- /.col -->
                     <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Login') }}
                        </button>
                     </div>
                     <!-- /.col -->
                  </div>
               </form>
               <!-- /.social-auth-links -->
            </div>
            <!-- /.card-body -->
         </div>
         <!-- /.card -->
      </div>
      <!-- /.login-box -->
      <!-- jQuery -->
      <script src="{{ asset('public/assets/plugins/jquery/jquery.min.js') }}"></script>
      <!-- Bootstrap 4 -->
      <script src="{{ asset('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <!-- SweetAlert2 -->
      <script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js?version='.config('app.version')) }}"></script>
      <!-- Toastr -->
      <script src="{{ asset('public/assets/plugins/toastr/toastr.min.js?version='.config('app.version')) }}"></script>
      <!-- AdminLTE App -->
      <script src="{{ asset('public/assets/js/adminlte.min.js') }}"></script>
      <script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
      <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

            $('#login-form').validate({
              rules: {
                  admin_user_name: {
                    required: true,
                    email: true,
                  },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                  error.addClass('invalid-feedback');
                  //element.closest('.form-group').append(error);
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
   </body>
</html>