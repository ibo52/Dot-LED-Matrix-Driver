/*
expected error codes from api:login.php
*/

const ERR_NAME_AND_CATEGORY_EMPTY=-1;
const ERR_NO_PERMISSION=-2;
const ERR_UNKNOWN=-3;
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

    $("#urun-ekleme-modal-apply-button").click(function (e) {
        e.preventDefault();

        var cname = $('input[name=component-name]').val()
        var clabel = $('input[name=component-label]').val();
        var ccat = $('input[name=component-category]').val();
        var csubcat = $('select[name=component-subcategory]').val();
        var cdesc = $('textarea[name=component-category-description]').val();

            $.ajax({
                type: "post",
                url: "api/api_urun-kayit.php",
                data: {
                    "component-name":cname,
                    "component-label":clabel,
                    "component-category":ccat,
                    "component-subcategory":csubcat,
                    "component-category-description":cdesc,
                },
                dataType: "text",
                success: function (response) {
                    console.log(response,"donen yanıt")

                    switch(parseInt(response)){

                        case SUCCESS:
                            toastNotify("Component Registration", "Success", "Completed");

                            break;

                        case ERR_NAME_AND_CATEGORY_EMPTY:
                            toastNotify("Component Registration", "Error", "At least name and category are required!");
                            break;

                        case ERR_NO_PERMISSION:
                            toastNotify("Component Registration", "Error", "You have no permission for this operation");
                            break;

                        case ERR_UNKNOWN:
                            toastNotify("Component Registration", "Error", "Unknown error occured on server side");
                            break;

                    }
                }
            });
    });

})