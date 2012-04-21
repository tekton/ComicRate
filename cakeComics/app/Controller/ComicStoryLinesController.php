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
		$this->set('comicStoryLines', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ComicStoryLine->id = $id;
		if (!$this->ComicStoryLine->exists()) {
			throw new NotFoundException(__('Invalid comic story line'));
		}
		$this->set('comicStoryLine', $this->ComicStoryLine->read(null, $id));
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
}