<div class="ComicStoryLines form">
<?php echo $this->Form->create('ComicStoryLines');?>
	<fieldset>
		<legend><?php echo __("Edit $storyLineTitle"); ?></legend>
	<?php
		
		echo '<script>
				$(function() {
					$( "#sortable" ).sortable();
					$( "#sortable" ).disableSelection();
				});
				</script>';
		
		echo '<ul id="sortable">';
		foreach($issues as $issue) {
			
				echo '<li class="ui-state-default" style="border: 1px solid #aed0ea; background: #d7ebf9 url(images/ui-bg_glass_80_d7ebf9_1x400.png) 50% 50% repeat-x; font-weight: bold; color: #2779aa;"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>';
				
				echo $issue["Comics"]["file_name"]." - ".$issue["Comics"]["number"];
				
				echo "<input type=\"hidden\" name=\"order[]\" value=\"". $issue["ComicStoryLine"]["id"] ."\" />";
				
				echo '</li>';
		}
		echo "</ul>";
	?>
	</fieldset>
<?php
	echo $this->Form->end(__('Submit'));
	echo $this->Html->link(__('Copy Storyline'), array('action' => 'copy', "$storyline"));
?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Story Lists'), array('action' => 'index'));?></li>
	</ul>
	<?php echo $this->element('search'); ?>
</div>