<?php
session_start();
ob_start();

include_once("api/db_config.php");

$COMPONENTS_ROOT = "components/";
$API_ROOT = "api/";
//header: html açılış etiketi ve header kapanış etiketine kadar olan kısım
include_once('components/header.php');

//üst navigasyon menü çubuğu: body açılış etiketi
include_once("components/navbar.php");

//<!-- sol açılır menu -->
include_once('components/sidebar.php');

/*
-------------------------------------------
sayfada gösterilecek bileşenler
*/
$routedPage="index.php";
//kullanıcı giriş yapmışsa: istekleri ve yönlendirmeleri işle
if( isset( $_SESSION["loggedIn"] ) && $_SESSION['loggedIn']=true){

  //yönlendirme isteği var mı bak
  if( isset($_GET['route']) ){

    //eğer istek türü api ise api klasörüne yönlendir
    if( str_contains($_GET['route'],'api_')){
      $routedPage = $API_ROOT . strtolower($_GET['route']).".php";

    }else{//varsayılan: bileşen klasörüne yönlendir.
      $routedPage= $COMPONENTS_ROOT . strtolower($_GET['route']) . ".php";
    }
  }else{
    $routedPage = "index.php";
  }

  //böyle bir dosya mevcut değilse ana sayfaya yönlendirme için düzenle
  if( !file_exists($routedPage) ){
    @$routedPage= "index.php";

  }

}else{//kullanıcı giriş yapmamışsa: sadece giriş, üyelik, şifre yenileme sayfa ve apilerine izin ver

  if( isset($_GET['route']) ){

    if ( str_contains($_GET['route'],"register")
    || str_contains($_GET['route'], "forgot-pass") ){
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
sayfada gösterilecek bileşenler
-------------------------------------------
*/

//adminlte body
//include_once('components/body.php');

//footer: (body ve html) kapanış etiketine kadar olan kısım
include_once('components/footer.php');
?>