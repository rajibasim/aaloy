  
jQuery('.slider-HomeCarousel').slick({
    slidesToShow: 1,
    dots: true,
    arrows: false,
    infinite: false,
    slidesToScroll:1,
    autoplay:false,
    speed: 1000,    
    responsive: [
        {
          breakpoint: 1024,
          settings: {
                slidesToShow: 3,
                adaptiveHeight: true,
          }
        },
        {
          breakpoint: 728,
          settings: {
                slidesToShow: 1,
                adaptiveHeight: true,
          }
        }
    ],
    prevArrow: '<button class="slide-arrow slick-prev"><img src="./images/slick-navigate-prev.svg" /></button>',
    nextArrow: '<button class="slide-arrow slick-next"><img src="./images/slick-navigate-next.svg" /></button>'
});
jQuery('.slider-searchLocationCarousel').slick({
    slidesToShow: 5,
    dots: true,
    arrows: false,
    infinite: false,
    autoplay:false,    
    responsive: [
        {
          breakpoint: 1024,
          settings: {
                slidesToShow: 3,
                adaptiveHeight: true,
          }
        },
        {
          breakpoint: 728,
          settings: {
                slidesToShow: 1,
                adaptiveHeight: true,
          }
        }
    ]
});
jQuery('.slider-PopularLocationCarousel').slick({
    slidesToShow: 4,
    dots: true,
    arrows: false,
    infinite: false,
    autoplay:false,    
    responsive: [
        {
          breakpoint: 1024,
          settings: {
                slidesToShow: 3,
                adaptiveHeight: true,
          }
        },
        {
          breakpoint: 728,
          settings: {
                slidesToShow: 1,
                adaptiveHeight: true,
          }
        }
    ]
});
jQuery('.slider-BestPropertiesCarousel').slick({
    slidesToShow: 4,
    dots: true,
    arrows: false,
    infinite: false,
    autoplay:false,
    
    responsive: [
        {
          breakpoint: 1024,
          settings: {
                slidesToShow: 3,
                adaptiveHeight: true,
          }
        },
        {
          breakpoint: 728,
          settings: {
                slidesToShow: 1,
                adaptiveHeight: true,
          }
        }
    ]
});
// Login register ===
const openLogin =()=>{
    $("#secLoginpopup").fadeIn(500);
    $("#secRegister").fadeOut(500);
}
const closeLoginPopup = ()=>{
    $("#secLoginpopup").fadeOut(500);
}
const openRegister = ()=>{        
    $("#secRegister").fadeIn(500);
    $("#secLoginpopup").fadeOut(500);
}
const closeRegisterPopup = ()=>{
    $("#secRegister").fadeOut(500);
}
const mobileOpenNavBar = () =>{
  $("#mobile_menu").removeClass("show");
}