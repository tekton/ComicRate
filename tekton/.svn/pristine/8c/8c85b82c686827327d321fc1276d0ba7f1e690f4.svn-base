<?php
class Question extends AppModel
{
  var $name = 'Question';

  var $validate = array (
    'submitter' => array (
      'rule' => '/^[a-z0-9]{1,40}$/i',
      'message' => 'This field must have between 1 and 40 alphanumeric characters.'
    ),
    'requests' => array(
      'rule' => 'notEmpty',
      'message' => 'Please specify a feature request or your most important feature.'
     )
  );
  
	/* Shamelessly stolen from: http://www.24hourapps.com/2009/01/simplifying-session-variable-access-in.html */
	function beforeFilter() {
		// Get session data for appllication use
		$this->app = $this->Session->read();
	} 

	function beforeRender() {
		// Make app variables available to view
		$this->set('app', $this->app);
	}

}
?>
