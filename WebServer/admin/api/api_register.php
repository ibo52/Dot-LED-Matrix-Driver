<?php
session_start();
include("db_config.php");

$ERR_EMAIL_EMPTY=-1;
$ERR_PASS_EMPTY=-2;
$ERR_UNKNOWN=-3;

$ERR_PASS_DOES_NOT_MATCH=-5;
$ERR_DB_EXCEPTION=-6;
$ERR_FILL_THE_FIELDS=-7;

$SUCCESS=1;

if (isset($_POST['register-email']) && isset($_POST['register-password'])
	&& isset($_POST['register-name']) && isset($_POST['register-surname'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$email = validate($_POST['register-email']);
	$passwd = validate($_POST['register-password']);
	$passwdAgain = validate($_POST['register-password-again']);
	$name = validate($_POST['register-name']);
	$surname = validate($_POST['register-surname']);

	if (empty($email)) {
		echo $ERR_EMAIL_EMPTY;

	}else if(empty($passwd)){
		echo $ERR_PASS_EMPTY;

	}else if(empty($name) || empty($surname)){
		echo $ERR_FILL_THE_FIELDS;

	}else if($passwd!=$passwdAgain){
		echo $ERR_PASS_DOES_NOT_MATCH;
	}
	else{
		try{
			$sql = "call sp_personelEkle('$name','$surname','$email','$passwd')";

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$result = $conn->query($sql);

			echo $SUCCESS;

		}catch(PDOException $e) {

			echo $ERR_DB_EXCEPTION;
		}
	}
}else{
}
?>