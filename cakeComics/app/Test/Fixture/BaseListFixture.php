<?php
/* BaseList Fixture generated on: 2011-09-10 10:33:23 : 1315676003 */

/**
 * BaseListFixture
 *
 */
class BaseListFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'base_list';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'file_location' => array('type' => 'string', 'null' => true, 'default' => NULL, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'review' => array('type' => 'string', 'null' => true, 'default' => 'yes', 'length' => 45, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'manual' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'file_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'number' => array('type' => 'float', 'null' => true, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'edition' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'volume' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'main' => array('type' => 'binary', 'null' => true, 'default' => '0', 'length' => 1, 'collate' => NULL, 'comment' => ''),
		'physical' => array('type' => 'binary', 'null' => true, 'default' => '0', 'length' => 1, 'collate' => NULL, 'comment' => ''),
		'issue_title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'storyline' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'need' => array('type' => 'binary', 'null' => true, 'default' => NULL, 'length' => 1, 'collate' => NULL, 'comment' => ''),
		'needD' => array('type' => 'binary', 'null' => true, 'default' => NULL, 'length' => 1, 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'file_location_UNIQUE' => array('column' => 'file_location', 'unique' => 1)),
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
			'file_location' => 'Lorem ipsum dolor sit amet',
			'review' => 'Lorem ipsum dolor sit amet',
			'manual' => 'Lorem ipsum dolor sit amet',
			'file_name' => 'Lorem ipsum dolor sit amet',
			'number' => 1,
			'edition' => 'Lorem ipsum dolor sit amet',
			'volume' => 'Lorem ipsum dolor sit amet',
			'main' => 'Lorem ipsum dolor sit ame',
			'physical' => 'Lorem ipsum dolor sit ame',
			'issue_title' => 'Lorem ipsum dolor sit amet',
			'storyline' => 'Lorem ipsum dolor sit amet',
			'need' => 'Lorem ipsum dolor sit ame',
			'needD' => 'Lorem ipsum dolor sit ame'
		),
	);
}
