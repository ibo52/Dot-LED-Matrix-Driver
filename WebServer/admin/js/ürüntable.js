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
    var table=$('#uruntableResults').DataTable({  // ajax.php dosyasına POST isteği yolluyoruz. verileri çekiyotruz
        "paging": true,
        "responsive": true,
        "lengthChange": false,
        "searching": true,
        "processing": true,
        "serverSide": true,
        dom: 'B',
        "buttons": ["colvis"],
        order:[],
        "ajax":"api/api_ürünTable3.php",
    });
    table.buttons().container().appendTo('#uruntableResults_wrapper .col-md-6:eq(0)');

    //kendi koyfuğum arama çubuğunun tabloya bağlandığı yer
    $('#uruntable-search-pane').on('keyup', function () {

        if(this.value.length>1){
            table.search(this.value).draw();
        }else{
            table.search("").draw();
        }
    });

    //blink butonlarına tıklama olayı bağla
  $('#uruntableResults').on("click","button[name=blink-button]",function (e) {
    e.preventDefault();

    //tıkladığında urun id kullanarak api ile veritabanında denk gelen led matrisi bulup yakalim
    var urunId=this.getAttribute("id");
    toastNotify("Blink", "Processing",`LED corresponding to product ID:${urunId} will blink`)
  });
});
