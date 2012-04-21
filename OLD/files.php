<?php

	require_once("./web/gdef.php");
	require_once("./web/db.php");
	require_once("./web/shared_functions.php");
	require_once("./web/shared_file_functions.php");

DEFINE('DBUG', 0);
//DEFINE('RC','0');
//DEFINE('NC','0');

$RC = 0; $NC = 0; $tbl = "";

$db = ConnectDB();

//$dir = './proc/';
//$dir = './DC/';

if($_GET["dir"]=="") {
	exit("no dir defined");
} else {
	$dir = $_GET["dir"];
	if($dir == "Proc" || $dir == "proc") {
		$tbl = "proc_list";
	} else {
		$tbl = "base_list";
	}
}

print_sub_dir($dir);

$total = $RC + $NC;
$per = $RC/$total;

echo "<div>Total: $total :: Review: $RC ($per) || Normal: $NC</div>";

?>