<div id='search_area'>
	<h3><?php echo __('Simple Search'); ?></h3>
	<?php		
		echo $this->Form->create('BaseList', array("action" => "search", "type" => "post"));
			$name =	$this->passedArgs["name"];
			$name = preg_replace("/%20/", " ", $name);//file_name
		echo $this->Form->input('file_name', array("value" => $name));
		echo $this->Form->input('BaseList.minimum', array("value" => $this->passedArgs["min"]));
		echo $this->Form->input('BaseList.maximum', array("value" => $this->passedArgs["max"]));
		
			$loc = $this->passedArgs["loc"];
			$loc = preg_replace("/%20/", " ", $loc);//file_name
		
		echo $this->Form->input('file_location', array("value" => $loc));

		echo $this->Form->input('main', array(
				'label' => 'Main Copy',
				'options' => array('NULL' => '', '1' => 'Yes', '0' => 'No'),
				'selected' => $this->passedArgs["main"])
			);		

		echo $this->Form->input('physical', array(
				'label' => 'Own Physical',
				'options' => array('NULL' => '', '1' => 'Yes', '0' => 'No'),
				'selected' => $this->passedArgs["physical"])
			);
		
		echo $this->Form->input('need', array(
				'label' => 'Need Physical',
				'options' => array('NULL' => '', '1' => 'Yes', '0' => 'No'),
				'selected' => $this->passedArgs["need"])
			);
		
		echo $this->Form->input('needD', array(
				'label' => 'Need Didgital',
				'options' => array('NULL' => '', '1' => 'Yes', '0' => 'No'),
				'selected' => $this->passedArgs["needD"])
			);
		
		
		echo $this->Form->input('name_type', array(
				'label' => 'Name Matching',
				'options' => array('contains' => 'Contains', 'exact' => 'Exactly', 'starts' => 'Starts With', 'ends' => 'Ends With'),
				'selected' => $this->passedArgs["name_type"])
			);
		
		echo $this->Form->end(__('Submit'));
	?>
</div>