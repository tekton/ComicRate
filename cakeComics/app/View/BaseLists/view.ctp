<div class="baseLists view">
<h2><?php  echo __('Base List');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('File Location'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['file_location']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Review'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['review']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Manual'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['manual']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('File Name'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['file_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Number'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Edition'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['edition']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Volume'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['volume']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Main'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['main']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Physical'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['physical']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Issue Title'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['issue_title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Storyline'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['storyline']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Need'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['need']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('NeedD'); ?></dt>
		<dd>
			<?php echo h($baseList['BaseList']['needD']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Base List'), array('action' => 'edit', $baseList['BaseList']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Base List'), array('action' => 'delete', $baseList['BaseList']['id']), null, __('Are you sure you want to delete # %s?', $baseList['BaseList']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Base Lists'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Base List'), array('action' => 'add')); ?> </li>
	</ul>
	<?php echo $this->element('search'); ?>
</div>
