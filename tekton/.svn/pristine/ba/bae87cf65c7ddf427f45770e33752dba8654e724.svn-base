<?php
/* Comics Test cases generated on: 2011-09-10 17:09:47 : 1315699787*/
App::uses('Comics', 'Controller');

/**
 * TestComics 
 *
 */
class TestComics extends Comics {
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
 * Comics Test Case
 *
 */
class ComicsTestCase extends CakeTestCase {
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

		$this->Comics = new TestComics();
		$this->Co->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Comics);
		ClassRegistry::flush();

		parent::tearDown();
	}

}
