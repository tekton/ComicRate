<?php
/* Comic Test cases generated on: 2011-09-10 16:26:30 : 1315697190*/
App::uses('Comic', 'Model');

/**
 * Comic Test Case
 *
 */
class ComicTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.comic');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Comic = ClassRegistry::init('Comic');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Comic);
		ClassRegistry::flush();

		parent::tearDown();
	}

}
