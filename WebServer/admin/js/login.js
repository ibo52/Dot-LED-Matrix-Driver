/*
expected error codes from api:login.php
*/
const ERR_EMAIL_EMPTY=-1;
const ERR_PASS_EMPTY=-2;
const ERR_UNKNOWN=-3;
const ERR_LOGIN_AUTH_FAIL=-4;
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

    $("#login-form-button").click(function (e) {
        e.preventDefault();

        var email = $('input[id=login-email]').val()
        var password = $('input[id=login-password]').val();

            $.ajax({
                type: "post",
                url: "api/api_login.php",
                data: {
                    "email":email,
                    "password":password
                },
                dataType: "text",
                success: function (response) {
                    console.log(response,"donen yanıt")

                    switch(parseInt(response)){

                        case SUCCESS:
                            window.location.href="index.php?route=search-page2";//sayfayı yenile
                            toastNotify("Login", "Success", "Welcome,"+email);

                            break;

                        case ERR_EMAIL_EMPTY:
                            toastNotify("Login", "Error", "Please enter email!");
                            break;

                        case ERR_PASS_EMPTY:
                            toastNotify("Login", "Error", "Please enter password!");
                            break;

                        case ERR_LOGIN_AUTH_FAIL:
                            toastNotify("Login", "Error", "Email or Password is wrong!");
                            break;

                    }
                }
            });
    });

})