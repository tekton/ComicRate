<div class="comics index">
	<div>
		<div class="notice success">Application table installed correctly</div>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Comic'), array('action' => 'add')); ?></li>
	</ul>
	<?php echo $this->element('search'); ?>
</div>
