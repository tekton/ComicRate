<?php
class UsersController extends AppController
{
  var $name = 'Users';

  var $helpers = array('Form' );

  function register()
  {
    if (!empty($this->data))
    {
      if ($this->User->save($this->data))
      {
        $this->Session->setFlash('Your registration information was accepted.');
      }
    }
  }

  function knownusers()
  {
    $this->set('knownusers', $this->User->find(
      'all', 
      array(
        'fields' => array('id','username', 'first_name', 'last_name'), 
        'order' => 'id DESC'
      )
    ));
  }
}
?>
