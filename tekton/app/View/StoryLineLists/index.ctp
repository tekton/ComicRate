<div class="baseLists index">
	<h2><?php echo __('Base Lists');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Storyline');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($StoryLineLists as $StoryLineList): ?>
	<tr>
		<td><?php echo h($StoryLineList['StoryLineList']['name']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('controller' => 'ComicStoryLines', 'action' => 'view', $StoryLineList['StoryLineList']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $StoryLineList['StoryLineList']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Story Line'), array('action' => 'add')); ?></li>
	</ul>
	<?php echo $this->element('search'); ?>
</div>
