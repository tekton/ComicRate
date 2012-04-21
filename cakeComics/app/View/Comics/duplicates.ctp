<div class="comics index">
	<h2><?php echo __('Comics');?></h2>
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
			} else  {
				$f = $comic['comics']['F'];
			}
			
			if($comic['comics']['N']=="") {
				$n = "NULL";
			} else  {
				$n = $comic['comics']['N'];
			}
			
			echo $this->Html->link(__('View'), array('controller' => 'base_lists', 'action'=>'search', "name" => "exact", $f, $n, $n));
			?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>

<div class="actions">
	<?php echo $this->element('search'); ?>
</div>