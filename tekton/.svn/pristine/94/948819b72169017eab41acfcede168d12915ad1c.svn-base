<?php
/**
 * StoryLineLists Controller
 *
 * @property StoryLineList $StoryLineList
 */
class StoryLineListsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->StoryLineList->recursive = 0;
		$this->set('StoryLineLists', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->StoryLineList->id = $id;
		if (!$this->StoryLineList->exists()) {
			throw new NotFoundException(__('Invalid comic story line'));
		}
		$this->set('StoryLineList', $this->StoryLineList->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->StoryLineList->create();
			if ($this->StoryLineList->save($this->request->data)) {
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
		$this->StoryLineList->id = $id;
		if (!$this->StoryLineList->exists()) {
			throw new NotFoundException(__('Invalid comic story line'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->StoryLineList->save($this->request->data)) {
				$this->Session->setFlash(__('The comic story line has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comic story line could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->StoryLineList->read(null, $id);
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
		$this->StoryLineList->id = $id;
		if (!$this->StoryLineList->exists()) {
			throw new NotFoundException(__('Invalid comic story line'));
		}
		if ($this->StoryLineList->delete()) {
			$this->Session->setFlash(__('Comic story line deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Comic story line was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function drop_down_list() {
		pr("Look a d_d_l");
		// slightly break the MVC model to just create the html needed for the drop down list
		$this->StoryLineList->create();
		$list = $this->StoryLineList->find('all');
		pr($list);
		
		$rtn_str = "<select name='series'>";
		foreach($list as $item) {
			$id = $item["StoryLineList"]["id"];
			$na = $item["StoryLineList"]["name"];
			
			$rtn_str .= "<option value='$id'>$name</option>";
		}
		$rtn_str .= "</select>";
		
		$this->set("sdd", $rtn_str);
		
		return $rtn_str;
	}
}