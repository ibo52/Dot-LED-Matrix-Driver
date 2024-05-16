<?php
session_start();
include("db_config.php");

$ERR_NO_PEMISSION = -1;
$ERR_UNKNOWN=-2;

$SUCCESS=1;

if( isset($_SESSION["login-userid"]) && isset($_POST["personelId"]) ){

    $personelId=$_POST["personelId"];
    $operatorId=$_SESSION["login-userid"];

    $sql='CALL sp_personelSil('.$operatorId.', '.$personelId.', @retval);';

    $result = $conn->query($sql, PDO::FETCH_ASSOC);
    $resultSet= $result->fetchColumn();
    $result->closeCursor();

    $sql="select @retval;";
    $result = $conn->query($sql, PDO::FETCH_ASSOC);
    $resultSet= $result->fetchColumn();

    //hiçbir yetkisi yoksa mesaj yaz
    if( $resultSet> 0) {

        echo $SUCCESS;
    }else if($resultSet==0){

        echo $ERR_NO_PEMISSION;

    }else{
        echo $ERR_UNKNOWN;
    }
}else{
    echo $ERR_UNKNOWN;
}
?>