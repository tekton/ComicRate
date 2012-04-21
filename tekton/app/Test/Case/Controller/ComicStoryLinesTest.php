<?php
/* ComicStoryLines Test cases generated on: 2011-09-10 16:25:41 : 1315697141*/
App::uses('ComicStoryLines', 'Controller');

/**
 * TestComicStoryLines 
 *
 */
class TestComicStoryLines extends ComicStoryLines {
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
 * ComicStoryLines Test Case
 *
 */
class ComicStoryLinesTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.comic_story_line');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->ComicStoryLines = new TestComicStoryLines();
		$this->Comic->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ComicStoryLines);
		ClassRegistry::flush();

		parent::tearDown();
	}

}
