<?php
/* LogSearches Test cases generated on: 2011-09-17 11:43:29 : 1316285009*/
App::uses('LogSearches', 'Controller');

/**
 * TestLogSearches 
 *
 */
class TestLogSearches extends LogSearches {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * LogSearches Test Case
 *
 */
class LogSearchesTestCase extends CakeTestCase {
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

		$this->LogSearches = new TestLogSearches();
		$this->L->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LogSearches);
		ClassRegistry::flush();

		parent::tearDown();
	}

}
