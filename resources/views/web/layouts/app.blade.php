<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} || {{ $metadata['page_title'] }}</title>
         <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="%PUBLIC_URL%/manifest.json" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link href="{{ asset('public/frontend/assets/css/home.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/frontend/assets/css/header.css') }}" rel="stylesheet" />
</head>
<body> 
    <!-- Header -->
    <header>
        <section class="secheadtop">
            <div class="container">
                <div class="btnstopPostproperty">
                    <div class="btnsheadtop">
                        <ul>
                            <li>
                                <div class="btnprime">
                                    <span>Prime </span>
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </div>
                            </li>
                            <li>
                                <div class="btnlogin" onClick=openLogin()>
                                    <span>Login </span>
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </div>
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
                                <a href="index.html">
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
                                <li class="active"><a href="index.html">Home</a></li>
                                <li><a href='aboutus.html'>About us</a></li>
                                <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Property <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href='property.html'>Property</a></li>
                                        <li><a href='myproperty.html'>My Property</a></li>
                                        <li><a href='propertydetails.html'>Property Details</a></li>
                                        <li><a href='propertyadd.html'>Property Add</a></li>
                                    </ul>
                                </li>
                                <li><a href='shoppingcart.html'>Shopping Cart</a></li>
                                <li><a href='contactus.html'>Contact us</a></li>
                                <li><a href='thankyou.html'>Thankyou</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </header>  

    @yield('content')     
       
    <footer>
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
    <section class="sec-loginpopup" id="secLoginpopup">
        <div class="opacity-loginpopup"></div>
        <div class="bx-popup">
            <div class="close-btn-popup" onClick=closeLoginPopup()>
                <img src="{{ asset('public/frontend/images/icon-close-gray.png') }}" />
            </div>
            <div class="title-popup">
                <div class="bigtitle">User login</div>
                <div class="titleDetails">Lorem Ipsum is simply dummy text of the printing <br /> and typesetting industry.</div>
            </div>
            <div class="content-popup">
                <div class="form-content-popup">
                    <div class="input-form-content">
                        <input type="text" placeholder="E.g: John Smith" required />
                    </div>
                    <div class="input-form-content">
                        <input type="text" placeholder="E.g: John Smith" required />
                    </div>
                    <div class="input-form-content">
                        <button>Sign in</button>
                    </div>
                    <div class="input-form-content account-confirm">
                        <p>Don't have an account? <a href="javascript:void(0)" onClick=openRegister()>Register</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>    
    <!-- Register popup -->
    <section class="sec-loginpopup sec-RegisterPopup" id="secRegister">
        <div class="opacity-loginpopup"></div>
        <div class="bx-popup">
            <div class="close-btn-popup" onClick=closeRegisterPopup()>
                <img src="{{ asset('public/frontend/images/icon-close-gray.png') }}" />
            </div>
            <div class="title-popup">
                <div class="bigtitle">Create your account</div>
                <div class="titleDetails">Lorem Ipsum is simply dummy text of the printing <br /> and typesetting industry.</div>
            </div>
            <div class="content-popup">
                <div class="form-content-popup">
                    <div class="input-form-content">
                        <input type="text" placeholder="E.g: John Smith" required />
                    </div>
                    <div class="input-form-content">
                        <input type="text" placeholder="E.g: John Smith" required />
                    </div>
                    <div class="input-form-content">
                        <input type="text" placeholder="E.g: John Smith" required />
                    </div>
                    <div class="input-form-content">
                        <input type="text" placeholder="E.g: John Smith" required />
                    </div>
                    <div class="input-form-content">
                        <button>Sign Up</button>
                    </div>
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
    @yield('javascripts')
</body>
</html>