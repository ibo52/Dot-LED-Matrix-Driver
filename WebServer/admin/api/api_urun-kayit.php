<?php
session_start();
include "db_config.php";

$ERR_NAME_AND_CATEGORY_EMPTY=-1;
$ERR_NO_PERMISSION=-2;
$ERR_UNKNOWN=-3;
$SUCCESS=1;

if (isset($_POST['component-name'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }

	$urunAd = validate($_POST['component-name']);
    $urunEtiket = validate($_POST['component-label']);
    $urunKategori = validate($_POST['component-category']);
	$urunAltKAtegori = validate($_POST['component-subcategory']);
    $urunKategoriAçıklama = validate($_POST['component-category-description']);


	if (empty($urunAd) || empty($urunKategori)) {
		echo $ERR_NAME_AND_CATEGORY_EMPTY;

	}else{

		$personelId = $_SESSION['login-userid'];
		$sql = "call sp_urunEkle($personelId ,'$urunKategori',"
		."'$urunKategoriAçıklama', '$urunAd', '$urunEtiket',@urunEkle_retval);";

		$result = $conn->query($sql, PDO::FETCH_ASSOC);
		$result->closeCursor();

		$result=$conn->query("select @urunEkle_retval as retval", PDO::FETCH_ASSOC);
		$retval= $result->fetchColumn();
        //başarılı başarısız yanıtı
        if  ($retval==1){

			echo $SUCCESS;

        }else if ($retval==0){
			echo $ERR_NO_PERMISSION;

		}else{
			echo $ERR_UNKNOWN." ".$retval;
		}
	}
}else{
}
?>