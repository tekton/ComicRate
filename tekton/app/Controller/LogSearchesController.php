<?php
/**
 * LogSearches Controller
 *
 * @property LogSearch $LogSearch
 */
class LogSearchesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->LogSearch->recursive = 0;
		$this->set('logSearches', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->LogSearch->id = $id;
		if (!$this->LogSearch->exists()) {
			throw new NotFoundException(__('Invalid log search'));
		}
		$this->set('logSearch', $this->LogSearch->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->LogSearch->create();
			if ($this->LogSearch->save($this->request->data)) {
				$this->Session->setFlash(__('The log search has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The log search could not be saved. Please, try again.'));
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
		$this->LogSearch->id = $id;
		if (!$this->LogSearch->exists()) {
			throw new NotFoundException(__('Invalid log search'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->LogSearch->save($this->request->data)) {
				$this->Session->setFlash(__('The log search has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The log search could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->LogSearch->read(null, $id);
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
		$this->LogSearch->id = $id;
		if (!$this->LogSearch->exists()) {
			throw new NotFoundException(__('Invalid log search'));
		}
		if ($this->LogSearch->delete()) {
			$this->Session->setFlash(__('Log search deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Log search was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
