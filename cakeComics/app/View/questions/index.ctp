<div class="questions index">
	<h2><?php echo __('Questions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('submitter');?></th>
			<th><?php echo $this->Paginator->sort('sorting');?></th>
			<th><?php echo $this->Paginator->sort('own_filters');?></th>
			<th><?php echo $this->Paginator->sort('pre_made_filters');?></th>
			<th><?php echo $this->Paginator->sort('software_install');?></th>
			<th><?php echo $this->Paginator->sort('database_preference');?></th>
			<th><?php echo $this->Paginator->sort('delete_option');?></th>
			<th><?php echo $this->Paginator->sort('delete_duplicates');?></th>
			<th><?php echo $this->Paginator->sort('requests');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($questions as $question): ?>
	<tr>
		<td><?php echo h($question['Question']['id']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['submitter']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['sorting']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['own_filters']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['pre_made_filters']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['software_install']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['database_preference']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['delete_option']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['delete_duplicates']); ?>&nbsp;</td>
		<td><?php echo h($question['Question']['requests']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $question['Question']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $question['Question']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $question['Question']['id']), null, __('Are you sure you want to delete # %s?', $question['Question']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Question'), array('action' => 'add')); ?></li>
	</ul>
</div>
