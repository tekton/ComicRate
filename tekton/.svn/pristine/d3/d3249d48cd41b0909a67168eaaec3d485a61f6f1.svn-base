<?php
/**
 * BaseList Model
 *
 */
class BaseList extends AppModel {

var $helpers = array('Session', 'Form', 'HTML', 'Time', 'JsHelper' );

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'comics';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'dField';
	
	var $virtualFields = array(
		'dField' => "CONCAT(BaseList.file_name, ' ', BaseList.number)"
	);

	
}
