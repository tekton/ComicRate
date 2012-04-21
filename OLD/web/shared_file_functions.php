<?php

function print_sub_dir($dir) {

	$pi = pathinfo($dir); pa_e($pi);
	$b = $pi["dirname"]."/".$pi["basename"];

	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".."
				&& $file != "nomatch.txt"
				&& $file != "test"
				&& $file != "files.php"
				&& $file != "db.php"
				&& $file != "folder.pl"
				&& $file != "web"
				&& $file != "transferMe") {
				$pi = pathinfo($b."/".$file); pa_e($pi);
				if(is_dir($b."/".$file) == true) {
					//echo "<div><b>".$pi["dirname"]."/".$pi["basename"]."</b></div>";
					echo "<blockquote>";
						print_sub_dir($b."/".$file);
					echo "</blockquote>";
				} else {
					pa_e($file);
					break_out_file_name($file, $b);
				}
			}
		}
	}
}

function break_out_file_name($file, $b) {
	global $issue;
	
	$title = "";
	$issue = "";
	
	$pi = pathinfo($b."/".$file);
	pa_e($pi);
	
	$title = trim($pi["filename"]);
	$title = preg_replace("/#/i", " ", $title);
	
	$regex = "/(.*?)[\(\[](.*)/";
	preg_match($regex,$title,$p);
		pa_e($p, "P:: ");
	//preg_match("/(.*)[\s][#](.*)$/",$p[1],$q);
		//pa_e($q, "Q:: ");
	
	if($p[1]=="") {
		preg_match("/(.*)[\s](.*$)/i", $title, $r);
	} else {
		preg_match("/(.*)[\s](.*$)/i", trim($p[1]), $r);
	}
	
	pa_e($r, "R :: ");
	
	$issue = find_issue_number_from_number(trim($r[2]));
	
	if($issue == 0) {
		$issue = find_issue_number_from_number($title);
		preg_match("/(.*)$issue(.*)/i", $title, $q);
		$title = trim($q[1]);
		//echo "<div>".trim($q[1])." :: ".$q[2]."</div>";
		pa_e($q, "Q :: $issue :: $file :: ");
	} else {
		$title = trim($r[1]);
	}
	
	if($issue == 0) { //if you STILL can't find an issue number, throw what we do know in the database and remind the user it needs a review
		e_line("REVIEW :: [ $title ] [ $issue ]", "2");
		create_sql_call($b."/".$file, $title, $issue, "yes");
		global $RC;
		$RC = $RC + 1;
	} else {
		e_line("Would end up as :: [ $title ] [ $issue ]", "2");
		create_sql_call($b."/".$file, $title, $issue, "no");
		global $NC;
		$NC = $NC + 1;
	}
}

function find_issue_number_from_number($num) {
	if(!is_numeric($num)) {
		e_line("Attempting to find number in <b>$num</b>", "2");
		preg_match("/(\d+)(.*)/i", $num, $r); //keeping same array as other number evaluation functions
		pa_e($r);
		if(is_numeric($r[1])) {
			e_line("Able to find number in $num:: ".$r[1], "2");
			return $r[1];
		}
		else {
			e_line("Unable to find number in $num...", "2");
			return 0;
		}
	} else {
		e_line("Value is already numeric :: $num", "2");
		return $num;
	}
}


function create_sql_call($loc, $name, $num, $review) {
	global $db, $tbl;
	$q = "INSERT into $tbl (`file_location`,`file_name`,`number`,`review`) VALUES (\"".mysql_real_escape_string($loc)."\", \"".mysql_real_escape_string($name)."\", \"".mysql_real_escape_string($num)."\", \"".mysql_real_escape_string($review)."\")";
	//echo "<div>$q</div>";
	//mysql_query($q, $db); //or die(mysql_errno()." :: ".mysql_error());
	
	if (!mysql_query($q, $db)) {
		echo "<div>".mysql_errno()." :: ".mysql_error()." -- $q</div>";
	}
}

?>