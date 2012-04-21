<?php

function pa_e($a, $title="") {
	if(DBUG > 0) {
		echo "<pre>$title\n";
			print_r($a);
		echo "</pre>";
	} else {
		return;
	}
}

function e_line($txt, $dbg,$title="") {
	if($dgb == DBUG) {
		echo "<div>$txt</div>";
	} else {
		return;
	}
}

function transferMe($id, $dest="./transferMe") {
	if($id == "") {
		return "FAILED";
	}
	
	global $db;
	
	$rtn_str = "";
		
	$q = "SELECT * from base_list where id='$id'";
	$s = mysql_query($q, $db) or die(mysql_error());
	
	while($row = mysql_fetch_array($s, MYSQL_BOTH)) {
		$loc = $row["file_location"];//file_location
		
		$pi = pathinfo($loc);
		$fname = "";
		if($row["main"]==1) {
			$fname = $row["file_name"]." ".$row["number"].".".$pi["extension"];
		} else {
			$fname = $pi["basename"];
		}
		
		$dest = $dest."/".$fname;
	}
	
	if (!copy($loc, $dest)) {
		//$rtn_str .= "failed to copy $loc to $dest...</h3>";
		$rtn_str .= "FAILED";
	} else {
		$rtn_str .= "SUCCESS";
	}
	
	return $rtn_str;
}

function mass_transfer() {
	
}

function html_header($page) {
	echo "<html><head>";
		//if($page == "issue") {
		//	echo copy_script();
		//} else {
			echo "
				<link type=\"text/css\" href=\"./web/css/smoothness/jquery-ui-1.8.16.custom.css\" rel=\"stylesheet\" />
				<link type=\"text/css\" href=\"./web/css/base.css\" rel=\"stylesheet\" />
				<script src=\"web/js/jquery-1.6.2.min.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
				<script src=\"web/js/jquery-ui-1.8.16.custom.min.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
				<script src=\"web/js/tableSort.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
				
				<script type=\"text/javascript\" charset=\"utf-8\">
					$(document).ready(function() {
						$('#hundred').tablesorter();
						
						$(\"button\").click(function(){
							$(this).html('Attempting to copy...');
							var value = $(this).val();
							var t = $(this).attr('id');
							sendValue('copy.php', value, t);
						});
						
						$(\".toMain\").click(function(){
							$(this).html('Setting as main...');
							var t = $(this).attr('id');
							
							var value = t.replace(/tomain/i, '');
							/*alert(value);*/
							
							sendValue('main.php', value, t);
						});
						
					} );
					
					function sendValue(file, str, t){
						/*alert(file+' '+str+' '+t);*/
						$.get(file, { id: str },
						function(data){
							/*alert(t);*/
							/*alert(data.returnFromValue);*/
							$('#'+t).html(data.returnFromValue);
						}, \"json\");
					}
				</script>
			";
		//}
	echo "</head><body><div id='container'>";
}

function copy_script() {
	$rtn_str = "
		<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
		<script type=\"text/javascript\" charset=\"utf-8\">
		
		$(document).ready(function(){
			$(\"button\").click(function(){
				$(this).html('Attempting to copy...');
				var value = $(this).val();
				var t = $(this).attr('id');
				sendValue('copy.php', value, t);
			});
			
			$(\".toMain\").click(function(){
				$(this).html('Setting as main...');
				var t = $(this).attr('id');
				
				var value = t.replace(/tomain/i, '');
				/*alert(value);*/
				
				sendValue('main.php', value, t);
			});
			
		});
			function sendValue(file, str, t){
				/*alert(file+' '+str+' '+t);*/
				$.get(file, { id: str },
				function(data){
				    /*alert(t);*/
					/*alert(data.returnFromValue);*/
					$('#'+t).html(data.returnFromValue);
				}, \"json\");
			}
		</script>
	";
	
	return $rtn_str;
}

function footer() {
	echo "</div></body></html>";
}

?>