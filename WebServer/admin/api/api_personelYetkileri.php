<?php
session_start();
include("db_config.php");

if( isset($_SESSION["login-userid"]) && isset($_POST["personelId"]) ){

    $personelId=$_POST["personelId"];
    $operatorId=$_SESSION["login-userid"];

    $sql='CALL sp_yetkileriGetir('.$operatorId.','.$personelId.', @retval);';

    $result = $conn->query($sql, PDO::FETCH_ASSOC);
    $resultSet= $result->fetchAll();
    $rowCount=$result->rowCount();

    $result->closeCursor();

    $sql="select @retval;";

    $retval = $conn->query($sql, PDO::FETCH_ASSOC)->fetchColumn();

    //hiçbir yetkisi yoksa mesaj yaz
    if( $rowCount > 0) {

        echo json_encode($resultSet);

    }else if( $retval==1 ){//yetkin var ama boş döndüyse tablo boştur

        echo json_encode(array(
            array("açıklama"=>"employee have no permissions")
        ));

    }else if($retval==0){//yetkin yoksa

        echo json_encode(array(
            array("açıklama"=>"You have no permission to see")
        ));
    }
}else{
    echo json_encode(array(
        array("açıklama"=>"parameter required to PHP api: personelId")
    ));
}
?>