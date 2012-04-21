<?php
/* BaseLists Test cases generated on: 2011-09-10 10:34:11 : 1315676051*/
App::uses('BaseLists', 'Controller');

/**
 * TestBaseLists 
 *
 */
class TestBaseLists extends BaseLists {
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
 * BaseLists Test Case
 *
 */
class BaseListsTestCase extends CakeTestCase {
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

		$this->BaseLists = new TestBaseLists();
		$this->BaseList->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BaseLists);
		ClassRegistry::flush();

		parent::tearDown();
	}

}
