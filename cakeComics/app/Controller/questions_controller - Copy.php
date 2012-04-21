<?php
class QuestionsController extends AppController
{
  var $name = 'Questions';

  var $helpers = array('Form' );

	function questions() {
		if (!empty($this->data)) {
			if ($this->Question->save($this->data)) {
				$this->Session->setFlash('Your questionaire information was accepted!', 'default', array('class' => "notice success"));
				$this->Session->write("eyeD",$this->Question->getLastInsertID());
				$this->redirect('./update/'.$this->Session->read("eyeD"));
			} else {
				$this->Session->setFlash('Your questionaire information was not accepted. Please review for any errors.');
			}
		}
	}
 
	function update() {
		
	}
 
	function index() {
		$this->redirect('./questions');
	}
  
}
?>
