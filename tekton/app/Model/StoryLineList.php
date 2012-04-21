<?php
/**
 * StoryLineList Model
 *
 */
class StoryLineList extends AppModel {

	var $helpers = array('Session', 'Form', 'HTML', 'Time', 'JsHelper' );

	public $useTable = 'story_line_list';
	public $displayField = 'name';

}
