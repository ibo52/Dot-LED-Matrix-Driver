<?php
session_start();
include "db_config.php";

$liveSearchQuery=$_GET["keyword"];
$response="";

if ( strlen($liveSearchQuery)>1 ) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$liveSearchQuery = validate($liveSearchQuery);

	if (empty($liveSearchQuery)) {
	    $response="";
	}else{

		$sql = "CALL sp_liveSearch('$liveSearchQuery')";

		$result = $conn->query($sql, PDO::FETCH_ASSOC);

			if ($result->rowCount() > 0) {

				$resultSet= $result->fetchAll(PDO::FETCH_ASSOC);

				//$resultSet=json_encode($resultSet, JSON_FORCE_OBJECT);
				foreach ($resultSet as $row) {
					//query occurence done index
					$doneIdx=strpos($row["ad"],$liveSearchQuery)+strlen($liveSearchQuery);

					$response.= '<button type="submit" class="search-suggestion" onclick="itemBoxButtonClicked'
					."('"
					.$row["ad"]
					."')"
					.'"><b>'.
					$liveSearchQuery.
					"</b>".substr($row["ad"], $doneIdx).'</button><br>';
				}

			}else{
				$response= "Could not found anything";
			}
	}
}else{
	$response="Enter at least 2 char for suggestions";
}
echo $response;
?>