<?php

	echo "<div>Files that were attempted to be made Main</div>";

	echo "<table width='100%'>";
	foreach ($dupeActions as $item) {
		echo "<tr>";
			echo "<td>".$item."</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	echo $this->Html->link("Remove duplicates of items that have a Main issue set",
								array('controller'=>'base_lists','action' => 'auto_duplicate_proc'));
?>