<?php

	foreach($deleted as $file) {
		echo "<div>Removed from DB and File System: $file</div>";
	}
	
	if(count($deleted) == 0) {
		echo "<div>No files to delete today...</div>";
	}

?>