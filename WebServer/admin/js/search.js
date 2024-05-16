var ALL_TABLE_ROWS=""

$(document).ready(function(){
  ALL_TABLE_ROWS=document.getElementById("livesearch-results").innerHTML



  //blink butonlarına tıklama olayı bağla
  $("button[name=blink-button]").click(function (e) {
    e.preventDefault();

    var urunId="";//this.attr("id");
    console.log(urunId,"blink buttın click",e.currentTarget)



  });
});

function showResult(filter) {
  const trs = document.querySelectorAll('ürünTableBody')
    if (filter.length<2) {
      document.getElementById("livesearch-results").innerHTML=ALL_TABLE_ROWS;

      return;
    }
    // Eski denediğim, allta JQuery ile
   /* var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        console.log(this.response)

        var formatted="";
        var response=Array();
        response.push( JSON.parse('{"id":"id", "ad":"ad", "etiket":"etiket"}'));

        response.forEach(element => {
          //status, message ve sender adlı json keyleri var
          console.log("foreach element",element)
          formatted=formatted.concat(`<tr>
          <td>${element["id"]}</td>
          <td>${element["ad"]}</td>
          <td>${element["etiket"]}</td>
          <td><button type="button" class="btn btn-block btn-outline-danger btn-lg">'
          <i class="fas fa-lightbulb"></i> Blink</button></td>'
          </tr`);
        });

        console.log("response fırmated:",formatted)
        document.getElementById("livesearch-results").innerHTML="hebele:"+formatted;
      }
    }
    xmlhttp.open("GET","api/api_ürünTable.php", true);
    xmlhttp.send();*/
/*
    $.ajax({
      type: "GET",
      url: 'api/api_ürünTable.php',
      dataType: 'json',
      success: function (response) {
        console.log("sonuc jquery:"+obj+"\n"+textstatus)
                    if( !('error' in obj) ) {

                      var formatted="";
                      response.forEach(element => {
                        //status, message ve sender adlı json keyleri var
                        formatted.concat(`<tr>
                        <td>${element["id"]}</td>
                        <td>${element["ad"]}</td>
                        <td>${element["etiket"]}</td>
                        <td><button type="button" class="btn btn-block btn-outline-danger btn-lg">'
                        <i class="fas fa-lightbulb"></i> Blink</button></td>'
                        </tr`);
                      });

                      document.getElementById("livesearch-results").innerHTML=formatted;
                    }
                    else {
                        console.log(obj.error);
                    }
              }
    });*/
  }
  function itemBoxButtonClicked(name){

    //buradan arama yönlendirme olacak
    console.log("button clicked. id:"+name);

    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        //
      }
    }
    param="search-field="+name
    xmlhttp.open("POST","api/search.php",true);
    xmlhttp.send(param);
  }
