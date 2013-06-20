<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Front_Page_Login extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'FORUM LOGIN';
	protected $_class = 'home';
	protected $_template = '/login.phtml';
	protected $_mongo;
	protected $_database;
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function createUser(){
		$users = $this->_database->users;

		$document = array(
			"user_firstname" => $_POST['firstname'],
			"user_lastname" => $_POST['lastname'],
			"user_email" => $_POST['email'],
			"user_password" => $_POST['password'],
			
			);
		$users->insert($document);
		$_SESSION['uid'] = $document['_id'];
		$_SESSION['name'] = $document['user_firstname'] . " " . $document['user_lastname'];
		if(isset($_GET['redirect'])){
			header("location: /topic/".$_GET['redirect']);
		}
		else{
			header("location: /");
		}
	}
	public function deleteAllUsers(){
		$users = $this->_database->users;
		$users->remove();

	}
	/*
		Selects all the topics
		@return array
	*/
	public function selectUsers(){
		$users = $this->_database->users;
		$cursor = $users->find();

		return $cursor;
	}
	public function checkUser($email, $password){
		$users = $this->_database->users;
		$cursor = $users->find(array('user_email' => $email , 'user_password' => $password));
		if($cursor->count()!=0){
			foreach ($cursor as $document) {
					$_SESSION['uid'] = $document['_id'];
					$_SESSION['name'] = $document['user_firstname'] . " " . $document['user_lastname'];
					if(isset($_GET['redirect'])){
						header("location: /topic/".$_GET['redirect']);
					}
					else{
						header("location: /");
					}
			}
		}
		return $cursor->count();
	}
	public function checkEmail($email){
		$users = $this->_database->users;
		$cursor = $users->find(array('user_email' => $email));
		// echo $cursor->count();
		return !$cursor->count();
	}
	/* Public Methods
	-------------------------------*/
	public function render() {
		if ($_SERVER['HTTP_HOST'] == 'forum.openovate.com'){
			define('DOCROOT', realpath(dirname(__FILE__)).'/');
			include(DOCROOT . 'mongo.inc');
		    $this->_mongo = new Mongo($mongo);
			}
		else 
		    $this->_mongo = new MongoClient();		
		$this->_database  = $this->_mongo->eden_forum;
		// $this->deleteAllUsers();
		$signerrors = "<div class='error_box1 alert alert error'></div>";
		$loginerrors = "<div class='error_box2 alert alert error'></div>";

		if(isset($_POST['firstname'])){
			if($this->checkEmail($_POST['email'])){
				$this->createUser();
			}
			else{
				$signerrors = "<div class='error_box1 alert alert error'>Email already exists.</div>";
			}
		}
		if(isset($_POST['loginemail'])){
			if(!$this->checkUser($_POST['loginemail'],$_POST['loginpassword'])){
				$loginerrors = "<div class='error_box2 alert alert error'>Incorrect email or password.</div>";
			}
		}
		// if(isset($_SESSION['uid'])){
			
		// 	header("location: /");
		// }

		$this->_body = array( 
			'users' => $this->selectUsers(),
			'signerrors' => $signerrors,
			'loginerrors' => $loginerrors
			);
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
