<?php

	require_once("./web/gdef.php");
	require_once("./web/db.php");
	require_once("./web/shared_functions.php");
	
$db = ConnectDB();
	
DEFINE('DBUG','0');
//DEFINE('RC','0');
//DEFINE('NC','0');

$RC = 0; $NC = 0; $tbl = "";

if($_GET) {

	html_header("issue");

	global $db;
	
	$loc = $_GET["loc"];//file_location
	$name = $_GET["name"];//file_name
		$name = preg_replace("/ /", "%", $name);
	$review = $_GET["review"];
	
	$min = $_GET["min"];
	$max = $_GET["max"];

	$owned = $_GET["owned"]; //physical
	
	$main = $_GET["main"]; //physical
	$need = $_GET["need"]; //physical

	$numbers = "";
	
	if($min == "" && $max != "") {
		$numbers = "AND number <= '$min' ";
	}
	else if($max == "" && $min != "") {
		$numbers = " AND number >= '$min' ";
	} 
	else if($min == "" && $max == "") {
		//do nothing
		$numbers = "";
	}
	else {
		$numbers = "AND (number >= '$min' && number <= '$max')";
	}
	
	if($loc != "" )		{$loc_search = "AND file_location LIKE '%$loc%'";} else {$loc_search = "";}
	if($owned != "" )	{$owned_search = "AND physical = '$owned'";} else {$owned_search = "";}
	if($main != "" )	{$main_search = "AND main = '$main'";} else {$main_search = "";}
	if($need != "" )	{$need_search = "AND need = '$need'";} else {$need_search = "";}
	
	$q = "SELECT * FROM base_list WHERE file_name LIKE (\"%$name%\") $numbers $loc_search $owned_search $main_search $need_search ORDER BY number, main ASC";
	
	//is getting old information and comparing even worth it in a system somewhat designed to wipe and erase every so often?
	
	//TODO: test new location to see if the file even exist!
	
	$s = mysql_query($q, $db) or die (mysql_error());
	
	echo "<pre>".$q."</pre>";
	
	echo '
		<style type="text/css">
			table.s {
				border-width: 1px;
				border-spacing: 2px;
				border-style: outset;
				border-color: gray;
				border-collapse: collapse;
				background-color: white;
			}
			table.s th {
				border-width: 1px;
				padding: 1px;
				border-style: inset;
				border-color: gray;
				background-color: white;
			}
			table.s td {
				border-width: 1px;
				padding: 5px;
				border-style: inset;
				border-color: gray;
				background-color: white;
			}
			</style>
	';
	
	echo "<table class='s' id='hundred'>
		<thead>
		<tr>
			<th>Location</th>
			<th>Name</th>
			<th>Number</th>
			<th>Primary</th>
			<th>Owned</th>
			<th>Need</th>
			<th>Copy</th>
		</tr>
		<thead><tbody>";
	while($row = mysql_fetch_array($s, MYSQL_BOTH)) {
		$id = $row["id"];
		$loc = preg_replace("/\#/", "&#35;", $row["file_location"]);
		echo "
		<tr>
			<td><a href=\"".$loc."\">".
			$row["file_location"]."</a> <span id='tomain$id' class='tomain'>set main</span></td>
			<td><a href='issue.php?id=".$row["id"]."'>".
			$row["file_name"]."</a></td><td>".
			$row["number"]."</td><td>".
			$row["main"]."</td><td>".
			$row["physical"]."</td><td>".
			$row["need"]."</td><td>".
			"<button id='copy$id' name='copy$id' value='$id'>Copy</button></td>
		</tr>";
	}
	
	echo "
	<form>
		<input type='hidden' name='name' 	value='$name' />
		<input type='hidden' name='min' 	value='$min' />
		<input type='hidden' name='max' 	value='$max' />
		<input type='hidden' name='loc' 	value='$loc' />
		<input type='hidden' name='owned' 	value='$owned' />
		<input type='hidden' name='review' 	value='$review' />
		<input type='hidden' name='main' 	value='$main' />
		<input type='hidden' name='need' 	value='$need' />
	</form>";
	
	echo "</tbody></table>";

	footer();
	//redirect to the basic view of the item; which should be the input form really
	
} else {
	html_header("search");
	base_disp();
	footer();
}

function base_disp() {

	//global $db;

	//if($_GET["id"]=="") {$id=100;} else {$id = $_GET["id"];}
	//$q = "SELECT * from base_list where id='$id'";
	//$s = mysql_query($q, $db) or die(mysql_error());
	echo "
	<form action=\"search.php\" method=\"GET\">
	<table>";

		echo "
			<tr>
				<td>Name</td>
				<td><input type='text' name='name' /></td>
			</tr>
			<tr>
				<td>Min Issue Number</td>
				<td><input type='text' name='min' /></td>
			</tr>
			<tr>
				<td>Max Issue Number</td>
				<td><input type='text' name='max' /></td>
			</tr>
			<tr>
				<td>Location</td>
				<td><input type='text' name='loc' /></td>
			</tr>
			<tr>
				<td>Owned</td>
				<td><input type='text' name='owned' /></td>
			</tr>
			<tr>
				<td>Review</td>
				<td><input type='text' name='review' /></td>
			</tr>
			<tr>
				<td>Primary</td>
				<td><input type='text' name='main' /></td>
			</tr>
			<tr>
				<td>Need</td>
				<td><input type='text' name='need' /></td>
			</tr>
		";
	
	echo "</table>
	<div><input type='Submit' /></div>
	</form>
	";
}

?>