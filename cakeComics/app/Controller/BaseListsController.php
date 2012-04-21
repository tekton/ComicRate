<?php
/**
 * BaseLists Controller
 *
 * @property BaseList $BaseList
 */
class BaseListsController extends AppController {

var $paginate = array('limit' => 20);
var $namedArgs = TRUE; 

/**
 * index method
 *
 * @return void
 */
	public function index() {
		//pr($this->request);
		$this->BaseList->recursive = 0;
		$this->set('baseLists', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->BaseList->id = $id;
		if (!$this->BaseList->exists()) {
			throw new NotFoundException(__('Invalid base list'));
		}
		$this->set('baseList', $this->BaseList->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->BaseList->create();
			if ($this->BaseList->save($this->request->data)) {
				$this->Session->setFlash(__('The base list has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The base list could not be saved. Please, try again.'));
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
		$this->BaseList->id = $id;
		if (!$this->BaseList->exists()) {
			throw new NotFoundException(__('Invalid base list'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->BaseList->save($this->request->data)) {
				$this->Session->setFlash(__('The base list has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The base list could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->BaseList->read(null, $id);
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
		$this->BaseList->id = $id;
		if (!$this->BaseList->exists()) {
			throw new NotFoundException(__('Invalid base list'));
		}
		if ($this->BaseList->delete()) {
			$this->Session->setFlash(__('Base list deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Base list was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * search method
 *
 * @param NONE - uses form data
 * @return void
 */	
	
	public function search() {
		pr($this->passedArgs);
		//pr($this->request->data);
	
		if ($this->request->is('post')) {
			pr($this->request->data);
			$name = $this->request->data["BaseList"]["file_name"];
				if($name=="") {$name = "NULL";}
			$min = $this->request->data["BaseList"]["minimum"];
				if($min=="") {$min = "NULL";}
			$max = $this->request->data["BaseList"]["maximum"];
				if($max=="") {$max = "NULL";}
			
			$loc = $this->request->data["BaseList"]["file_location"];
				if($loc=="") {$loc = "NULL";}
			
			$physical = $this->request->data["BaseList"]["physical"];
				if($physical=="") {$physical = "NULL";}
			
			$main = $this->request->data["BaseList"]["main"];
				if($main=="") {$main = "NULL";}

			$need = $this->request->data["BaseList"]["need"];
				if($need=="") {$need = "NULL";}
				
			$needD = $this->request->data["BaseList"]["needD"];
				if($needD=="") {$needD = "NULL";}
			//echo $name;
			$this->redirect("./search/$name/$min/$max/$loc/$physical/$main/$need/$needD/");
		}
		
		if ($this->request->is('get')) { //there shouldn't be anything "submitting" data through post...so only handle get

			pr($this->params->pass);
			
			$q = array();
			
			$this->BaseList->create();
			
			$name = preg_replace("/ /", "%", $this->params->pass[0]);//file_name
			
			$min =   	$this->params->pass[1];
			$max =   	$this->params->pass[2];
			$loc =   	$this->params->pass[3];	//file_location
			$physical = $this->params->pass[4];	//how many physical copies one has
			$main =  	$this->params->pass[5];	//physical
			$need =  	$this->params->pass[6];	//physical
			$needD = 	$this->params->pass[7];	//didgital
			
			if($name == NULL || $name == "NULL") { $name = "%"; }
			
			if($this->passedArgs["name"]=="exact") {
				$q["file_name LIKE"] =  "$name";
			} else {
				$q["file_name LIKE"] =  "%$name%";
			}
			
			if($min != "" and $min != NULL and $min != "NULL") { $q["number >="] = "$min"; }
			if($max != "" and $max != NULL and $max != "NULL") { $q["number <="] = "$max"; }
			
			if($loc != "" and $loc != NULL and $loc != "NULL") { $q["file_location LIKE"] =  "%$loc%"; }
			
			if($main != "" and $main != NULL and $main != "NULL") { $q["main LIKE"] =  "%$main%"; }
			if($physical != "" and $physical != NULL and $physical != "NULL") { $q["physical LIKE"] =  "%$physical%"; }
			if($need != "" and $need != NULL and $need != "NULL") { $q["need LIKE"] =  "%$need%"; }
			if($needD != "" and $needD != NULL and $needD != "NULL") { $q["needD LIKE"] =  "%$needD%"; }
			
			$this->set('baseLists', $this->paginate("BaseList", $q));
		}
	}
	
	public function search_area() {
	
		echo "<div id='search_area'>
		<h3>";
		echo __('Simple Search');
		echo "</h3>";
			echo $this->Form->create('BaseList', array("action" => "search", "type" => "post"));
			echo $this->Form->input('file_name', array("value" => preg_replace("/NULL/", "", $this->params->pass[0])));
			echo $this->Form->input('BaseList.minimum', array("value" => preg_replace("/NULL/", "", $this->params->pass[1])));
			echo $this->Form->input('BaseList.maximum', array("value" => preg_replace("/NULL/", "", $this->params->pass[2])));
			echo $this->Form->input('file_location', array("value" => preg_replace("/NULL/", "", $this->params->pass[3])));
			echo $this->Form->input('main', array("value" => preg_replace("/NULL/", "", $this->params->pass[4])));
			echo $this->Form->input('physical', array("value" => preg_replace("/NULL/", "", $this->params->pass[5])));
			echo $this->Form->input('need', array("value" => preg_replace("/NULL/", "", $this->params->pass[6])));
			echo $this->Form->input('needD', array("value" => preg_replace("/NULL/", "", $this->params->pass[7])));
			echo $this->Form->end(__('Submit'));
		echo "</div>";
	
	}
}
