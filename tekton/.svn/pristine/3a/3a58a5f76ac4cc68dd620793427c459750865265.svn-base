<div class="comics index">
	<h2><?php echo __('Top 200 Duplicate Comics');?></h2>
	<?php
		echo $this->Form->create('Comics', array("type" => "post", "action" => "auto_main"));
	?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>Issue</th>
			<th>Number</th>
			<th>Count</th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($comics as $comic): ?>
	<tr>
		<td><?php //name:exact
		echo h($comic['comics']['F']);
		//pr($comic);
		?>&nbsp;</td>
		<td><?php echo h($comic['comics']['N']); ?>&nbsp;</td>
		<td><?php echo h($comic['0']['C']); ?>&nbsp;</td>
		<td class="actions">
			<?php
			/*
			echo $this->Html->link(__('View'), array('action' => 'view', $comic['Comic']['id']));
			echo $this->Html->link(__('Edit'), array('action' => 'edit', $comic['Comic']['id']));
			echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $comic['Comic']['id']), null, __('Are you sure you want to delete # %s?', $comic['Comic']['id']));
			*/
			
			$f = "";
			$n = "";
			
			if($comic['comics']['F']=="") {
				$f = "NULL";
			}
			else if(preg_match("/(.*)[v\(]$/i", $comic['comics']['F'])) {
				$f = "NULL";
			}
			else if(preg_match("/(.*)v\d[\s]\d$/i", $comic['comics']['F'])) {
				$f = "NULL";
			}
			else if(preg_match("/(.*)v\d$/i", $comic['comics']['F'])) {
				$f = "NULL";
			}
			else if(preg_match("/(.*) $/i", $comic['comics']['F'])) {
				$f = "NULL";
			}
			else  {
				$f = $comic['comics']['F'];
			}
			
			if($comic['comics']['N']=="") {
				$n = "NULL";
			} 
			else if($comic['comics']['N'] > 908) {
				$n = "NULL";
			}
			else  {
				$n = $comic['comics']['N'];
			}
			
			echo $this->Html->link(__('View'), array('controller' => 'base_lists', 'action'=>'search', "name_type" => "exact", "name" => $f, "min" => $n, "max" => $n));
			
			if($f != "NULL" && $n != "NULL") {
				$c = h(serialize($comic));
				echo '<input type="checkbox" name="dupes[]"  value=\''.$c.'\' />';
			}
			?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
	<div style="text-align: right; margin-top: 25px;">
	<?php 	echo $js = "<script type='text/javascript'> 
			$(function () {
				$('#checkall').click(function () {
					$('[type=checkbox]').each(function(index) {
						$( this ).attr( 'checked', $( this ).is( ':checked' ) ? '' : 'checked' );
					});
				});
				
			});
			</script>";
	echo "<div id='checkall'>Check all files</div>";
	echo $this->Form->end(__('Submit'));
	?>
	</div>
	
</div>

<div class="actions">
	<?php echo $this->element('search'); ?>
</div>