<?php

/*
	Handles all functions in regards to setting the "main" version of a comic book
*/

	require_once("./web/gdef.php");
	require_once("./web/db.php");
	require_once("./web/shared_functions.php");

$db = ConnectDB();
	
DEFINE('DBUG','0');

$RC = 0; $NC = 0; $tbl = "";

	if($_GET["id"] != "") {
		$id = $_GET["id"];
		$q = "UPDATE base_list SET main = 1 where id='$id'";
		//echo $q."<br /><br />";
		
		if(!mysql_query($q, $db)) {
			echo json_encode(array("returnFromValue"=>"Failed"));
		} else {
			echo json_encode(array("returnFromValue"=>"main set"));
		}
	}
?>