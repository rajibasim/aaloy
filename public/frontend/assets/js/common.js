document.addEventListener("DOMContentLoaded", function() {
    getLocation();
});

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    /*alert("Latitude: " + position.coords.latitude +
        "\nLongitude: " + position.coords.longitude);*/
        console.log("get location");
}

function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}

//ready function strat
$(document).ready(function() {
    // signin
    jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 &&
            phone_number.match(/^\d{10}$/);
    }, "Please enter a valid phone number");

    $("#signin").validate({
        rules: {
            phone: {
                required: true,
                phoneUS: true,
            },
            password: {
                required: true,
            },
        },
        submitHandler: function(form) {
            $("#secLoginpopup .titleDetails").text('');
            $("#secVerify .titleDetails").text('');
            var divice_type = $("#divice_type").val();
            var device_id = $("#device_id").val();
            var signin_phone = $("#signin_phone").val();
            var signin_password = $("#signin_password").val();           
            $.ajax({
                url: base_url+'/api/v1/signin',
                type: 'post',
                data: {
                    divice_type : divice_type,
                    device_id : device_id,
                    phone : signin_phone,
                    password : signin_password,
                },
                dataType: "json",
                success: function(res) {
                    if (res.result) {
                        if(res.data.is_phone_verified == '0'){
                            $("#signin_phone").val('');
                            $("#signin_password").val('');  
                            $("#phone_verification_code").val('');
                            $("#veriy_phone").val(res.data.phone);
                            $("#secVerify .successmsg").text(res.message);
                            $("#secLoginpopup").fadeOut(500);
                            $("#secVerify").fadeIn(500);
                        }else{
                            Cookies.set('token', res.data.access_token, { expires: 365, path: '/' });
                            window.location.replace(base_url+"/process-login?token="+res.data.access_token);
                        }
                    }else{
                        $("#secLoginpopup .errormsg").text(res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                },

                beforeSend: function() {
                    $('.animationload').show();
                },

                complete: function() {
                    $('.animationload').hide();
                }
            });
        }
    });

    $("#signup").validate({
        rules: {
            name: {
                required: true,
            },
            phone: {
                required: true,
                phoneUS: true,
            },
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
            },
        },
        submitHandler: function(form) {
            $("#secRegister .errormsg").text('');
            $("#secVerify .titleDetails").text('');
            var type = $("#signup_type").val();
            var name = $("#signup_name").val();
            var phone = $("#signup_phone").val();
            var email = $("#signup_email").val();  
            var password = $("#signup_password").val();           
            $.ajax({
                url: base_url+'/api/v1/signup',
                type: 'post',
                data: {
                    type : type,
                    name : name,
                    phone : phone,
                    email : email,
                    password : password,
                },
                dataType: "json",
                success: function(res) {
                    if (res.result) {
                        $("#veriy_phone").val(res.data.phone);
                        $("#secVerify .successmsg").text(res.message);
                        $("#secRegister").fadeOut(500);
                        $("#secVerify").fadeIn(500);
                    }else{
                        $("#secRegister .errormsg").text(res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                },

                beforeSend: function() {
                    $('.animationload').show();
                },

                complete: function() {
                    $('.animationload').hide();
                }
            });
        }
    });

    $("#verify").validate({
        rules: {
            phone_verification_code: {
                required: true,
            },
        },
        submitHandler: function(form) {
            $("#secVerify .titleDetails").text('');
            $("#secLoginpopup .titleDetails").text('');
            var phone_verification_code = $("#phone_verification_code").val();
            var phone = $("#veriy_phone").val();         
            $.ajax({
                url: base_url+'/api/v1/verify',
                type: 'post',
                data: {
                    phone : phone,
                    phone_verification_code : phone_verification_code,
                },
                dataType: "json",
                success: function(res) {
                    if (res.result) {
                        $("#signin_phone").val('');
                        $("#signin_password").val('');
                        $("#secLoginpopup .successmsg").text(res.message);
                        $("#secVerify").fadeOut(500);
                        $("#secLoginpopup").fadeIn(500);
                    }else{
                        $("#secVerify .errormsg").text(res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                },

                beforeSend: function() {
                    $('.animationload').show();
                },

                complete: function() {
                    $('.animationload').hide();
                }
            });
        }
    });

    $("#updatePhone").click(function(){
      $('#signup').trigger("reset");
      $("#secVerify").fadeOut(500);
      $("#secRegister").fadeIn(500);
    });


    $("#resetPassword").click(function(){
      $("#signin_phone").val('');
      $("#signin_password").val('');
      $("#secLoginpopup").fadeOut(500);
      $("#secResetPassword").fadeIn(500);
    });

    $("#resend").click(function(){
       $("#secVerify .titleDetails").text('');
       var phone = $("#veriy_phone").val(); 
       $.ajax({
          url: base_url+'/api/v1/resend',
          type: 'post',
          data: {
              phone : phone,
          },
          dataType: "json",
          success: function(res) {
              if (res.result) {
                  $("#secVerify .successmsg").text(res.message);
              }else{
                  $("#secVerify .errormsg").text(res.message);
              }
          },
          error: function(xhr, status, error) {
              console.log(xhr);
          },

          beforeSend: function() {
              $('.animationload').show();
          },

          complete: function() {
              $('.animationload').hide();
          }
      });
    });
});