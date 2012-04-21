<?php

	require_once("./web/gdef.php");
	require_once("./web/db.php");
	require_once("./web/shared_functions.php");
	require_once("./web/shared_file_functions.php");

DEFINE('DBUG','1');
//DEFINE('RC','0');
//DEFINE('NC','0');

$RC = 0; $NC = 0; $total = 0;

$db = ConnectDB();

$tbl = ($_GET["table"] == "") ? "base_list" : "proc_list"; 

number_check();

//number_only_update($tbl);

function number_check() {
	global $tbl, $db;
	$q = "select * from $tbl";
	$s = mysql_query($q, $db);
	while($row = mysql_fetch_array($s, MYSQL_BOTH)) {
		if(!is_numeric($row["number"])) {
			echo "<div>".$row["file_name"]." with <b>".$row["number"]."</b> does not have a valid number</div>";
			preg_match("/(^\d+)(.*)/", $row["number"], $r); //keeping same array as other number evaluation functions
			pa_e($r);
			if(is_numeric($r[1])) {
				$update_q = "UPDATE $tbl SET number = '".$r[1]."', review = 'yes' where id = '".$row["id"]."'";
				mysql_query($update_q, $db);
			}
		}
	}
}

function number_only_update($tbl) {

global $db;

echo "<div>Checking: $tbl</div>";

//get list of all files
$q = "select * from $tbl where file_name like \"%#%\" and (number IS NULL OR number = 0)";
$s = mysql_query($q, $db);
	//check if the file exists
	while($row = mysql_fetch_array($s, MYSQL_BOTH)) {
		echo "<h4>".$row["file_location"]."</h4>";
		//$f = break_out_file_name($row["file_location"], "");
		$pi = pathinfo($row["file_location"]); pa_e($pi);
		if( $pi["extension"] != "jpg" ) { 
			$file = $pi["filename"];
			$regex = "/(.*)(#\d+)(.*)/";
			preg_match($regex,$file,$p);
			echo "preg_match($regex,$file, p) ::";
			pa_e($p);
			
			$num = "";
			
			if($p[2] != "") {
				$num = preg_replace("/#/", "", $p[2]);
				echo "<div>Should update to: ".$p[1]." :: $num";
			}
		}
	}
}

function base_update() {
echo "<div>Checking: $tbl</div>";

//get list of all files
$q = "select * from $tbl where file_name like \"%#%\" and (number IS NULL OR number = 0)";
$s = mysql_query($q, $db);
	//check if the file exists
	while($row = mysql_fetch_array($s, MYSQL_BOTH)) {
		echo "<h4>".$row["file_location"]."</h4>";
		//$f = break_out_file_name($row["file_location"], "");
		$pi = pathinfo($row["file_location"]); pa_e($pi);

		$file = $pi["filename"];

		$regex = "/(.*?)[\(\[](.*)/";
		preg_match($regex,$file,$p);
		echo 'preg_match($regex,$file,$p) ::';
		pa_e($p);
		preg_match("/(.*)[\s][#](.*)$/",$p[1],$q);
		echo 'preg_match("/(.*)[\s][#](.*)$/",$p[1],$q) ::';
		pa_e($q);

		if($p[1]=="") { //there's no "additional data" like year or group
			preg_match("/(.*)[\s][#](.*$)/i", trim($pi["filename"]), $r);
		} else {
			preg_match("/(.*)[\s][#](.*$)/i", trim($p[1]), $r);
			pa_e($r);
		}
		
		if(preg_match("/^\d+/i",$r[2]) == 0) { //if it doesn't start with a didgit, it needs a review
			echo "<div>Noting to update even though a # was found</div>";
			//create_sql_call($b."/".$file, trim($pi["filename"]), "0", "yes");
			global $RC;
			$RC = $RC + 1;
		} else {
			echo "<div>$file<ul><li>".$p[1]."</li><li>".$r[1]."</li><li>".$r[2]."</li></ul></div>";
			//create_sql_call($b."/".$file, trim($r[1]), trim($r[2]), "no");
			
			$update_str = "UPDATE $tbl set file_name = '".trim($r[1])."', number = '".trim($r[2])."' where id = '".$row["id"]."'";
			echo "<div>$update_str</div>";
			mysql_query($update_str, $db);
			
			global $NC;
			$NC = $NC + 1;
		}
		
	}

	$total = $RC + $NC;
	
	echo "<div>Total: $total :: Able to Update: $NC || Unable to Process: $RC</div>";
}

?>