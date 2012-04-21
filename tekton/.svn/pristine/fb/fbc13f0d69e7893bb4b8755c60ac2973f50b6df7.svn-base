<?php
pr(get_html_translation_table(HTML_ENTITIES));
?>

<div class="comics index">
	<div>
		Please click on the folder that you would like to have processed and added to the database. These are based on the folders present and can take up to and over ten minutes to process.
		<ul>
			<?php
				$i = 0;
				foreach ($folders as $folder): ?>
			<li><?php echo $this->Html->link(h($folder),
								array('action' => 'process', "folder:$folder")); 
			
			
			?></li>
			<?php endforeach; ?>
		</ul>
		<div style="margin-top: 20px;">
		<?php echo $this->Html->link("View duplicates for possible processing",
								array('action' => 'duplicates')); ?>
		</div>
		
		<div style="margin-top: 20px;">
		<?php echo $this->Html->link("Check to make sure files in the database still exist",
								array('controller'=>'base_lists','action' => 'file_checks')); ?>
		</div>
		
				<div style="margin-top: 20px;">
		<?php echo $this->Html->link("Remove duplicates of items that have a Main issue set",
								array('controller'=>'base_lists','action' => 'auto_duplicate_proc')); ?>
		</div>
		
		<div style="margin-top: 20px;">
		<?php echo $this->Html->link("Checkout and create a storyline",
								array('controller'=>'StoryLineLists','action' => 'index')); ?>
		</div>
		
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Comic'), array('action' => 'add')); ?></li>
	</ul>
	<?php echo $this->element('search'); ?>
</div>
