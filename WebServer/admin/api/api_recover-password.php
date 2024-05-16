<?php
include "db_config.php";

$ERR_EMAIL_EMPTY=-1;
$ERR_UNKNOWN=-2;
$ERR_DB_EXCEPTION=-3;
$SUCCESS=1;

if ( isset($_POST['recover-email']) ) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$email = validate($_POST['recover-email']);

	if (empty($email)) {
		echo $ERR_EMAIL_EMPTY;

	}else{
		try{
			$sql = "call sp_şifreYenilemeTalebi('$email')";

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$result = $conn->query($sql);

			echo $SUCCESS;

		}catch(PDOException $e) {

			echo $ERR_DB_EXCEPTION;
		}
	}
}else{
	echo "72";
}
?>