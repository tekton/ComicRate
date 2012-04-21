<div class="questions form">
<?php echo $this->Form->create('Question');?>
	<fieldset>
		<legend><?php echo __('Add Question'); ?></legend>
	<?php
		echo $this->Form->input('submitter');
		echo $this->Form->input('sorting');
		echo $this->Form->input('own_filters');
		echo $this->Form->input('pre_made_filters');
		echo $this->Form->input('software_install');
		echo $this->Form->input('database_preference');
		echo $this->Form->input('delete_option');
		echo $this->Form->input('delete_duplicates');
		echo $this->Form->input('requests');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Questions'), array('action' => 'index'));?></li>
	</ul>
</div>
