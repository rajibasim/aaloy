<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} || {{ $metadata['page_title'] }}</title>
    <meta name="title" content="{{ $metadata['page_title'] }}">
    <meta name="description" content="{{ $metadata['seo_description'] }}" />
    <meta name="keywords" content="{{ $metadata['seo_keyword'] }}" />
    <meta name="application-name" content="http://localhost" />
    <meta name="copyright" content="©️ 2023 aaloy.com. All rights reserved." />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link href="{{ asset('public/frontend/assets/css/home.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/frontend/assets/css/header.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/loader.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.5/js.cookie.min.js"></script>
    <script type="text/javascript">
        var base_url = "{{ url('/') }}";
    </script>
    @yield('styles')
</head>
<body> 
    <div class="animationload" style="display: none;">
        <div class="osahanloading"></div>
    </div>
    <!-- Header -->
    <header style="display: {{ isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'app' ? 'none;' : '' }}">
        <section class="secheadtop">
            <div class="container">
                <div class="btnstopPostproperty">
                    <div class="btnsheadtop">
                        <ul>
                            <li>
                                @if(Session::has('id'))
                                    <div class="btnlogin" onclick="location.href = base_url+'/my-profile';">
                                        <span>My Profile </span>
                                    </div>
                                @else
                                    <div class="btnlogin" onClick=openLogin()>
                                        <span>Login </span>
                                    </div>
                                @endif
                            </li>
                        </ul>
                    </div> 
                    <div class="postproperty"><span>Post Property</span> <span class="postfree">Free</span></div>
                </div>
            </div>
        </section>    
        <section class="secNav">            
            <section class="secNavigation">
                <div class="navbar navbar-inverse">
                    <div class="container">
                        <div class="navbar-header">
                            <button class="navbar-toggle" data-target="#mobile_menu" data-toggle="collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                            <a href="#" class="navbar-brand">
                            <div class="logo">
                                <a href="{{ url('/') }}">
                                    <img src="{{ asset('public/frontend/images/AALOY-logo.png') }}" alt="" />                    
                                </a>
                            </div>
                            </a>
                        </div>
                        <div class="navbar-collapse collapse" id="mobile_menu">                            
                            <div class="close-main-nav" onclick="mobileOpenNavBar()">
                                <!-- -->
                            </div>
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="{{ url('/') }}">Home</a></li>
                                <li><a href="{{ url('property') }}">Property </a></li>
                                <li><a href="{{ url('page/about-us') }}">About us</a></li>
                                <li><a href="{{ url('blogs') }}">Blog</a></li>
                                <li><a href="{{ url('page/contact-us') }}">Contact us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </header>  

    @yield('content')     
       
    <footer style="display: {{ isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'app' ? 'none;' : '' }}">
        <div class="container">
            <div class="footer-about-propertieslink">
                <div class="aboutcontent">
                    <h4>About us</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                    <aside class="asi-social-download-app">
                        <div class="btns-download-app">
                            <ul>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('public/frontend/images/logo-google-play.png') }}" />
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('public/frontend/images/logo-app-store.png') }}" />
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="social-btns">
                            <ul>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('public/frontend/images/icon-twitter.png') }}" />
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('public/frontend/images/icon-linkedin.png') }}" />
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('public/frontend/images/icon-youtube.png') }}" />
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('public/frontend/images/icon-instagram.png') }}" />
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('public/frontend/images/icon-facebook.png') }}" />
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </aside>
                </div>
                <div class="propertieslink">
                    <div class="content-projects-india">
                        <h4>Properties in india</h4>
                        <div>
                            <a href="#">Lorem Ipsum</a>
                            <a href="#">is simply dummy text</a>
                            <a href="#">of the printing and</a>
                            <a href="#">typesetting industry</a>
                            <a href="#">standard dummy text ever</a>
                            <a href="#">when an unknown printer</a>
                        </div>
                    </div>
                    <div class="content-projects-india content-new-projects-india">
                        <h4>Properties in india</h4>
                        <div>
                            <a href="#">Lorem Ipsum</a>
                            <a href="#">is simply dummy text</a>
                            <a href="#">of the printing and</a>
                            <a href="#">typesetting industry</a>
                            <a href="#">standard dummy text ever</a>
                            <a href="#">when an unknown printer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="sec-footer-links">
            <div class="container">
                <ul>
                    <li><a href="#">Sitemap</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Testimonials</a></li>
                    <li><a href="#">Feedback</a></li>
                    <li><a href="#">Unsubscribe</a></li>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Sales Enquiry</a></li>
                    <li><a href="#">Buy our Services</a></li>
                </ul>
            </div>
        </section>
        <section class="sec-desclaimer">
            <div class="container">
                <p>Desclaimer: It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now</p>
            </div>
        </section>
        <section class="sec-copyright">
            <div class="container">
                <p>will be distracted by the readable content of a page <a href="#">when looking</a></p>
            </div>
        </section>
    </footer>
    <!-- Login popup -->
    <section class="sec-loginpopup" id="secLoginpopup" style="display: {{ Session::has('id') ? 'none' : 'block' }};">
        <div class="opacity-loginpopup"></div>
        <div class="bx-popup">
            <div class="title-popup">
                <div class="bigtitle">Login</div>
                <div class="titleDetails errormsg"></div>
                <div class="titleDetails successmsg"></div>
            </div>
            <div class="content-popup">
                <div class="form-content-popup">
                    <form id="signin" method="post" autocomplete="off">
                        <input type="hidden" name="divice_type" id="divice_type" value="1">
                        <input type="hidden" name="device_id" id="device_id" value="1">
                        <div class="input-form-content">
                            <input type="text" name="phone" id="signin_phone" placeholder="Phone" autocomplete="off" />
                        </div>
                        <div class="input-form-content">
                            <input type="password" name="password" id="signin_password" placeholder="Password" autocomplete="off" />
                        </div>
                        <div class="input-form-content">
                            <button type="submit">Sign in</button>
                        </div>
                    </form>
                    <div class="input-form-content account-confirm">
                        <p>Don't have an account? <a href="javascript:void(0)" onClick=openRegister()>Register</a></p>
                        <p>Forgot password? <a href="javascript:void(0)" id="resetPassword">Reset</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>    
    <!-- Register popup -->
    <section class="sec-loginpopup sec-RegisterPopup" id="secRegister" autocomplete="off">
        <div class="opacity-loginpopup"></div>
        <div class="bx-popup">
            <div class="title-popup">
                <div class="bigtitle">Create your account</div>
                <div class="titleDetails errormsg"></div>
            </div>
            <form id="signup" method="post">
                <div class="content-popup">
                    <div class="form-content-popup">
                        <div class="input-form-content">
                            <select name="type" id="signup_type">
                                <option value="1">Broker</option>
                                <option value="2">Owner</option>
                                <option value="3">User</option>
                            </select>
                        </div>
                        <div class="input-form-content">
                            <input type="text" placeholder="Name" name="name" id="signup_name" />
                        </div>
                        <div class="input-form-content">
                            <input type="number" placeholder="Phone" name="phone" id="signup_phone" />
                        </div>
                        <div class="input-form-content">
                            <input type="email" placeholder="Email" name="email" id="signup_email" />
                        </div>
                        <div class="input-form-content">
                            <input type="password" placeholder="Password" name="password" id="signup_password" />
                        </div>
                        <div class="input-form-content">
                            <button type="submit">Sign Up</button>
                        </div>
                        <div class="input-form-content account-confirm">
                            <p>Already have an account? <a href="javascript:void(0)" onClick=openLogin()>Log in</a></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <section class="sec-loginpopup sec-RegisterPopup" id="secVerify">
        <div class="opacity-loginpopup"></div>
        <div class="bx-popup">
            <div class="title-popup">
                <div class="bigtitle">Verify Phone No</div>
                <div class="titleDetails errormsg"></div>
                <div class="titleDetails successmsg"></div>
            </div>
            <form id="verify" method="post" autocomplete="off">
                <input type="hidden" name="veriy_phone" id="veriy_phone" value="">
                <div class="content-popup">
                    <div class="form-content-popup">
                        <div class="input-form-content">
                            <input type="number" placeholder="Verification Code" name="phone_verification_code" id="phone_verification_code" />
                        </div>
                        <div class="input-form-content">
                            <button type="submit">Submit</button>
                        </div>
                        <div class="input-form-content account-confirm">
                            <p>Update your signup details! <a href="javascript:void(0)" id="updatePhone">Click here</a></p>
                            <p>Request for new verication code! <a href="javascript:void(0)" id="resend">Resend</a></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="sec-loginpopup" id="secResetPassword" >
        <div class="opacity-loginpopup"></div>
        <div class="bx-popup">
            <div class="title-popup">
                <div class="bigtitle">Reset Password</div>
                <div class="titleDetails errormsg"></div>
                <div class="titleDetails successmsg"></div>
            </div>
            <div class="content-popup">
                <div class="form-content-popup">
                    <form id="resetpwd" method="post" autocomplete="off">
                        <div class="input-form-content">
                            <input type="text" name="phone" id="rest_phone" placeholder="Phone" autocomplete="off" />
                        </div>
                        <div class="input-form-content">
                            <button type="submit">Reset</button>
                        </div>
                    </form>
                    <div class="input-form-content account-confirm">
                        <p>Already have an account? <a href="javascript:void(0)" onClick=openLogin()>Log in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- scroll -->
    <div id="scroll" style="display: none;"><span></span></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('public/frontend/assets/js/script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <script src="{{ asset('public/frontend/assets/js/common.js') }}"></script>
    @yield('javascripts')
</body>
</html>