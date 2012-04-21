<?php

	echo "<div>Files that were attempted to be removed</div>";

	echo "<table width='100%'>";
	foreach ($deletions as $item) {
		echo "<tr>";
			echo "<td>".$item["file_name"]."</td>";
			echo "<td>".$item["number"]."</td>";
			echo "<td>".$item["file_location"]."</td>";
			echo "<td>".$item["result"]."</td>";
		echo "</tr>";
	}
	echo "</table>";
?>