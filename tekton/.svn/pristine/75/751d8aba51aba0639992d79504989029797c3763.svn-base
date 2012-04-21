<div class="baseLists index">
	<h2><?php //pr($this->Session->request->data["BaseList"]["file_name"]);
	echo $this->Form->create('BaseList', array("type" => "post", "action" => "bulk/".$s_str));
	echo __('Base Lists');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('file_name');?></th>
		<th><?php echo $this->Paginator->sort('number');?></th>
		<th><?php echo $this->Paginator->sort('main');?></th>
		<th><?php echo $this->Paginator->sort('need');?></th>
		<th><?php echo $this->Paginator->sort('file_location');?></th>
		<th class="actions" style="text-align: center;"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($baseLists as $baseList): ?>
	<tr>
		<td><?php echo substr(h($baseList['BaseList']['file_name']), 0, 50); if(strlen(h($baseList['BaseList']['file_name'])) > 50) {echo "...";} ?>&nbsp;</td>
		<td><?php echo h($baseList['BaseList']['number']); ?>&nbsp;</td>
		<?php
			
			$pi = pathinfo($baseList['BaseList']['file_location']);
			//pr($pi);
			
			$dir = preg_replace("/\.\.\/\.\.\/\.\./i", "", $pi["dirname"]);
			
			$linky = "comics/".$pi["dirname"];
			$title = "comics/".$baseList['BaseList']['file_location'];
				if(strlen($dir) >= 72) {
					$dir = substr($dir, 0, 75);
					$dir .= "...";
				}
			//echo $this->Html->link($dir, $linky);
			?>
		<td><?php echo h($baseList['BaseList']['main']); ?>&nbsp;</td>
		<td><?php echo h($baseList['BaseList']['need']); ?>&nbsp;</td>
		<td><?php echo preg_replace("/\.\.\/\.\.\/\.\./i", "", h($baseList['BaseList']['file_location'])); ?>&nbsp;</td>
		<td class="actions">
			

				<?php echo $this->Html->link($this->Html->Image("main.png"), array('action' => 'main', $baseList['BaseList']['id'], $s_str),
					array('escape' => false),
					__('Are you sure you want to make this one main?', $baseList['BaseList']['id'])); ?>				
				<?php echo $this->Html->link($this->Html->Image("view.png"), array('action' => 'view', $baseList['BaseList']['id']), array('escape' => false)); ?>				
				<?php echo $this->Html->link($this->Html->Image("edit.png"), array('action' => 'edit', $baseList['BaseList']['id']), array('escape' => false)); ?>				
				<?php echo $this->Html->link($this->Html->Image("file.png"), $title, array('escape' => false)); ?>				
				<?php echo $this->Html->link($this->Html->Image("directory.png"), $linky, array('escape' => false)); ?>				
				<?php echo $this->Html->link($this->Html->Image("delete.png"),
					array('action' => 'delete', $baseList['BaseList']['id'], $s_str),
					array('escape' => false),
					__('Are you sure you want to delete # %s?', $baseList['BaseList']['id']));
				?>
				
				<?php
					//echo $this->Form->checkbox("c_ids[".$baseList["BaseList"]["id"]."]", array('value' => $baseList['BaseList']['id'], 'hiddenField' => false, 'multiple'=>'checkbox'));
					echo '<input type="checkbox" name="c_ids[]"  value="'.$baseList['BaseList']['id'].'" />';
				?>
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
	
	<div style="text-align: right; margin-top: 25px;">
	<?php 
	
		echo $this->Form->input('action_type', array(
			'label' => 'Mass Action',
			'options' => array('copy' => 'Copy to transferMe', 'delete' => 'Delete', 'rename' => 'Add to Rename Queue [NYI]', 'series' => 'Add to a series (select below)')
		));
	
		echo $this->Form->input('series', array(
			'label' => 'Add to Series',
			'options' => array($series)
		));
		
	
	echo $js = "<script type='text/javascript'> 
			$(function () {
				$('#checkall').click(function () {
					$('[type=checkbox]').each(function(index) {
						$( this ).attr( 'checked', $( this ).is( ':checked' ) ? '' : 'checked' );
					});
				});
				
			});
			</script>";
	echo "<div id='checkall'>Check all files</div>";
	echo $this->Form->end(__('Submit'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Base List'), array('action' => 'add')); ?></li>
	</ul>
	<?php echo $this->element('search'); ?>
</div>
