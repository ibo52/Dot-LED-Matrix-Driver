/*
expected error codes from api:login.php
*/
const ERR_EMAIL_EMPTY=-1;
const ERR_PASS_EMPTY=-2;
const ERR_UNKNOWN=-3;

const ERR_PASS_DOES_NOT_MATCH=-5;
const ERR_DB_EXCEPTION=-6;
const ERR_FILL_THE_FIELDS=-7;

const SUCCESS=1;

function toastNotify(title, status="", body="", delay=300, notifyDelay=3000){
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "300",
      "timeOut": notifyDelay.toString(),
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }

      setTimeout(() => {
        switch(status.toLowerCase()){
          case "error":
            toastr.error(body, title);
            break;

          case "success":
            toastr.success(body, title);
            break;

          case "info":
            toastr.info(body, title);
            break;

          case "warning":
          case "fail":
            toastr.warning(body, title);
            break;

          default:
            toastr.info(body, title)
            break;
        }
          },delay);
  }

$(document).ready(function(){

    $("#register-form-button").click(function (e) {
        e.preventDefault();

        var name = $('input[name=register-name]').val()
        var surname = $('input[name=register-surname]').val()
        var email = $('input[name=register-email]').val()
        var password = $('input[name=register-password]').val();
        var passwordAgain = $('input[name=register-password-again]').val();
        var password = $('input[name=register-password]').val();

            $.ajax({
                type: "post",
                url: "api/api_register.php",
                data: {
                    "register-name":name,
                    "register-surname":surname,
                    "register-email":email,
                    "register-password":password,
                    "register-password-again":passwordAgain

                },
                dataType: "text",
                success: function (response) {

                    switch(parseInt(response)){

                        case SUCCESS:
                            window.location.reload();//sayfayı yenile
                            toastNotify("Register", "Success", "Registration Successful :)");
                            break;

                        case ERR_EMAIL_EMPTY:
                            toastNotify("Register", "Error", "Please enter email!");
                            break;

                        case ERR_PASS_EMPTY:
                            toastNotify("Register", "Error", "Please enter password!");
                            break;

                        case ERR_PASS_DOES_NOT_MATCH:
                            toastNotify("Register", "Error", "Passwords does not match!");
                            break;

                        case ERR_DB_EXCEPTION:
                            toastNotify("Register", "Error", "An error occured while interacting database :/");
                            break;
                        case ERR_FILL_THE_FIELDS:
                            toastNotify("Register", "Error", "Fill the name surname fields");
                            break;
                    }
                }
            });
    });

})