<div class="baseLists index">
	<h2><?php //pr($this->Session->request->data["BaseList"]["file_name"]);
	echo __('Base Lists');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('file_name');?></th>
		<th><?php echo $this->Paginator->sort('number');?></th>
		<th><?php echo $this->Paginator->sort('main');?></th>
		<th><?php echo $this->Paginator->sort('need');?></th>
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
		<td class="actions">
			<table>
				<tr>
				<td><?php echo $this->Html->link($this->Html->Image("main.png"), array('action' => 'main', $baseList['BaseList']['id']),
					array('escape' => false),
					__('Are you sure you want to make this one main?', $baseList['BaseList']['id'])); ?></td>
				
				<td><?php echo $this->Html->link($this->Html->Image("view.png"), array('action' => 'view', $baseList['BaseList']['id']), array('escape' => false)); ?></td>
				
				<td><?php echo $this->Html->link($this->Html->Image("edit.png"), array('action' => 'edit', $baseList['BaseList']['id']), array('escape' => false)); ?></td>
				
				</tr>
				<tr>
				
				<td><?php echo $this->Html->link($this->Html->Image("file.png"), $title, array('escape' => false)); ?></td>
				
				<td><?php echo $this->Html->link($this->Html->Image("directory.png"), $linky, array('escape' => false)); ?></td>
				
				<td><?php echo $this->Form->postLink($this->Html->Image("delete.png"),
					array('action' => 'delete', $baseList['BaseList']['id']),
					array('escape' => false),
					__('Are you sure you want to delete # %s?', $baseList['BaseList']['id'])); ?></td>
					
				</tr>
			</table>
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
		<li><?php echo $this->Html->link(__('New Base List'), array('action' => 'add')); ?></li>
	</ul>
	<?php echo $this->element('search'); ?>
</div>
