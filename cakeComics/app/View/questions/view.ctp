<div class="questions view">
<h2><?php  echo __('Question');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($question['Question']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Submitter'); ?></dt>
		<dd>
			<?php echo h($question['Question']['submitter']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sorting'); ?></dt>
		<dd>
			<?php echo h($question['Question']['sorting']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Own Filters'); ?></dt>
		<dd>
			<?php echo h($question['Question']['own_filters']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pre Made Filters'); ?></dt>
		<dd>
			<?php echo h($question['Question']['pre_made_filters']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Software Install'); ?></dt>
		<dd>
			<?php echo h($question['Question']['software_install']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Database Preference'); ?></dt>
		<dd>
			<?php echo h($question['Question']['database_preference']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delete Option'); ?></dt>
		<dd>
			<?php echo h($question['Question']['delete_option']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delete Duplicates'); ?></dt>
		<dd>
			<?php echo h($question['Question']['delete_duplicates']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Requests'); ?></dt>
		<dd>
			<?php echo h($question['Question']['requests']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Question'), array('action' => 'edit', $question['Question']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Question'), array('action' => 'delete', $question['Question']['id']), null, __('Are you sure you want to delete # %s?', $question['Question']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('action' => 'add')); ?> </li>
	</ul>
</div>
