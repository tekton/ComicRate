<?php
/* Questions Test cases generated on: 2011-09-10 10:21:58 : 1315675318*/
App::uses('Questions', 'Controller');

/**
 * TestQuestions 
 *
 */
class TestQuestions extends Questions {
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
 * Questions Test Case
 *
 */
class QuestionsTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.question');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Questions = new TestQuestions();
		$this->Question->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Questions);
		ClassRegistry::flush();

		parent::tearDown();
	}

}
