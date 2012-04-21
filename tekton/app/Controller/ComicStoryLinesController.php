<?php
/**
 * ComicStoryLines Controller
 *
 * @property ComicStoryLine $ComicStoryLine
 */
class ComicStoryLinesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ComicStoryLine->recursive = 0;
		
		$sereies = $this->get_all_series();
		$this->set('sereies', $sereies);
		
		$this->paginate = array(
			'fields' => array('distinct(storyline)'),
			'Group By' => 'storyline',
			'limit' => 15
		);
		//$this->set('baseLists', $this->paginate("BaseList", $q));
		$this->set('comicStoryLines', $this->paginate('ComicStoryLine'));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		
		
		if ($this->request->is('post')) {
			//pr($this->request);
			
			$this->ComicStoryLine->create();
			
			/*** update ComicStoryLine.number = $this->data->order ***/
			
			//pr($this->request->data["order"]);
			
			foreach($this->request->data["order"] as $key => $csl_id) {
				pr($key." -- ".$csl_id);
				
				$this->ComicStoryLine->create();
				
				$this->ComicStoryLine->updateAll(
					array('ComicStoryLine.number' => $key),
					array('ComicStoryLine.id =' => $csl_id)
				);
			}
		}
		
		$this->ComicStoryLine->create();
		
		$options['joins'] = array(
			array('table' => 'comics',
				'alias' => 'Comics',
				'type' => 'LEFT',
				'conditions' => array(
					'ComicStoryLine.issue_id = Comics.id',
				)
			)
		);

		$options['fields'] = array (
			"ComicStoryLine.id, ComicStoryLine.issue_id, ComicStoryLine.number, Comics.file_name, Comics.number"
		);
		
		$options['conditions'] = array(
			'ComicStoryLine.storyline' => $id
		);
		
		$options['order'] = array(
			'ComicStoryLine.number'
		);
		
		$list = $this->ComicStoryLine->find('all', $options);
		
		$series = $this->get_series($id);
		pr($series);
		
		$this->set('storyLineTitle', $series);
		$this->set('issues', $list);
		
		$this->set('storyline', $id);
		
		pr($list);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ComicStoryLine->create();
			if ($this->ComicStoryLine->save($this->request->data)) {
				$this->Session->setFlash(__('The comic story line has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comic story line could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ComicStoryLine->id = $id;
		if (!$this->ComicStoryLine->exists()) {
			throw new NotFoundException(__('Invalid comic story line'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ComicStoryLine->save($this->request->data)) {
				$this->Session->setFlash(__('The comic story line has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comic story line could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ComicStoryLine->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->ComicStoryLine->id = $id;
		if (!$this->ComicStoryLine->exists()) {
			throw new NotFoundException(__('Invalid comic story line'));
		}
		if ($this->ComicStoryLine->delete()) {
			$this->Session->setFlash(__('Comic story line deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Comic story line was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function get_series($s) {
	
		pr("get_series :: $s");
	
		$this->loadModel('StoryLineList');
		$this->StoryLineList->create();
		$list = $this->StoryLineList->findById($s);
		$ss = "";
			foreach($list as $item) {
				//pr($item);
				$ss = $item["name"];
			}
		pr($ss);
		$this->set('series', $ss);
		
		return $ss;
	}
	
	public function get_all_series() {
		$this->loadModel('StoryLineList');
		$this->StoryLineList->create();
		$list = $this->StoryLineList->find('all');
		
		$sereies = array();
		
		foreach($list as $item) {
			pr($item);
			$sereies[$item["StoryLineList"]["id"]] = $item["StoryLineList"]["name"];
		}
		
		return $sereies;
	}
	
	public function copy($id = null) {
		//get the list of items...
		$options['joins'] = array(
			array('table' => 'comics',
				'alias' => 'Comics',
				'type' => 'LEFT',
				'conditions' => array(
					'ComicStoryLine.issue_id = Comics.id',
				)
			),
			array('table' => 'story_line_list',
				'alias' => 'SLL',
				'type' => 'LEFT',
				'conditions' => array(
					'ComicStoryLine.storyline = SLL.id',
				)
			)
		);

		$options['fields'] = array (
			"ComicStoryLine.id, ComicStoryLine.issue_id, ComicStoryLine.number, Comics.file_name, Comics.number, SLL.name, Comics.file_location"
		);
		
		$options['conditions'] = array(
			'ComicStoryLine.storyline' => $id
		);
		
		$options['order'] = array(
			'ComicStoryLine.number'
		);
		
		$list = $this->ComicStoryLine->find('all', $options);

		
		$series = $this->get_series($id);
		$this->set('storyLineTitle', $series);
		$this->set('issues', $list);
		$this->set('storyline', $id);

		pr($list);
		
		$copy_log = array();
		$c_issue = 0;
		
		foreach($list as $issue) {
			$pi = pathinfo($issue["Comics"]["file_location"]);
			$i_name = $issue["SLL"]["name"]." ".$issue["ComicStoryLine"]["number"]." - ".$issue["Comics"]["file_name"]." ".$issue["Comics"]["number"].".".$pi["extension"];
			pr($i_name);
			
			$file_to_copy = $issue["Comics"]["file_location"];
			$dest="../../../transferMe/$i_name";
			
			if (!copy($file_to_copy, $dest)) {
			//$rtn_str .= "failed to copy $loc to $dest...</h3>";
				$copy_log[] = "Unable to copy ".$i_name;
				$c_issue++;
			} else {
				$copy_log[] = "Copied ".$i_name;
			}
		}
		
		if($c_issue > 0) {
			$this->Session->setFlash("Some items weren't able to be copied",'default');
		}
		else {
			$this->Session->setFlash("All files copied successfuly!",'default', array('class' => 'notice success'));
		}
		
		$this->redirect(array('action' => 'view', $id));
	}
}