/*
expected error codes from api:login.php
*/
const ERR_EMAIL_EMPTY=-1;
const ERR_UNKNOWN=-2
const ERR_DB_EXCEPTION=-3;
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

    $("#pass-recover-form-button").click(function (e) {
        e.preventDefault();
        var email = $('input[name=recover-email]').val()

            $.ajax({
                type: "post",
                url: "api/api_recover-password.php",
                data: {
                    "recover-email":email,
                },
                dataType: "text",
                success: function (response) {

                    switch(parseInt(response)){

                        case SUCCESS:
                            toastNotify("Recover", "Success", "Thanks, wait until we will inform admins");
                            break;

                        case ERR_EMAIL_EMPTY:
                            toastNotify("Recover", "Error", "Please enter an email, so we can inform admins");
                            break;

                        case ERR_DB_EXCEPTION:
                            toastNotify("Recover", "Error", "An error occured while interacting database :/");
                            break;
                    }
                }
            });
    });

})