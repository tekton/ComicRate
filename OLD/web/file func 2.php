<?php

define('DBUG', 1);

$str = "Detective Comics 048-Batman only (R)(02-1941)";
break_out_file_name($str, "");
break_out_file_name("Batgirl #003", "");
$str = "Detective Comics 870 ctc (2010)";
break_out_file_name($str, "");

function break_out_file_name($file, $b) {
	global $issue;
	
	$issue = "";
	$file = preg_replace("/#/i", "", $file);
	
	$regex = "/(.*?)[\(\[](.*)/";
	preg_match($regex,$file,$p);
		pa_e($p, "P:: ");
	//preg_match("/(.*)[\s][#](.*)$/",$p[1],$q);
		//pa_e($q, "Q:: ");
	
	if($p[1]=="") {
		preg_match("/(.*)[\s#](.*$)/i", $file, $r);
	} else {
		preg_match("/(.*)[\s#](.*$)/i", trim($p[1]), $r);
	}
	
	pa_e($r, "R :: ");
	
	$issue = find_issue_number_from_number(trim($r[2]));
	
	if($issue == 0) {
		$issue = find_issue_number_from_number($file);
		preg_match("/(.*)$issue(.*)/i", $file, $q);
		$title = trim($q[1]);
		//echo "<div>".trim($q[1])." :: ".$q[2]."</div>";
		pa_e($q, "Q :: $issue :: $file :: ");
	} else {
		$title = trim($r[1]);
	}
	
	if($issue == 0) { //if it doesn't start with a didgit and isn't fully numeric, it needs a review
		echo "<div><b>REVIEW!</b> :: $file ... $issue</div>";
		//create_sql_call($b."/".$file, $file, $issue, "yes");
		global $RC;
		$RC = $RC + 1;
	} else {
		echo "<div>Would end up as :: $title ... $issue</div>";
		//create_sql_call($b."/".$file, trim($r[1]), $issue, "no");
		global $NC;
		$NC = $NC + 1;
	}
}

function find_issue_number_from_number($num) {
	if(!is_numeric($num)) {
		echo "<div>Attempting to find number in <b>$num</b></div>";
		preg_match("/(\d+)(.*)/i", $num, $r); //keeping same array as other number evaluation functions
		pa_e($r);
		if(is_numeric($r[1])) {
			echo "<div>Able to find number in $num:: ".$r[1]."</div>";
			return $r[1];
		}
		else {
			echo "<div>Unable to find number in $num...</div>";
			return 0;
		}
	} else {
		echo "<div>Value wasn't numeric :: $num</div>";
		return $num;
	}
}

function pa_e($a, $title="") {
	if(DBUG > 0) {
		echo "<pre>$title\n";
			print_r($a);
		echo "</pre>";
	} else {
		return;
	}
}

?>