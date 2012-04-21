<?php

	require_once("./web/gdef.php");
	require_once("./web/db.php");
	require_once("./web/shared_functions.php");

DEFINE('DBUG','0');
//DEFINE('RC','0');
//DEFINE('NC','0');

$RC = 0; $NC = 0; $total = 0;

$db = ConnectDB();

$tbl = ($_GET["table"] == "") ? "base_list" : "proc_list"; 

echo "<div>Checking: $tbl</div>";

//get list of all files
$q = "select * from $tbl";
$s = mysql_query($q, $db);
	//check if the file exists
	while($row = mysql_fetch_array($s, MYSQL_BOTH)) {
		
		if (file_exists($row["file_location"])) {
			//yes? --> $RC++
			$RC = $RC + 1;
		} else {
			//no? --> delete from DB
			$q = "DELETE FROM $tbl where id='".$row["id"]."'";
			$f = $row["file_name"]." ".$row["number"];
			echo "<div>$f :: $q</div>";
			mysql_query($q, $db) or die(mysql_error());
			//$NC++
			$NC = $NC + 1;
		}	
	}

	$total = $RC + $NC;
	
echo "<div>Total: $total :: Delete: $NC || Keep: $RC</div>";

?>