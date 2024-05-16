<?php
//gelen api ya da sayfa isteklerini işler
$DEFAULT_ROUTE = "index.php";
$routedPage=$DEFAULT_ROUTE;
//kullanıcı giriş yapmışsa: istekleri ve yönlendirmeleri işle
if( isset( $_SESSION["loggedIn"] ) && $_SESSION['loggedIn']==true){

  //yönlendirme isteği var mı bak
  if( isset($_GET['route']) ){

    //eğer istek türü api ise api klasörüne yönlendir
    if( str_contains($_GET['route'],'api_')){
      $routedPage = $API_ROOT . strtolower($_GET['route']).".php";

    }else{//varsayılan: bileşen klasörüne yönlendir.
      $routedPage= $COMPONENTS_ROOT . strtolower($_GET['route']) . ".php";
    }
  }else{
    $routedPage = $DEFAULT_ROUTE;
  }

  //böyle bir dosya mevcut değilse ana sayfaya yönlendirme için düzenle
  if( !file_exists($routedPage) ){
    $routedPage= $DEFAULT_ROUTE;

  }

}else{//kullanıcı giriş yapmamışsa: sadece giriş, üyelik, şifre yenileme sayfa ve apilerine izin ver

  if( isset($_GET['route']) ){

    if ( str_starts_with($_GET['route'],"register")
    || str_starts_with($_GET['route'], "forgot-pass")
    || str_starts_with($_GET['route'], "contact-us") ){

      $routedPage = $COMPONENTS_ROOT . $_GET['route'] .".php";

    }else if( str_contains($_GET['route'], "api_" )){
      $routedPage = $API_ROOT . $_GET["route"].".php";

    }else{
      $routedPage= $COMPONENTS_ROOT . "login.php";
    }
  }else{
    $routedPage= $COMPONENTS_ROOT . "login.php";
  }
}

include_once($routedPage);
/*
if(isset($_GET['route']) && str_contains( $_GET['route'], "api_") ){
  //api çağrısından sonra sayfayı yenile
  header("Refresh:0; url=index.php?echo=yenile");
}*/
?>