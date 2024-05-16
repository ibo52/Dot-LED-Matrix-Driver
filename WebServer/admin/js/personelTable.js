const ERR_NO_PEMISSION=-1;
const ERR_UNKNOWN=-2;

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

$(function(){
    var table=$('#personeltableResults').DataTable({  // ajax.php dosyasına POST isteği yolluyoruz.
        "paging": true,
        "responsive": true,
        "lengthChange": false,
        "searching": true,
        "processing": true,
        "serverSide": true,
        dom: 'B',
        "buttons": [{extend:"colvis"}],
        order:[],
        "ajax":"api/api_personelTable.php",
    });
    table.buttons().container().appendTo('#personeltableResults_wrapper .col-md-6:eq(0)');

    //kendi koyfuğum arama çubuğunun tabloya bağlandığı yer
    $('#uruntable-search-pane').on('keyup', function () {

        if(this.value.length>1){
            table.search(this.value).draw();
        }else{
            table.search("").draw();
        }
    });

    //blink butonlarına tıklama olayı bağla
  table.on("click","button[name=user-permissions-button]",function (e) {
    e.preventDefault();

    var personelId=this.getAttribute("id");

    //ajax sorgusuyla butonları alt tabloya(yetkileri gösterir) bağlıyoruz
    $.ajax({
      type: "post",
      url: "api/api_personelYetkileri.php",
      data: {"personelId": personelId},
      dataType: "json",

      success: function (response) {

        var permissions_table='<div class="callout callout-info"><strong><i class="far fa-file-alt mr-1"></i> Permissions </strong>';
        response.forEach(element => {

          permissions_table+='<li class="list-group-item"><p class="text-muted">';
          permissions_table+='<i class="far fa-circle nav-icon"></i> ';
          permissions_table+=element.açıklama;
          permissions_table+=" </p></li>"
        });
        permissions_table=permissions_table.concat("</div>");

        //tıkladığında personel id kullanarak api ile veritabanında denk gelen yetkileri göster
        let tr = e.target.closest('tr');
        let row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        }
        else {
            // Open this row
            row.child(permissions_table).show();
        }

      }
    });

  });

  //personel silme butonlarına tıklama olayı bağla
  table.on("click","button[name=user-delete-button]",function (e) {
    e.preventDefault();

    var personelId=this.getAttribute("id");
    login_userid=$("[name=sidebar-element]").attr("id");

    //kendini silemesin
    if(personelId==login_userid){
      toastNotify("Delete employee", "Warning", "You can not achieve to delete yourself!");;
      return;
    }

    //ajax sorgusuyla personel silme işlemi
    $.ajax({
      type: "post",
      url: "api/api_personelSil.php",
      data: {"personelId": personelId},
      dataType: "text",

      success: function (response) {


        switch(parseInt(response)){

            case SUCCESS://tablodan satırı da kaldır
              toastNotify("Delete employee", "Success", "Employee deleted");

              rowToBeDeleted=$(e.target).parents("tr").fadeOut(400, function(){
                table.row(rowToBeDeleted).remove().draw(false);
              });
              break;

            case ERR_NO_PEMISSION:
              toastNotify("Delete employee", "Error", "You have no permission for this operation");
              break;

              case ERR_UNKNOWN:
                toastNotify("Delete employee", "Error", "Unknown error occured on server side!");
                break;
            default:
              toastNotify("Delete employee","Error",`default error:: response:${parseInt(response)}`)
              break;
        }
    }
    });

  });
});
