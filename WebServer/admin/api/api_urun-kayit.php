<?php
session_start();
include "db_config.php";

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
    $urunKategoriAçıklama = validate($_POST['component-category-description']);


	if (empty($urunAd) || empty($urunKategori)) {
		exit();
	}else{

		$personelId = $_SESSION['userid'];
		$sql = "set @retval=0;"
		."call sp_urunEkle($personelId ,'$urunKategori', '$urunKategoriAçıklama', '$urunAd', '$urunEtiket',@retval);"
		."select @retval";

		$result = $conn->query($sql, PDO::FETCH_ASSOC);

        //başarılı başarısız yanıtı
		$retval=-1;
		$retval= $result->fetchColumn(PDO::FETCH_ASSOC);
        if  ($retval==1){

			header("Location: ../urun-kayit.php?success=Component registrated successfully!");
        }else if ($retval==0){
			header("Location: ../urun-kayit.php?error=Could not registrated: You may not have permissions");//.json_encode($retval).json_encode($result));
		}else{
			header("Location: ../urun-kayit.php?error=Bilinmiyor :/");
		}
		exit();
	}
}else{
	header("Location: ../urun-kayit.php?nothing");
	exit();
}
?>