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
	
	public function populate() {

		global $NC, $RC, $added;
		$NC = 0;
		$RC = 0;
		$added = 0;
	
		$this->print_sub_dir('F:/Comics/');
		
		echo "<!-- $NC - $RC :: $added -->";
	}

	public function duplicates() {
	
		$this->Comic->create();
		
		$duplicates = $this->Comic->query("select file_name as F, number as N, count(*) as C from comics group by 1,2 order by 3 desc LIMIT 0,200;");
		//pr($duplicates);
		
		$this->set('comics', $duplicates);
		
		/*$duplicatesList = $this->Comic->find('all', array(
			'fields' => array('file_name', 'number', 'cField as C'),
			'group' => 'file_name, number',
			'order'=>array('C DESC'),
			'recursive' => 0
		));*/
	}
	
	/******
	
		Custom Function to support views
	
	*****/
	
	
	function print_sub_dir($dir) {

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
					&& $file != "transferMe") {
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
		
		$loc = preg_replace("/©/", "&copy;", $loc);
		$loc = Sanitize::html($loc);
		
		$num = preg_replace("/\.$/", "", $num);
		
		$q = array("file_location" => "$loc","file_name" => "$name","number" => "$num","review" => "$review");
		$fieldlist = array("file_location","file_name","number","review");
		
		if($pending = $this->Comic->find('count', array('conditions' => array('file_location' => "$loc"))) < 1) {
			$this->Comic->set($q);
			$this->Comic->save();
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
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1';";
		
		$this->Comic->query($q);
		
	}
}