<div class="comics view">
<h2><?php  echo __('Comic');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('File Location'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['file_location']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Review'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['review']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Manual'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['manual']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('File Name'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['file_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Number'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Edition'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['edition']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Volume'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['volume']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Main'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['main']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Physical'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['physical']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Issue Title'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['issue_title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Storyline'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['storyline']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Need'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['need']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('NeedD'); ?></dt>
		<dd>
			<?php echo h($comic['Comic']['needD']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Comic'), array('action' => 'edit', $comic['Comic']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Comic'), array('action' => 'delete', $comic['Comic']['id']), null, __('Are you sure you want to delete # %s?', $comic['Comic']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Comics'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comic'), array('action' => 'add')); ?> </li>
	</ul>
</div>
