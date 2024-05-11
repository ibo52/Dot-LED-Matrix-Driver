<?php

$servaddr= "localhost";
$uname= "root";
$password = "1234";
$db_name = "envanter";
$conn;
try{
	$conn = new PDO("mysql:host=$servaddr;dbname=$db_name;charset=utf8", $uname, $password);

}catch ( PDOException $e ){
	print $e->getMessage();
}
?>