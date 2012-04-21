<?php
/* ComicStoryLine Fixture generated on: 2011-09-10 16:25:17 : 1315697117 */

/**
 * ComicStoryLineFixture
 *
 */
class ComicStoryLineFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'storyline' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'number' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'issue_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'issue_number' => array('type' => 'float', 'null' => true, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'issue_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'storyline' => 'Lorem ipsum dolor sit amet',
			'number' => 1,
			'issue_name' => 'Lorem ipsum dolor sit amet',
			'issue_number' => 1,
			'issue_id' => 1
		),
	);
}
