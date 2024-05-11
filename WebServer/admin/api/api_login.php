<?php
include "db_config.php";

$_SESSION["login-error"]="hebele hubele";
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
		$_SESSION["login-error"]="Email is required!";

	}else if(empty($passwd)){
		$_SESSION["login-error"]="Password is required!";
	}else{

		//database login function returns either 1 or 0
		$sql = "SELECT f_loginCheck('$email', '$passwd') AS retval";

			$result = $conn->query($sql, PDO::FETCH_ASSOC);

			$retval=$result->fetchColumn();
			if ($retval >0) {

				$_SESSION['login-userid'] = $retval;
				$_SESSION['login-email'] = $email;
				$_SESSION["loggedIn"]=true;


			}else{
				$_SESSION["login-error"]="Wrong email or password!";
				$_SESSION["loggedIn"]=false;
			}
	}
}else{
}
?>