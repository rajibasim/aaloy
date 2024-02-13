@extends('web.layouts.app')

@section('content')
    <!-- Home banner -->
    <section class="secHomeBanner">
        <div class="bxSearchBanner">           
            <section class="secHomebannercontents">
                <div class="container">
                    <div class="titleHoemBanner">Find a home you'll <span>Love</span></div>
                    <div class="listHoemBanner">
                        <ul>
                            <li>Buy</li>
                            <li>Rent</li>
                            <li>PG</li>
                            <li>Plot</li>
                            <li>Commercial</li>
                            <li>Post Ad</li>
                        </ul>
                    </div>
                    <div class="searchboxHoemBanner">
                        <div class="searchFormAddress">
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                            <input type="text" placeholder="enter city, location" />
                        </div>
                        <div class="searchFormItem">
                            <span><i class="fa fa-home" aria-hidden="true"></i></span>
                            <input type="text" placeholder="flat +1" />
                        </div>
                        <div class="searchFormBudget">
                            <span><i class="fa fa-inr" aria-hidden="true"></i></span>
                            <select>
                                <option>1 LAKH</option>
                                <option>2 LAKH</option>
                                <option>3 LAKH</option>
                            </select>
                        </div>
                        <div class="searchFormButton">
                            <span><i class="fa fa-search" aria-hidden="true"></i></span>
                            <button>Search</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="bxHomeBanner">     
            <div class="opacityHomeBanner"></div>
            <div class="slider-HomeCarousel">
                <div class="slide-item">
                    <div class="inner-slide-item">
                        <div class="desktop-slide-img">
                            <img src="{{ asset('public/frontend/images/banner-1.jpg') }}" />
                        </div>
                        <div class="mobile-slide-img">
                            <img src="{{ asset('public/frontend/images/watch-video.jpg') }}" />
                        </div>
                    </div>
                </div>
                <div class="slide-item">
                    <div class="inner-slide-item">
                        <div class="desktop-slide-img">
                            <img src="{{ asset('public/frontend/images/banner-1.jpg') }}" />
                        </div>
                        <div class="mobile-slide-img">
                            <img src="{{ asset('public/frontend/images/watch-video.jpg') }}" />
                        </div>
                    </div>
                </div>
                <div class="slide-item">
                    <div class="inner-slide-item">
                        <div class="desktop-slide-img">
                            <img src="{{ asset('public/frontend/images/banner-1.jpg') }}" />
                        </div>
                        <div class="mobile-slide-img">
                            <img src="{{ asset('public/frontend/images/watch-video.jpg') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </section>
    <!-- sec-searchlocations -->
    <section class="sec-searchlocations">
        <div class="container">
            <div class="titleSearchBylocations">Search by location</div>
            <div class="sliderSBLocations">
                <div class="slider-searchLocationCarousel">
                    <div class="slide-item">
                        <div class="bannerItemLocations">
                            <div class="location-name">
                                <div class="location-big-text">Jadavpur</div>
                                <div class="location-small-text">Lorem Ipsum is simply dummy text of the printing</div>
                            </div>
                            <div class="location-distance">1224 km</div>
                            <div class="location-rank">56</div>
                            <div class="location-more">more 
                                <span>
                                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemLocations">
                            <div class="location-name">                                
                                <div class="location-big-text">Jadavpur</div>
                                <div class="location-small-text">Lorem Ipsum is simply dummy text of the printing</div>
                            </div>
                            <div class="location-distance">1224 km</div>
                            <div class="location-rank">56</div>
                            <div class="location-more">more 
                                <span>
                                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemLocations">
                            <div class="location-name">                                
                                <div class="location-big-text">Jadavpur</div>
                                <div class="location-small-text">Lorem Ipsum is simply dummy text of the printing</div>
                            </div>
                            <div class="location-distance">1224 km</div>
                            <div class="location-rank">56</div>
                            <div class="location-more">more 
                                <span>
                                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemLocations">
                            <div class="location-name">                                
                                <div class="location-big-text">Jadavpur</div>
                                <div class="location-small-text">Lorem Ipsum is simply dummy text of the printing</div>
                            </div>
                            <div class="location-distance">1224 km</div>
                            <div class="location-rank">56</div>
                            <div class="location-more">more 
                                <span>
                                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemLocations">
                            <div class="location-name">                                
                                <div class="location-big-text">Jadavpur</div>
                                <div class="location-small-text">Lorem Ipsum is simply dummy text of the printing</div>
                            </div>
                            <div class="location-distance">1224 km</div>
                            <div class="location-rank">56</div>
                            <div class="location-more">more 
                                <span>
                                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemLocations">
                            <div class="location-name">                                
                                <div class="location-big-text">Jadavpur</div>
                                <div class="location-small-text">Lorem Ipsum is simply dummy text of the printing</div>
                            </div>
                            <div class="location-distance">1224 km</div>
                            <div class="location-rank">56</div>
                            <div class="location-more">more 
                                <span>
                                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Watch video -->    
    <section class="sec-HomeWatchVideo">
        <div class="container">
            <div class="bxHomeWatchVideo">
                <div class="titleVideo">Unknown Printer</div>
                <div class="contentvideo">Lorem ipsum dummy text here</div>
                <div class="btnHomeVideo">
                    <a href="#">Watch Add now</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Popular properties -->
    <section class="sec-HomePWProperties">
        <div class="container">
            <div class="titleHomePage">Popular owner Properties</div>
            <div class="sliderPWProperties">
                <div class="slider-PopularLocationCarousel">
                    <div class="slide-item">
                        <div class="bannerItemPWProperties">
                            <div class="bxImgPWProperties">
                                <div class="bxImgPWD">
                                    <img src={{ asset('public/frontend/images/pro-1.jpg') }} />
                                    <div class="likeImgPWD"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                    <div class="location-rank">New</div>
                                    <div class="NOImgPWD"><i class="fa fa-camera" aria-hidden="true"></i> <span>11</span></div>
                                </div>
                            </div>
                            <div class="bxContentPWProperties">
                                <div class="titleContentPWP"><strong>Jadavpur (89),</strong> 108 Km</div>
                                <div class="PTContentPWP">2 BHK/1 Bathroom</div>
                                <div class="PVContentPWP"><strong>45,000 | 1800 sqft</strong></div>
                                <div class="BNContentPWP"><strong>Book now : 2,999</strong></div>
                                <div class="PBContentPWP">Book now : 2,999</div>
                                <div class="bxBtnsContentPWP">
                                    <div class="btnBookNow">
                                        <a href="#">Book now</a>
                                    </div>
                                    <div class="btnCallBack">
                                        <a href="#">Call Back</a>
                                    </div>
                                    <div class="btnRequestForVisit">
                                        <a href="#" class="active">Request for visit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemPWProperties">
                            <div class="bxImgPWProperties">
                                <div class="bxImgPWD">
                                    <img src={{ asset('public/frontend/images/pro-1.jpg') }} />
                                    <div class="likeImgPWD"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                    <div class="location-rank">New</div>
                                    <div class="NOImgPWD"><i class="fa fa-camera" aria-hidden="true"></i> <span>11</span></div>
                                </div>
                            </div>
                            <div class="bxContentPWProperties">
                                <div class="titleContentPWP"><strong>Jadavpur (89),</strong> 108 Km</div>
                                <div class="PTContentPWP">2 BHK/1 Bathroom</div>
                                <div class="PVContentPWP"><strong>45,000 | 1800 sqft</strong></div>
                                <div class="BNContentPWP"><strong>Book now : 2,999</strong></div>
                                <div class="PBContentPWP">Book now : 2,999</div>
                                <div class="bxBtnsContentPWP">
                                    <div class="btnBookNow">
                                        <a href="#">Book now</a>
                                    </div>
                                    <div class="btnCallBack">
                                        <a href="#">Call Back</a>
                                    </div>
                                    <div class="btnRequestForVisit">
                                        <a href="#" class="active">Request for visit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemPWProperties">
                            <div class="bxImgPWProperties">
                                <div class="bxImgPWD">
                                    <img src={{ asset('public/frontend/images/pro-1.jpg') }} />
                                    <div class="likeImgPWD"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                    <div class="location-rank">New</div>
                                    <div class="NOImgPWD"><i class="fa fa-camera" aria-hidden="true"></i> <span>11</span></div>
                                </div>
                            </div>
                            <div class="bxContentPWProperties">
                                <div class="titleContentPWP"><strong>Jadavpur (89),</strong> 108 Km</div>
                                <div class="PTContentPWP">2 BHK/1 Bathroom</div>
                                <div class="PVContentPWP"><strong>45,000 | 1800 sqft</strong></div>
                                <div class="BNContentPWP"><strong>Book now : 2,999</strong></div>
                                <div class="PBContentPWP">Book now : 2,999</div>
                                <div class="bxBtnsContentPWP">
                                    <div class="btnBookNow">
                                        <a href="#">Book now</a>
                                    </div>
                                    <div class="btnCallBack">
                                        <a href="#">Call Back</a>
                                    </div>
                                    <div class="btnRequestForVisit">
                                        <a href="#" class="active">Request for visit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemPWProperties">
                            <div class="bxImgPWProperties">
                                <div class="bxImgPWD">
                                    <img src={{ asset('public/frontend/images/pro-1.jpg') }} />
                                    <div class="likeImgPWD"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                    <div class="location-rank">New</div>
                                    <div class="NOImgPWD"><i class="fa fa-camera" aria-hidden="true"></i> <span>11</span></div>
                                </div>
                            </div>
                            <div class="bxContentPWProperties">
                                <div class="titleContentPWP"><strong>Jadavpur (89),</strong> 108 Km</div>
                                <div class="PTContentPWP">2 BHK/1 Bathroom</div>
                                <div class="PVContentPWP"><strong>45,000 | 1800 sqft</strong></div>
                                <div class="BNContentPWP"><strong>Book now : 2,999</strong></div>
                                <div class="PBContentPWP">Book now : 2,999</div>
                                <div class="bxBtnsContentPWP">
                                    <div class="btnBookNow">
                                        <a href="#">Book now</a>
                                    </div>
                                    <div class="btnCallBack">
                                        <a href="#">Call Back</a>
                                    </div>
                                    <div class="btnRequestForVisit">
                                        <a href="#" class="active">Request for visit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemPWProperties">
                            <div class="bxImgPWProperties">
                                <div class="bxImgPWD">
                                    <img src={{ asset('public/frontend/images/pro-1.jpg') }} />
                                    <div class="likeImgPWD"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                    <div class="location-rank">New</div>
                                    <div class="NOImgPWD"><i class="fa fa-camera" aria-hidden="true"></i> <span>11</span></div>
                                </div>
                            </div>
                            <div class="bxContentPWProperties">
                                <div class="titleContentPWP"><strong>Jadavpur (89),</strong> 108 Km</div>
                                <div class="PTContentPWP">2 BHK/1 Bathroom</div>
                                <div class="PVContentPWP"><strong>45,000 | 1800 sqft</strong></div>
                                <div class="BNContentPWP"><strong>Book now : 2,999</strong></div>
                                <div class="PBContentPWP">Book now : 2,999</div>
                                <div class="bxBtnsContentPWP">
                                    <div class="btnBookNow">
                                        <a href="#">Book now</a>
                                    </div>
                                    <div class="btnCallBack">
                                        <a href="#">Call Back</a>
                                    </div>
                                    <div class="btnRequestForVisit">
                                        <a href="#" class="active">Request for visit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemPWProperties">
                            <div class="bxImgPWProperties">
                                <div class="bxImgPWD">
                                    <img src={{ asset('public/frontend/images/pro-1.jpg') }} />
                                    <div class="likeImgPWD"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                    <div class="location-rank">New</div>
                                    <div class="NOImgPWD"><i class="fa fa-camera" aria-hidden="true"></i> <span>11</span></div>
                                </div>
                            </div>
                            <div class="bxContentPWProperties">
                                <div class="titleContentPWP"><strong>Jadavpur (89),</strong> 108 Km</div>
                                <div class="PTContentPWP">2 BHK/1 Bathroom</div>
                                <div class="PVContentPWP"><strong>45,000 | 1800 sqft</strong></div>
                                <div class="BNContentPWP"><strong>Book now : 2,999</strong></div>
                                <div class="PBContentPWP">Book now : 2,999</div>
                                <div class="bxBtnsContentPWP">
                                    <div class="btnBookNow">
                                        <a href="#">Book now</a>
                                    </div>
                                    <div class="btnCallBack">
                                        <a href="#">Call Back</a>
                                    </div>
                                    <div class="btnRequestForVisit">
                                        <a href="#" class="active">Request for visit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemPWProperties">
                            <div class="bxImgPWProperties">
                                <div class="bxImgPWD">
                                    <img src={{ asset('public/frontend/images/pro-1.jpg') }} />
                                    <div class="likeImgPWD"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                    <div class="location-rank">New</div>
                                    <div class="NOImgPWD"><i class="fa fa-camera" aria-hidden="true"></i> <span>11</span></div>
                                </div>
                            </div>
                            <div class="bxContentPWProperties">
                                <div class="titleContentPWP"><strong>Jadavpur (89),</strong> 108 Km</div>
                                <div class="PTContentPWP">2 BHK/1 Bathroom</div>
                                <div class="PVContentPWP"><strong>45,000 | 1800 sqft</strong></div>
                                <div class="BNContentPWP"><strong>Book now : 2,999</strong></div>
                                <div class="PBContentPWP">Book now : 2,999</div>
                                <div class="bxBtnsContentPWP">
                                    <div class="btnBookNow">
                                        <a href="#">Book now</a>
                                    </div>
                                    <div class="btnCallBack">
                                        <a href="#">Call Back</a>
                                    </div>
                                    <div class="btnRequestForVisit">
                                        <a href="#" class="active">Request for visit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Property services -->
    <section class="sec-homeService">
        <div class="container">
            <div class="titleHomePage">Property Services</div>
            <div class="bxPropertyServices">
                <ul>
                   <li> 
                        <a href="{{ url('page/sweet-home') }}">
                            <div class="icon"><i class="fa fa-home" aria-hidden="true"></i></div>
                            <div class="SweetHome">Sweet Home</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('page/best-service') }}">
                            <div class="icon"><i class="fa fa-cube" aria-hidden="true"></i></div>
                            <div class="SweetHome">Best Service</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('page/secure-payment') }}">
                            <div class="icon"><i class="fa fa-credit-card" aria-hidden="true"></i></div>
                            <div class="SweetHome">Secure Payment</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('page/why-we-best') }}">
                            <div class="icon"><i class="fa fa-dot-circle-o" aria-hidden="true"></i></div>
                            <div class="SweetHome">Why we best</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Best properties -->
    <section class="sec-BestProperties">
        <div class="container">
            <div class="titleHomePage">Best Properties</div>
            <div class="sliderPWProperties">
                <div class="slider-BestPropertiesCarousel">
                    <div class="slide-item">
                        <div class="bannerItemPWProperties">
                            <div class="bxImgPWProperties">
                                <div class="bxImgPWD">
                                    <img src={{ asset('public/frontend/images/pro-1.jpg') }} />
                                    <div class="likeImgPWD"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                    <div class="location-rank">New</div>
                                    <div class="NOImgPWD"><i class="fa fa-camera" aria-hidden="true"></i> <span>11</span></div>
                                </div>
                            </div>
                            <div class="bxContentPWProperties">
                                <div class="PTContentPWP">2 BHK/1 Bathroom</div>
                                <div class="PVContentPWP"><strong>45,000 | 1800 sqft</strong></div>
                                <div class="BNContentPWP"><strong>Book now : 2,999</strong></div>
                                <div class="contentBestProperties">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                </div>
                            </div>
                            <div class="bxBtnViewDetails">
                                <a href="#">View Details</a>                                    
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemPWProperties">
                            <div class="bxImgPWProperties">
                                <div class="bxImgPWD">
                                    <img src={{ asset('public/frontend/images/pro-1.jpg') }} />
                                    <div class="likeImgPWD"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                    <div class="location-rank">New</div>
                                    <div class="NOImgPWD"><i class="fa fa-camera" aria-hidden="true"></i> <span>11</span></div>
                                </div>
                            </div>
                            <div class="bxContentPWProperties">
                                <div class="PTContentPWP">2 BHK/1 Bathroom</div>
                                <div class="PVContentPWP"><strong>45,000 | 1800 sqft</strong></div>
                                <div class="BNContentPWP"><strong>Book now : 2,999</strong></div>
                                <div class="contentBestProperties">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                </div>
                            </div>
                            <div class="bxBtnViewDetails">
                                <a href="#">View Details</a>                                    
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemPWProperties">
                            <div class="bxImgPWProperties">
                                <div class="bxImgPWD">
                                    <img src={{ asset('public/frontend/images/pro-1.jpg') }} />
                                    <div class="likeImgPWD"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                    <div class="location-rank">New</div>
                                    <div class="NOImgPWD"><i class="fa fa-camera" aria-hidden="true"></i> <span>11</span></div>
                                </div>
                            </div>
                            <div class="bxContentPWProperties">
                                <div class="PTContentPWP">2 BHK/1 Bathroom</div>
                                <div class="PVContentPWP"><strong>45,000 | 1800 sqft</strong></div>
                                <div class="BNContentPWP"><strong>Book now : 2,999</strong></div>
                                <div class="contentBestProperties">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                </div>
                            </div>
                            <div class="bxBtnViewDetails">
                                <a href="#">View Details</a>                                    
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemPWProperties">
                            <div class="bxImgPWProperties">
                                <div class="bxImgPWD">
                                    <img src={{ asset('public/frontend/images/pro-1.jpg') }} />
                                    <div class="likeImgPWD"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                    <div class="location-rank">New</div>
                                    <div class="NOImgPWD"><i class="fa fa-camera" aria-hidden="true"></i> <span>11</span></div>
                                </div>
                            </div>
                            <div class="bxContentPWProperties">
                                <div class="PTContentPWP">2 BHK/1 Bathroom</div>
                                <div class="PVContentPWP"><strong>45,000 | 1800 sqft</strong></div>
                                <div class="BNContentPWP"><strong>Book now : 2,999</strong></div>
                                <div class="contentBestProperties">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                </div>
                            </div>
                            <div class="bxBtnViewDetails">
                                <a href="#">View Details</a>                                    
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemPWProperties">
                            <div class="bxImgPWProperties">
                                <div class="bxImgPWD">
                                    <img src={{ asset('public/frontend/images/pro-1.jpg') }} />
                                    <div class="likeImgPWD"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                    <div class="location-rank">New</div>
                                    <div class="NOImgPWD"><i class="fa fa-camera" aria-hidden="true"></i> <span>11</span></div>
                                </div>
                            </div>
                            <div class="bxContentPWProperties">
                                <div class="PTContentPWP">2 BHK/1 Bathroom</div>
                                <div class="PVContentPWP"><strong>45,000 | 1800 sqft</strong></div>
                                <div class="BNContentPWP"><strong>Book now : 2,999</strong></div>
                                <div class="contentBestProperties">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                </div>
                            </div>
                            <div class="bxBtnViewDetails">
                                <a href="#">View Details</a>                                    
                            </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="bannerItemPWProperties">
                            <div class="bxImgPWProperties">
                                <div class="bxImgPWD">
                                    <img src={{ asset('public/frontend/images/pro-1.jpg') }} />
                                    <div class="likeImgPWD"><i class="fa fa-heart" aria-hidden="true"></i></div>
                                    <div class="location-rank">New</div>
                                    <div class="NOImgPWD"><i class="fa fa-camera" aria-hidden="true"></i> <span>11</span></div>
                                </div>
                            </div>
                            <div class="bxContentPWProperties">
                                <div class="PTContentPWP">2 BHK/1 Bathroom</div>
                                <div class="PVContentPWP"><strong>45,000 | 1800 sqft</strong></div>
                                <div class="BNContentPWP"><strong>Book now : 2,999</strong></div>
                                <div class="contentBestProperties">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                </div>
                            </div>
                            <div class="bxBtnViewDetails">
                                <a href="#">View Details</a>                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer --> 
@endsection
@section('javascripts')

@endsection