<p>Please fill out the form below to register an account.</p>

<?php

	echo $this->Form->create('Question', array('action' => 'questions'));

	echo $this->Form->input('Question.submitter');
	echo $this->Form->input('Question.sorting', array(
				'label' => 'Do you want a script that sorts your file into sub-directories?',
				'options' => array('Yes' => 'Yes', 'No' => 'No')
			)
		);

	echo $this->Form->input('Question.own_filters', array(
				'label' => 'Do you care about making your own sorting filters?',
				'options' => array('Yes' => 'Yes', 'No' => 'No')
			)
		);
		
	echo $this->Form->input('Question.pre_made_filters', array(
				'label' => 'Would you want the majority of file filters provided?',
				'options' => array('Yes' => 'Yes', 'No' => 'No')
			)
		);

	echo $this->Form->input('Question.software_install', array(
				'label' => 'Do you mind installing server software if needed?',
				'options' => array('Yes' => 'Yes', 'No' => 'No')
			)
		);
		
	echo $this->Form->input('Question.database_preference', array(
				'label' => 'Do you have a database preference?',
				'options' => array('Either' => 'Whatever', 'MySQL' => 'MySQL', 'PostgreSQL' => 'PostgreSQL')
			)
		);

	echo $this->Form->input('Question.delete_option', array(
				'label' => 'Do you want a "delete" file option?',
				'options' => array('Yes' => 'Yes', 'No' => 'No')
			)
		);

	echo $this->Form->input('Question.delete_duplicates', array(
				'label' => 'Do you want a delete duplicate file option?',
				'options' => array('Yes' => 'Yes', 'No' => 'No')
			)
		);
		
    echo $this->Form->input('Question.requests', array('rows' => '6', 'label' => 'Feature Requests'));
	
	echo $this->Form->end('Answer');
?>
