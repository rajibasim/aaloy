  
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
    $("#secResetPassword").fadeOut(500);
}
const openPromoPopup =()=>{
    $("#secPromoPopup").fadeIn(500);
}
const closePromoPopup =()=>{
    $("#secPromoPopup").fadeOut(500);
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
// ======
const show_cahnge_Pass_2 = () => {
  let reg_password_inputType = $('#change_pass_2').attr('type');
  console.log("inputType: " + reg_password_inputType);
  if(reg_password_inputType == "password"){
      $("#change_pass_2").attr('type', 'text'); 
      $("#urm-cng2_pass-hide").fadeIn(1500);
      $("#urm-cng2_pass-show").hide();
  }
  else {
      $("#change_pass_2").attr('type', 'password'); 
      $("#urm-cng2_pass-show").fadeIn(1500);
      $("#urm-cng2_pass-hide").hide();
  }
}