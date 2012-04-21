<?php
class User extends AppModel
{
  var $name = 'User';

  var $validate = array (
    'username' => array (
      'rule' => '/^[a-z0-9]{6,40}$/i',
      'message' => 'This field must have between 6 and 40 alphanumeric characters.'
    ),
    'password' => array (
      'rule' => '/^[a-z0-9]{6,40}$/i',
      'message' => 'This field must have between 6 and 40 alphanumeric characters.'
    ),
    'email' => array(
      'rule' => 'email',
      'message' => 'Please supply a valid email address.'
     )
  );

  function beforeValidate() {
    if (!$this->id) {
      if ($this->findByUsername($this->data['User']['username'])) {
        $this->invalidate('username_unique');
        return false;
      }
    }
    return true;
  }
}
?>
