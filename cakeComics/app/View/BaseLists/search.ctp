<div class="baseLists index">
	<h2><?php //pr($this->Session->request->data["BaseList"]["file_name"]);
	echo __('Base Lists');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('file_location');?></th>
			<th><?php echo $this->Paginator->sort('file_name');?></th>
			<th><?php echo $this->Paginator->sort('number');?></th>
			<th><?php echo $this->Paginator->sort('main');?></th>
			<th><?php echo $this->Paginator->sort('need');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($baseLists as $baseList): ?>
	<tr>
		<td><?php
			
			$pi = pathinfo($baseList['BaseList']['file_location']);
			pr($pi);
			
			$linky = "file:///".$pi["dirname"];
			$title = $baseList['BaseList']['file_location'];
				if(strlen($title) >= 72) {
					$title = substr($title, 0, 75);
					$title .= "...";
				}
			echo $this->Html->link(__("$title"), $linky);
			?>&nbsp;</td>
		<td><?php echo substr(h($baseList['BaseList']['file_name']), 0, 50); if(strlen(h($baseList['BaseList']['file_name'])) > 50) {echo "...";} ?>&nbsp;</td>
		<td><?php echo h($baseList['BaseList']['number']); ?>&nbsp;</td>
		<td><?php echo h($baseList['BaseList']['main']); ?>&nbsp;</td>
		<td><?php echo h($baseList['BaseList']['need']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $baseList['BaseList']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $baseList['BaseList']['id'])); ?>
						<?php echo $this->Form->postLink($this->Html->Image("test-error-icon.png"),
				array('action' => 'delete', $baseList['BaseList']['id']),
				array('escape' => false),
				__('Are you sure you want to delete # %s?', $baseList['BaseList']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Base List'), array('action' => 'add')); ?></li>
	</ul>
	<?php echo $this->element('search'); ?>
</div>
