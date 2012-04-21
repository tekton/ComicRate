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
				$this->Session->setFlash(__('The comic could not be saved. Please, try again.'));
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
	
		$s_str = $this->create_search_url();
		/* //changed to get is fine due to other UI issues
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		*/
		
		$this->BaseList->id = $this->params->pass[0];
		if (!$this->BaseList->exists()) {
			throw new NotFoundException(__('Invalid base list'));
		}
		
		$file = $this->BaseList->find('first', array('conditions' => array('id' => $id)));
		pr($file["BaseList"]["file_location"]);
		$file_to_delete = $file["BaseList"]["file_location"];
		$pi = pathinfo($file_to_delete);
		$file_name = $pi["basename"];
		
		//FIRST check to make sure it isn't set to a main copy!
		
		if($file["BaseList"]["main"]==1) {
			$this->Session->setFlash(__("$file_name is the main copy of this issue; deletion is now allowed"));
			$this->redirect(array('action' => 'search', $s_str));
		}
		
		if ($this->BaseList->delete()) {
			//now that its removed from the database, also move file to deleteMe folder
			$dest="../../../deleteMe/$file_name";
			pr($dest);
			if (!rename($file_to_delete, $dest)) {
				//$rtn_str .= "failed to copy $loc to $dest...</h3>";
				$this->Session->setFlash(__("$file_name removed from DB but not the file system"));
			} else {
				$this->Session->setFlash(__("$file_name removed from DB and moved to deleteMe"));
			}
		} else {
			if (!rename($file_to_delete, $dest)) {
				//$rtn_str .= "failed to copy $loc to $dest...</h3>";
				$this->Session->setFlash(__("$file_name not removed from DB and not the file system"));
			} else {
				$this->Session->setFlash(__("$file_name not removed from DB and moved to deleteMe"));
			}
		}
		
		$this->redirect(array('action' => 'search', $s_str));
	}
	
	public function delete_logic($id) {
		$this->BaseList->id = $id;

		if (!$this->BaseList->exists()) {
			return 0;
		}
		
		$file = $this->BaseList->find('first', array('conditions' => array('id' => $id)));
		pr($file["BaseList"]["file_location"]);
		$file_to_delete = $file["BaseList"]["file_location"];
		$pi = pathinfo($file_to_delete);
		$file_name = $pi["basename"];
		
		//FIRST check to make sure it isn't set to a main copy!
		
		if($file["BaseList"]["main"]==1) {
			return 1;
		}
		
		if ($this->BaseList->delete()) {
			//now that its removed from the database, also move file to deleteMe folder
			$dest="../../../deleteMe/$file_name";
			pr($dest);
			if (!rename($file_to_delete, $dest)) {
				//$rtn_str .= "failed to copy $loc to $dest...</h3>";
				return 2;
			} else {
				return 3;
			}
		} else {
			if (!rename($file_to_delete, $dest)) {
				//$rtn_str .= "failed to copy $loc to $dest...</h3>";
				return 4;
			} else {
				return 5;
			}
		}
	}
	
	function file_checks() {
		$this->BaseList->create();
		
		$files = $this->BaseList->find('all');
		
		$deleted = array();
		
		foreach($files as $file) {
			//pr($file["BaseList"]);
			
			if (file_exists($file["BaseList"]["file_location"])) {
				//do nothing, it's there!
			} else {
				//try to delete said file
				$this->BaseList->delete($file["BaseList"]["id"]);
				$deleted[] = $file["BaseList"]["file_location"];
			}
		}
		
		$this->set('deleted', $deleted);
	}
	
	public function create_search_url() {
		$name =		$this->passedArgs["name"];
		$min =   	$this->passedArgs["min"];
		$max =   	$this->passedArgs["max"];
		$loc =   	$this->passedArgs["loc"];		//file_location
		$physical = $this->passedArgs["physical"];	//how many physical copies one has
		$main =  	$this->passedArgs["main"];		//physical
		$need =  	$this->passedArgs["need"];		//physical
		$needD = 	$this->passedArgs["needD"];		//didgital
		$name_type=	$this->passedArgs["name_type"];
		
		if($name != NULL || $name != "NULL") { $name = "name:$name/"; }
		
		if($name_type != NULL || $name_type != "NULL") { $name_type = "name_type:$name_type/"; }
		
		if($min != "" and $min != NULL and $min != "NULL") { $min = "min:$min/"; }
		if($max != "" and $max != NULL and $max != "NULL") { $max = "max:$max/"; }
		
		if($loc != "" and $loc != NULL and $loc != "NULL") { $loc = "loc:$loc/"; }
		
		if($main != "" 		and $main != NULL 		and $main != "NULL"		and $main != "0")		{ $main = "main:$main/"; }
		if($physical != "" 	and $physical != NULL	and $physical != "NULL"	and $physical != "0")	{ $physical = "physical:$physical/"; }
		if($need != "" 		and $need != NULL 		and $need != "NULL"		and $need != "0")		{ $need = "need/$need/"; }
		if($needD != "" 	and $needD != NULL 		and $needD != "NULL"	and $needD != "0")		{ $needD = "needD:$needD/"; }
		
		$search_string = "$name$min$max$loc$physical$main$need$needD$name_type";
		return $search_string;
	}
	
	/**
	* set this comics as main
	**/
	
	public function main($id = null) {

		$this->BaseList->create();
		$this->BaseList->id = $id;
		if (!$this->BaseList->exists()) {
			throw new NotFoundException(__('Invalid comic'));
		}
		$q = array("main" => "1");
		$this->BaseList->set($q);
		
		if($this->BaseList->saveField('main', '1')) {
			$this->Session->setFlash(__('Comic was made main!'));
		} else {
			$this->Session->setFlash(__('Comic was not made main'));
		}
		
		$s_str = $this->create_search_url();
		$this->redirect(array('action' => 'search', $s_str));
	}
	
/**
 * search method
 *
 * @param NONE - uses form data
 * @return void
 */	
	
	public function full() { $this->search(); }
	
	public function search() {
		pr($this->passedArgs);
		//pr($this->request->data);
	
		if ($this->request->is('post')) {
			$this->BaseList->create();
			
			$q = array();
		
			pr($this->request->data);
			$name = $this->request->data["BaseList"]["file_name"];
				if($name!="") {
					$q["name"] = "$name";
					$name = "name:$name/";
				}
			$min = $this->request->data["BaseList"]["minimum"];
				if($min!="") {
					$q["min"] = "$min";
					$min = "min:$min/";
				}
			$max = $this->request->data["BaseList"]["maximum"];
				if($max!="") {
					$q["max"] = "$max";
					$max = "max:$max/";
				}
			
			$loc = $this->request->data["BaseList"]["file_location"];
				if($loc!="") {
					$q["loc"] = "$loc";
					$loc = "loc:$loc/";
				}
			
			$physical = $this->request->data["BaseList"]["physical"];
				if($physical !="" && $physical != "NULL") {
					$q["physical"] = "$physical";
					$physical = "physical:$physical/";
				} else {
					$physical = "";
				}
			
			$main = $this->request->data["BaseList"]["main"];
				if($main != "" && $main != "NULL") {
					$q["main"] = "$main";
					$main = "main:$main/";
				} else {
					$main = "";
				}

			$need = $this->request->data["BaseList"]["need"];
				if($need != "" && $need != "NULL") {
					$q["need"] = "$need";
					$need = "need:$need/";
				} else {
					$need = "";
				}
				
			$needD = $this->request->data["BaseList"]["needD"];
				if($needD != "" && $needD != "NULL") {
					$q["needD"] = "$needD";
					$needD = "needD:$needD/";
				} else {
					$needD = "";
				}
				
			$name_type = $this->request->data["BaseList"]["name_type"];
				if($name_type != "" && $name_type != "NULL") {
					$q["name_type"] = "$name_type";
					$name_type = "name_type:$name_type/";
				}
			//echo $name;
			
			$this->loadModel('LogSearches');
			$this->LogSearches->set($q);
			$this->LogSearches->save($q, array('validate'=>'false', 'escape'=>'false'));
			
			$this->redirect(array('action' => 'search', "$name$min$max$loc$physical$main$need$needD$name_type"));
			//$this->redirect("./search/$name$min$max$loc$physical$main$need$needD");
		}
		
		if ($this->request->is('get')) { //there shouldn't be anything "submitting" data through post...so only handle get

			pr($this->params->pass);
			
			$q = array();
			
			$this->BaseList->create();
			
			$name =		$this->passedArgs["name"];
				$name = preg_replace("/%20/", "%", $name);//file_name
			$min =   	$this->passedArgs["min"];
			$max =   	$this->passedArgs["max"];
			$loc =   	$this->passedArgs["loc"];		//file_location
				$loc =  preg_replace("/%20/", "%", $loc);
			$physical = $this->passedArgs["physical"];	//how many physical copies one has
			$main =  	$this->passedArgs["main"];		//physical
			$need =  	$this->passedArgs["need"];		//physical
			$needD = 	$this->passedArgs["needD"];		//didgital
			
			if($name == NULL || $name == "NULL") { $name = "%"; }
			
			if($this->passedArgs["name_type"]=="exact") {
				$q["file_name LIKE"] =  "$name";
			} else if($this->passedArgs["name_type"]=="starts") {
				$q["file_name LIKE"] =  "$name%";
			} else if($this->passedArgs["name_type"]=="ends") {
				$q["file_name LIKE"] =  "%$name";
			} else {
				$name = preg_replace("/ /", "%", $name);//file_name
				$q["file_name LIKE"] =  "%$name%";
			}
			
			if($min != "" and $min != NULL and $min != "NULL") { $q["number >="] = "$min"; }
			if($max != "" and $max != NULL and $max != "NULL") { $q["number <="] = "$max"; }
			
			if($loc != "" and $loc != NULL and $loc != "NULL") { $q["file_location LIKE"] =  "%$loc%"; }
			
			if($main != "" 		and $main != NULL 		and $main != "NULL"		and $main != "0")		{ $q["main LIKE"] =  "%$main%"; }
			if($physical != "" 	and $physical != NULL	and $physical != "NULL"	and $physical != "0")	{ $q["physical LIKE"] =  "%$physical%"; }
			if($need != "" 		and $need != NULL 		and $need != "NULL"		and $need != "0")		{ $q["need LIKE"] =  "%$need%"; }
			if($needD != "" 	and $needD != NULL 		and $needD != "NULL"	and $needD != "0")		{ $q["needD LIKE"] =  "%$needD%"; }
			
			$this->set('baseLists', $this->paginate("BaseList", $q));
			
			$s_str = $this->create_search_url();
			$this->set('s_str', $s_str);
			
			$this->loadModel('StoryLineList');

			$this->StoryLineList->create();
			$list = $this->StoryLineList->find('all');
			//pr($list);

			$s = array();
				foreach($list as $item) {
					//pr($item);
					$s[$item["StoryLineList"]["id"]] = $item["StoryLineList"]["name"];
				}
			pr($s);
			$this->set('series', $s);
		}
	}
	
	/***** transfer file actions *****/
	
	public function transferMe($id) {
		$s_str = $this->create_search_url();
		
		$this->BaseList->id = $id;
		if (!$this->BaseList->exists()) {
			return 2;
		}
		
		//get the location of the file to transfer
		$file = $this->BaseList->find('first', array('conditions' => array('id' => $id)));
		$file_to_copy = $file["BaseList"]["file_location"];
		pr($file["BaseList"]["file_location"]);
		
		//get the name of the file being transfered
		$pi = pathinfo($file["BaseList"]["file_location"]);
		$file_name = $file["BaseList"]["file_name"]." ".$file["BaseList"]["number"].".".$pi["extension"];
		$dest="../../../transferMe/$file_name";
		
		if (!copy($file_to_copy, $dest)) {
			//$rtn_str .= "failed to copy $loc to $dest...</h3>";
			return 0;
		} else {
			return 1;
		}
		
	}
	
	
	/***** bulk file actions *****/
	public function bulk() {
		$s_str = $this->create_search_url();
		
		//pr($this->data);
		$c = 0; $f = 0; $u = 0;
		
		if($this->request->data["BaseList"]["action_type"] == "copy") {
			foreach($this->data["c_ids"] as $key => $value) {
				//echo $value."<br />";
				$r = $this->transferMe($value);
				if($r == 1) {
					$c++;
				}
				if($r == 0) {
					$f++;
				}
				if($r == 2) {
					$u++;
				}
			}
			
			if($f == 0 && $u == 0) {
				$this->Session->setFlash("Added to storyline!",'default', array('class' => 'notice success'));
			} else {
				$this->Session->setFlash("Some files failed to copy");
			}
		}
		
		if($this->request->data["BaseList"]["action_type"] == "delete") {
			$errors = array();
			foreach($this->data["c_ids"] as $key => $value) {
				$r = $this->delete_logic($value);
				switch($r) {
					case 0:
						$errors["invalid"] = true;
						break;
					case 1:
						$errors["isMain"] = true;
						break;
					case 2:
						$errors["dbSucceededFileFailed"] = true;
						break;
					case 3:
						$errors["success"] = true;
						break;
					case 4:
						$errors["failed"] = true;
						break;
					case 5:
						$errors["dbFailedFiledSucceed"] = true;
						break;
				}
				if($errors["invalid"] == true || $errors["isMain"] == true || $errors["dbSucceededFileFailed"] == true || $errors["failed"] == true || $errors["dbFailedFiledSucceed"] == true) {
					$this->Session->setFlash("Some items failed to delete");
				} else {
					$this->Session->setFlash("All items are now deleted from the database and moved to deleteMe",'default', array('class' => 'notice success'));
				}
			}
		}
		
		if($this->request->data["BaseList"]["action_type"] == "series") {
			$s = $this->data["BaseList"]["series"];
			foreach($this->data["c_ids"] as $key => $value) {
				pr("Sending $value and $s to series");
				$r = $this->series($value, $s);
				if($r == 1) {
					$c++;
				}
				if($r == 0) {
					$f++;
				}
				if($r == 2) {
					$u++;
				}
			}
		}
		
		$this->redirect(array('action' => 'search', $s_str));
	}

	public function auto_duplicate_proc() {
		$deletions = array();
		
		$this->BaseList->create();
		
		$mains = $this->BaseList->find('list', array('conditions' => array('main' => '1')));
		pr($mains);
		foreach($mains as $id => $name) {
			
			//$this->BaseList->id = $i;

			$item = $this->BaseList->find('first', array('fields' => array('file_name', 'number'),'conditions' => array('id' => $id)));
			
			//pr($item);
			
			$dupes = $this->BaseList->find('all', array(
				'fields' => array('file_name', 'number', 'file_location', 'id'),
				'conditions' => array('main' => '0', 'file_name' => $item["BaseList"]["file_name"], 'number' => $item["BaseList"]["number"])));
			//pr($dupes);
			
			foreach($dupes as $dupe) {
				pr($dupe);
				$this->BaseList->create();
				//$this->BaseList->create();
				$deletions[$dupe["BaseList"]["id"]]["name"] = $dupe["BaseList"]["file_name"];
				$deletions[$dupe["BaseList"]["id"]]["number"] = $dupe["BaseList"]["number"];
				$deletions[$dupe["BaseList"]["id"]]["location"] = $dupe["BaseList"]["file_location"];
				$r = 0;
				$r = $this->delete_logic($dupe["BaseList"]["id"]);
				switch($r) {
					case 0:
						$deletions[$dupe["BaseList"]["id"]]["result"] = "Invalid File in Database";
						break;
					case 1:
						$deletions[$dupe["BaseList"]["id"]]["result"] = "can't delete: is flagged as Main";
						break;
					case 2:
						$deletions[$dupe["BaseList"]["id"]]["result"] = "Removed from database; unable to move file on the filesystem";
						break;
					case 3:
						$deletions[$dupe["BaseList"]["id"]]["result"] = "Successfully removed from the database and the filesystem";
						break;
					case 4:
						$deletions[$dupe["BaseList"]["id"]]["result"] = "Unable to remove from database or filesystem";
						break;
					case 5:
						$deletions[$dupe["BaseList"]["id"]]["result"] = "Removed from filesystem; unable to remove from database";
						break;
				}
			}
			
		}
		
		//pr($deletions);
		$this->set('deletions', $deletions);
	}
	
	public function series($value, $s) {
		pr($value." :: ".$s);
		//pr($s);
		
		//$series_name = $this->get_series($s);
		//pr($series_name);
		
		$q = array();
		$q["issue_id"] = $value;
		$q["storyline"] = $s;
		
		//can't really set order right now since it's just the initial dump...
		
		pr($q);
		
		$this->loadModel('ComicStoryLines');
		$this->ComicStoryLines->create();
		$this->ComicStoryLines->set($q);
		$this->ComicStoryLines->save($q, array('validate'=>'false', 'escape'=>'false'));
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
}