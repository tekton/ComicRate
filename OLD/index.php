<?php

	require_once("./web/gdef.php");
	require_once("./web/db.php");
	require_once("./web/shared_functions.php");

$db = ConnectDB();
	
DEFINE('DBUG','0');

$RC = 0; $NC = 0; $tbl = "";

html_header("index");
	grid_view();
	hundred_most_recent();
footer();

function grid_view() {
	
	/*
	
	|BOOM		|DC		|Marvel|
	|Dark Horse	|Vertigo|Other|
	|TransferMe	|
	|FileCheck	|Search	|
	
	*/
	
	echo "<div>
		<table width='80%' style='margin: auto; text-align: center; width: 90%; border: 0px solid red;'>";
		//get list of directories?
		
		echo "
		<tr>
			<td><a href='files.php?dir=BOOM'>BOOM</a></td>
			<td><a href='files.php?dir=DC'>DC</a></td>
			<td><a href='files.php?dir=Marvel'>Marvel</a></td>
		</tr>";
		
		echo "
		<tr>
			<td><a href='files.php?dir=Dark%20Horse'>Dark Horse</a></td>
			<td><a href='files.php?dir=Vertigo'>Vertigo</a></td>
			<td><a href='files.php?dir=Other%20Publishers'>Other Publishers</a></td>
		</tr>";
		
		echo "
		<tr>
			<td><a href='files.php?dir=Disney'>Disney</a></td>
			<td><a href='files.php?dir=OtherPeople'>Other People</a></td>
			<td><a href='files.php?dir=proc'>Proc</a></td>
		</tr>";
		
		echo "
		<tr>
			<td><a href='./transferMe/'>transfers</a></td>
			<td><a href='files_check.php'>file checks</a> | <a href='files_check.php?table=proc'>proc checks</a></td>
			<td><a href='search.php'>search</a></td>
		</tr>";
		
	echo "</table>
	&nbsp;
	</div>";
	
}

function hundred_most_recent() {
	
	global $db;
	
	$q = "SELECT * from base_list ORDER BY id desc LIMIT 100";
	$s = mysql_query($q, $db) or die(mysql_error());
	echo "<div class='issue_top'>100 Most Recent Entries</div>

	<table id='hundred' class=\"tablesorter\">
		<thead> 
		<tr>
			<th>File</th>
			<th>Name</th>
			<th>Number</th>
			<th>Primary</th>
			<th>Have</th>
		</tr></thead><tbody>";
	while($row = mysql_fetch_array($s, MYSQL_BOTH)) {
		echo "<tr><td>".
			$row["file_location"]."</td><td><a href='issue.php?id=".$row["id"]."'>".
			$row["file_name"]."</a></td><td>".
			$row["number"]."</td><td>".
			$row["main"]."</td><td>".
			$row["physical"]."</td><td>"
		."</td></tr>";
	}
	echo "</tbody></table>";
}

?>