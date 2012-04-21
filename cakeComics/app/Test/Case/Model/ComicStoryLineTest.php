<?php
/* ComicStoryLine Test cases generated on: 2011-09-10 16:25:17 : 1315697117*/
App::uses('ComicStoryLine', 'Model');

/**
 * ComicStoryLine Test Case
 *
 */
class ComicStoryLineTestCase extends CakeTestCase {
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

		$this->ComicStoryLine = ClassRegistry::init('ComicStoryLine');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ComicStoryLine);
		ClassRegistry::flush();

		parent::tearDown();
	}

}
