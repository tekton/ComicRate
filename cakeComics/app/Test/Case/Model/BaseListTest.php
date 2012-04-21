<?php
/* BaseList Test cases generated on: 2011-09-10 10:33:23 : 1315676003*/
App::uses('BaseList', 'Model');

/**
 * BaseList Test Case
 *
 */
class BaseListTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.base_list');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->BaseList = ClassRegistry::init('BaseList');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BaseList);
		ClassRegistry::flush();

		parent::tearDown();
	}

}
