<?php
/* LogSearch Test cases generated on: 2011-09-17 11:42:43 : 1316284963*/
App::uses('LogSearch', 'Model');

/**
 * LogSearch Test Case
 *
 */
class LogSearchTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.log_search');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->LogSearch = ClassRegistry::init('LogSearch');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LogSearch);
		ClassRegistry::flush();

		parent::tearDown();
	}

}
