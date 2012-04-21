<?php
/**
 * Comic Model
 *
 */
class Comic extends AppModel {

	var $virtualFields = array(
		'cField' => "count(*)"
	);

}
