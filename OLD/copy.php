<?php

	require_once("./web/gdef.php");
	require_once("./web/db.php");
	require_once("./web/shared_functions.php");

$db = ConnectDB();
	
DEFINE('DBUG','0');
//DEFINE('RC','0');
//DEFINE('NC','0');

$RC = 0; $NC = 0; $tbl = "";

	if($_GET["id"] != "") {
		$result = transferMe($_GET["id"]);
		//echo $result;
		echo json_encode(array("returnFromValue"=>$result));
	}
?>