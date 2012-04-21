<div class="comics form">
<?php echo $this->Form->create('Comic');?>
	<fieldset>
		<legend><?php echo __('Edit Comic'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('file_location');
		echo $this->Form->input('review');
		echo $this->Form->input('manual');
		echo $this->Form->input('file_name');
		echo $this->Form->input('number');
		echo $this->Form->input('edition');
		echo $this->Form->input('volume');
		echo $this->Form->input('main');
		echo $this->Form->input('physical');
		echo $this->Form->input('issue_title');
		echo $this->Form->input('storyline');
		echo $this->Form->input('need');
		echo $this->Form->input('needD');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Comic.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Comic.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Comics'), array('action' => 'index'));?></li>
	</ul>
</div>
