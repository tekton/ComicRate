<div class="comics index">
	<h2><?php echo __('Comics');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('file_location');?></th>
			<th><?php echo $this->Paginator->sort('review');?></th>
			<th><?php echo $this->Paginator->sort('manual');?></th>
			<th><?php echo $this->Paginator->sort('file_name');?></th>
			<th><?php echo $this->Paginator->sort('number');?></th>
			<th><?php echo $this->Paginator->sort('edition');?></th>
			<th><?php echo $this->Paginator->sort('volume');?></th>
			<th><?php echo $this->Paginator->sort('main');?></th>
			<th><?php echo $this->Paginator->sort('physical');?></th>
			<th><?php echo $this->Paginator->sort('issue_title');?></th>
			<th><?php echo $this->Paginator->sort('storyline');?></th>
			<th><?php echo $this->Paginator->sort('need');?></th>
			<th><?php echo $this->Paginator->sort('needD');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($comics as $comic): ?>
	<tr>
		<td><?php echo h($comic['Comic']['id']); ?>&nbsp;</td>
		<td><?php echo h($comic['Comic']['file_location']); ?>&nbsp;</td>
		<td><?php echo h($comic['Comic']['review']); ?>&nbsp;</td>
		<td><?php echo h($comic['Comic']['manual']); ?>&nbsp;</td>
		<td><?php echo h($comic['Comic']['file_name']); ?>&nbsp;</td>
		<td><?php echo h($comic['Comic']['number']); ?>&nbsp;</td>
		<td><?php echo h($comic['Comic']['edition']); ?>&nbsp;</td>
		<td><?php echo h($comic['Comic']['volume']); ?>&nbsp;</td>
		<td><?php echo h($comic['Comic']['main']); ?>&nbsp;</td>
		<td><?php echo h($comic['Comic']['physical']); ?>&nbsp;</td>
		<td><?php echo h($comic['Comic']['issue_title']); ?>&nbsp;</td>
		<td><?php echo h($comic['Comic']['storyline']); ?>&nbsp;</td>
		<td><?php echo h($comic['Comic']['need']); ?>&nbsp;</td>
		<td><?php echo h($comic['Comic']['needD']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $comic['Comic']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $comic['Comic']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $comic['Comic']['id']), null, __('Are you sure you want to delete # %s?', $comic['Comic']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Comic'), array('action' => 'add')); ?></li>
	</ul>
</div>
