function showResult(str) {
    if (str.length==0) {
      document.getElementById("livesearch-results").innerHTML="";
      document.getElementById("livesearch-results").style.border="0px";
      return;
    }
    // Eski denediğim, allta JQuery ile
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("livesearch-results").innerHTML=this.responseText;
        //document.getElementById("livesearch").style.border="1px solid #A5ACB2";
      }
    }
    xmlhttp.open("GET","api/livesearch.php?keyword="+str,true);
    xmlhttp.send();
/*
    jQuery.ajax({
      type: "GET",
      url: 'api/livesearch.php',
      dataType: 'json',
      data: {"keyword":str},
      success: function (obj, textstatus) {
        console.log("sonuc jquery:"+obj+"\n"+textstatus)
                    if( !('error' in obj) ) {
                        yourVariable = obj.result;
                        console.log(yourVariable)
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
