<div id='search_area'>
	<h3><?php echo __('Simple Search'); ?></h3>
	<?php		
		echo $this->Form->create('BaseList', array("action" => "search", "type" => "post"));
		echo $this->Form->input('file_name', array("value" => preg_replace("/NULL/", "", $this->params->pass[0])));
		echo $this->Form->input('BaseList.minimum', array("value" => preg_replace("/NULL/", "", $this->params->pass[1])));
		echo $this->Form->input('BaseList.maximum', array("value" => preg_replace("/NULL/", "", $this->params->pass[2])));
		echo $this->Form->input('file_location', array("value" => preg_replace("/NULL/", "", $this->params->pass[3])));
		echo $this->Form->input('main', array("value" => preg_replace("/NULL/", "", $this->params->pass[5])));
		echo $this->Form->input('physical', array("value" => preg_replace("/NULL/", "", $this->params->pass[4])));
		echo $this->Form->input('need', array("value" => preg_replace("/NULL/", "", $this->params->pass[6])));
		echo $this->Form->input('needD', array("value" => preg_replace("/NULL/", "", $this->params->pass[7])));
		echo $this->Form->end(__('Submit'));
	?>
</div>