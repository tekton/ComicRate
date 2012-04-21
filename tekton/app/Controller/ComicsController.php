<?php
App::uses('Sanitize', 'Utility');

/**
 * Comics Controller
 *
 * @property Comic $Comic
 */
class ComicsController extends AppController {

/**
 * Helpers
 *
 * @var array
 */


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Comic->recursive = 0;
		$this->set('comics', $this->paginate());
		
		$this->get_comic_folder();
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Comic->id = $id;
		if (!$this->Comic->exists()) {
			throw new NotFoundException(__('Invalid comic'));
		}
		$this->set('comic', $this->Comic->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Comic->create();
			if ($this->Comic->save($this->request->data)) {
				$this->Session->setFlash(__('The comic has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comic could not be saved. Please, try again.'));
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
		$this->Comic->id = $id;
		if (!$this->Comic->exists()) {
			throw new NotFoundException(__('Invalid comic'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Comic->save($this->request->data)) {
				$this->Session->setFlash(__('The comic has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comic could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Comic->read(null, $id);
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
		$this->Comic->id = $id;
		if (!$this->Comic->exists()) {
			throw new NotFoundException(__('Invalid comic'));
		}
		if ($this->Comic->delete()) {
			$this->Session->setFlash(__('Comic deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Comic was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	 * populate method
	 *
	 *
	 * @return void
	 */ 
	
	public function populate($dir) {

		global $NC, $RC, $added;
		$NC = 0;
		$RC = 0;
		$added = 0;
		
		pr("Going to process :: ../../../".$dir);
		
		$this->print_sub_dir("../../../$dir");
		
		echo "<!-- $NC - $RC :: $added -->";
	}

	/***
	
		despite it's name this is a view and not an action
	
	***/
	function process() {
		
		$this->get_comic_folder();
		
		if($this->passedArgs["folder"]) {
			pr($this->passedArgs);
			$folder = preg_replace("/%20/", " ", $this->passedArgs["folder"]);
			$this->populate($folder);
		}
		
		$this->Session->setFlash(__('Comics from '.$folder.' were added'), 'default', array('class' => 'notice success'));
		$this->redirect(array('action' => 'index'));
	}
	
	function get_comic_folder() {
		// current directory
		pr(getcwd());
		$d = getcwd(); //becomes OLD working directory...
		
		//move up to where the processing files should be
		chdir('../../../');
		
		// new current working directory
		pr(getcwd());
		$f = getcwd();
		
		//get a list of folders not names tekton...
		
		$folders = array();
		
		if($folder = opendir($f)) {
			while(false !== ($item = readdir($folder))) {
				if(is_dir($item)) {
					if($item != "."
					&& $item != ".."
					&& $item != "transferMe"
					&& $item != "deleteMe"
					&& $item != "tekton"
					&& $item != ".git"
					&& $item != ".gitignore"
					&& $item != ".svn") {
						$folders[] = (string)$item;
					}
				}
			}
		}
		
		// go back to the old working directory
		chdir($d);
		pr(getcwd());
		
		$this->set('folders', $folders);
	}
	
	/***
	
		need to create a table that caches duplicates info so it can be browsed in page format
	
	***/
	
	public function duplicates() {
	
		$this->Comic->create();
		
		//$duplicates = $this->Comic->query("select file_name as F, number as N, count(*) as C from comics group by 1,2 order by 3 desc LIMIT 0,200;");
		$duplicates = $this->Comic->query("select file_name as F, number as N, count(*) as C from comics group by 1,2 HAVING C > 1 order by 3 desc;");
		//pr($duplicates);
		
		$this->set('comics', $duplicates);
		
		/*$duplicatesList = $this->Comic->find('all', array(
			'fields' => array('file_name', 'number', 'cField as C'),
			'group' => 'file_name, number',
			'order'=>array('C DESC'),
			'recursive' => 0
		));*/
	}
	
	public function auto_main() {
		pr($this->request->data["dupes"]);
		
		$dupeActions = array();
		
		foreach($this->request->data["dupes"] as $item) {
			$dupe = unserialize($item);
			//pr($dupe);
			
			$this->Comic->create();
			
			//$dupe["comics"]["F"] -> file_name
			//$dupe["comics"]["N"] -> number
			
			//check to see if a main already exists
			if(
			
				$this->Comic->find('count', 
					array('conditions' => 
					array('main' => '1',
						'file_name' => $dupe["comics"]["F"],
						'number' => $dupe["comics"]["N"]
					)))
				
				> 0
			
			) {
				pr("A main already exists...");
				$dupeActions[] = "A main was already set for ".$dupe["comics"]["F"]." ".$dupe["comics"]["N"];
			}
			//if not then we'll go ahead and search for one with noads!
			else if (
			
					$this->Comic->find('count', 
					array('conditions' => 
					array('main' => '0',
						'file_name' => $dupe["comics"]["F"],
						'number' => $dupe["comics"]["N"],
						'file_location like' => '%noads%'
					))) > 0
			) {
				pr("Found one with noads!");
				$new_main = $this->Comic->find('first', 
					array('conditions' => 
					array('main' => '0',
						'file_name' => $dupe["comics"]["F"],
						'number' => $dupe["comics"]["N"],
						'file_location like' => '%noads%'
					)));
				pr($new_main);
				
				$this->Comic->updateAll(array('Comic.main' => "1"), array('Comic.id' => $new_main["Comic"]["id"]));
				$dupeActions[] = "A new main for ".$dupe["comics"]["F"]." ".$dupe["comics"]["N"]." was set to the file located at".$new_main["Comic"]["file_location"];
			}
			//ok, now we'll just pick the first one that was added most likely...
			else {
				pr("ok, now we'll just pick the first one that was added most likely...");
				$new_main = $this->Comic->find('first', 
					array('conditions' => 
					array('main' => '0',
						'file_name' => $dupe["comics"]["F"],
						'number' => $dupe["comics"]["N"]
					)));
				pr($new_main);
				
				$this->Comic->updateAll(array('Comic.main' => "1"), array('Comic.id' => $new_main["Comic"]["id"]));
				$dupeActions[] = "A new main for ".$dupe["comics"]["F"]." ".$dupe["comics"]["N"]." was set to the file located at".$new_main["Comic"]["file_location"];
			}
			
		}
		
		$this->set('dupeActions', $dupeActions);
	}
	
	function create_duplicates_table() {
		$q = "create table cake.dupe_cache select file_name as Comic, number as Issue, count(*) as C from cake.comics group by 1,2;";
	}
	
	/******
	
		Custom Functions to support views
	
	*****/
	
	
	function print_sub_dir($dir) {
		global $NC, $RC, $added;
		
		$pi = pathinfo($dir);
		$b = $pi["dirname"]."/".$pi["basename"];

		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".."
					&& $file != "nomatch.txt"
					&& $file != "test"
					&& $file != "files.php"
					&& $file != "db.php"
					&& $file != "folder.pl"
					&& $file != "web"
					&& $file != "transferMe"
					&& $file != "tekton") {
					$pi = pathinfo($b."/".$file);
					//pr($pi);
					if(is_dir($b."/".$file) == true) {
						echo "<blockquote>";
							$this->print_sub_dir($b."/".$file);
						echo "</blockquote>";
					} else {
						//pr($file);
						$this->break_out_file_name($file, $b);
					}
				}
			}
		}
	}

	function break_out_file_name($file, $b) {
		global $issue;
		
		$title = NULL;
		$issue = NULL;
		
		$pi = pathinfo($b."/".$file);
		//pr($pi);
		
		$title = trim($pi["filename"]);
		$title = preg_replace("/#/i", " ", $title);
		$title = preg_replace("/_/i", " ", $title);
		
		$regex = "/(.*?)[\(\[](.*)/";
		preg_match($regex,$title,$p);
			//pr($p, "P:: ");
		//preg_match("/(.*)[\s][#](.*)$/",$p[1],$q);
			//pr($q, "Q:: ");
		
		if($p[1]=="") {
			preg_match("/(.*)[\s](.*$)/i", $title, $r);
		} else {
			preg_match("/(.*)[\s](.*$)/i", trim($p[1]), $r);
		}
		
		//pr($r, "R :: ");
		
		$issue = $this->find_issue_number_from_number(trim($r[2]));
		
		if($issue == 0) {
			$issue = $this->find_issue_number_from_number($title);
			preg_match("/(.*)$issue(.*)/i", $title, $q);
			$title = trim($q[1]);
			//echo "<div>".trim($q[1])." :: ".$q[2]."</div>";
			//pr($q, "Q :: $issue :: $file :: ");
		} else {
			$title = trim($r[1]);
		}
		
		if($issue == 0) { //if you STILL can't find an issue number, throw what we do know in the database and remind the user it needs a review
			$this->e_line("REVIEW :: [ $title ] [ $issue ]", "2");
			$this->create_sql_call($b."/".$file, $title, $issue, "yes");
			global $RC;
			$RC = $RC + 1;
		} else {
			$this->e_line("Would end up as :: [ $title ] [ $issue ]", "2");
			$this->create_sql_call($b."/".$file, $title, $issue, "no");
			global $NC;
			$NC = $NC + 1;
		}
		
		/* TODO: Add Year/Volume search */
	}

	function find_issue_number_from_number($num) {
		if(!is_numeric($num)) {
			$this->e_line("Attempting to find number in <b>$num</b>", "2");
			preg_match("/(\d+)(.*)/i", $num, $r); //keeping same array as other number evaluation functions
			//pr($r);
			if(is_numeric($r[1])) {
				$this->e_line("Able to find number in $num:: ".$r[1], "2");
				return $r[1];
			}
			else {
				$this->e_line("Unable to find number in $num...", "2");
				return 0;
			}
		} else {
			$this->e_line("Value is already numeric :: $num", "2");
			return $num;
		}
	}

	function e_line($txt, $d) {
		if($d != 2) {echo "<div>$txt</div>";}
	}

	function create_sql_call($loc, $name, $num, $review) {
		global $added;
		$this->Comic->create();
		
		$num = preg_replace("/\.$/", "", $num);
		
		$q = array("file_location" => "$loc","file_name" => "$name","number" => "$num","review" => "$review");
		$fieldlist = array("file_location","file_name","number","review");
		
		pr($loc);
		
		if($pending = $this->Comic->find('count', array('conditions' => array('file_location' => "$loc"))) < 1) {
			$this->Comic->set($q);
			$this->Comic->save($this->data, array('validate'=>'false', 'escape'=>'false'));
			$added++;
		}
	}

	function install() {
		$q = "'CREATE TABLE `comics` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`file_location` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			`review` varchar(45) CHARACTER SET utf8 DEFAULT ''yes'',
			`manual` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
			`file_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			`number` float DEFAULT ''0'',
			`edition` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
			`volume` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
			`main` binary(1) DEFAULT ''0'',
			`physical` binary(1) DEFAULT ''0'',
			`issue_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			`storyline` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
			`need` binary(1) DEFAULT NULL,
			`needD` binary(1) DEFAULT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `file_location_UNIQUE` (`file_location`)
			) ENGINE=InnoDB AUTO_INCREMENT=32761 DEFAULT CHARSET=latin1';";
			
		$this->Comic->query($q);
			
	}
}