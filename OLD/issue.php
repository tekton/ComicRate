<?php

	require_once("./web/gdef.php");
	require_once("./web/db.php");
	require_once("./web/shared_functions.php");

html_header("issue");
$db = ConnectDB();
	
DEFINE('DBUG','0');
//DEFINE('RC','0');
//DEFINE('NC','0');

$RC = 0; $NC = 0; $tbl = "";

if($_POST) {

	global $db;
	
	$loc = mysql_real_escape_string($_POST["loc"]);//file_location
	$name = mysql_real_escape_string($_POST["name"]);//file_name
	$review = mysql_real_escape_string($_POST["review"]);
	$manual = mysql_real_escape_string($_POST["manual"]);
	$number = mysql_real_escape_string($_POST["number"]);
	$edition = mysql_real_escape_string($_POST["edition"]);
	$volume = mysql_real_escape_string($_POST["volume"]);
	$main = mysql_real_escape_string($_POST["main"]);
	$owned = mysql_real_escape_string($_POST["owned"]); //physical
	$need = mysql_real_escape_string($_POST["need"]);
	$id = $_POST["id"];
	
	//is getting old information and comparing even worth it in a system somewhat designed to wipe and erase every so often?
	
	//TODO: test new location to see if the file even exist!
	
	$q = "UPDATE base_list SET
	`file_location` = '$loc',
	`file_name` = '$name',
	`review` = '$review',
	`manual` = '$manual',
	`number` = '$number',
	`edition` = '$edition',
	`volume` = '$volume',
	`main` = '$main',
	`physical` = '$owned',
	`need` = '$need'
	where id = '$id'";
	
	$s = mysql_query($q, $db) or die (mysql_error());
	
	//redirect to the basic view of the item; which should be the input form really
	echo "<html><head><meta HTTP-EQUIV=\"REFRESH\" content=\"5; url=issue.php?id=$id\"></head>";
	echo "<pre>".$q."</pre>";
	echo "<div><a href='issue.php?id=$id'>Continue</a> | <a href='search.php'>search</a></div>";
	echo "</body></html>";
	
	
} else {
	/*if($_GET["action"]=="copy" && $_GET["id"] != "") {
		$result = transferMe($_GET["id"]);
		echo $result;
	}*/
	base_disp();
}

function base_disp() {

	global $db;

	if($_GET["id"]=="") {$id=100;} else {$id = $_GET["id"];}
	$q = "SELECT * from base_list where id='$id'";
	$s = mysql_query($q, $db) or die(mysql_error());
	echo "
	<form action=\"issue.php\" method=\"POST\">
	<table>";
	while($row = mysql_fetch_array($s, MYSQL_BOTH)) {
		
			$loc = $row["file_location"];//file_location
			$name = $row["file_name"];//file_name
			$review = $row["review"];
			$manual = $row["manual"];
			$number = $row["number"];
			$edition = $row["edition"];
			$volume = $row["volume"];
			$main = $row["main"];
			$owned = $row["physical"]; //physical
			$need = $row["need"];
			$id = $row["id"];
			
			echo "<tr><td>loc</td><td><input type=\"text\" name=\"loc\" value=\"$loc\" size='100'></td></tr>";
			echo "<tr><td>name</td><td><input type=\"text\" name=\"name\" value=\"$name\" size='100'></td></tr>";
			echo "<tr><td>number</td><td><input type=\"text\" name=\"number\" value=\"$number\"></td></tr>";
			echo "<tr><td>review</td><td><input type=\"text\" name=\"review\" value=\"$review\"></td></tr>";
			echo "<tr><td>manual</td><td><input type=\"text\" name=\"manual\" value=\"$manual\"></td></tr>";
			echo "<tr><td>edition</td><td><input type=\"text\" name=\"edition\" value=\"$edition\"></td></tr>";
			echo "<tr><td>volume</td><td><input type=\"text\" name=\"volume\" value=\"$volume\"></td></tr>";
			echo "<tr><td>main</td><td><input type=\"text\" name=\"main\" value=\"$main\"></td></tr>";
			echo "<tr><td>owned</td><td><input type=\"text\" name=\"owned\" value=\"$owned\"></td></tr>";
			echo "<tr><td>need</td><td><input type=\"text\" name=\"need\" value=\"$need\"></td></tr>";
			echo "<input type='hidden' name='id' value='$id' />";
		
		/*echo "<tr><td>".
			$row["file_location"]."</td><td>".
			$row["file_name"]."</td><td>".
			$row["number"]."</td><td>".
			$row["main"]."</td><td>".
			$row["physical"]."</td><td>"
		."</td></tr>";*/
	}
	echo "</table>
	<div><input type='Submit' /></div>
	</form>
	<div><button id='copyme' value='$id'>Copy Me</button><input type='hidden' name='cid' id='cid' value='$id' /><span id='copiedContent'></span> | <a href='search.php'>search</a></div>
	";
}

?>