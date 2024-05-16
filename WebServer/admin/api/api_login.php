

<?php
session_start();

include("db_config.php");

$ERR_EMAIL_EMPTY=-1;
$ERR_PASS_EMPTY=-2;
$ERR_UNKNOWN=-3;
$ERR_LOGIN_AUTH_FAIL=-4;
$SUCCESS=1;

if (isset($_POST['email']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$email = validate($_POST['email']);
	$passwd = validate($_POST['password']);

	if (empty($email)) {
		echo $ERR_EMAIL_EMPTY;

	}else if(empty($passwd)){
		echo $ERR_PASS_EMPTY;
	}else{

		//database login function returns either 1 or 0
		$sql = "SELECT f_loginCheck('$email', '$passwd') AS retval";

			$result = $conn->query($sql, PDO::FETCH_ASSOC);

			$retval=$result->fetchColumn();
			if ($retval >0) {

				$_SESSION['login-userid'] = $retval;
				$_SESSION['login-email'] = $email;
				$_SESSION["loggedIn"]=true;

				echo $SUCCESS;


			}else{
				echo $ERR_LOGIN_AUTH_FAIL;
				$_SESSION["loggedIn"]=false;
			}
	}
}else{
}
?>