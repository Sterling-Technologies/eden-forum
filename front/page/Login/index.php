<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Front_Page_Login_Index extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'FORUM LOGIN';
	protected $_class = 'home';
	protected $_template = '/Login/index.phtml';
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
		$_SESSION['name'] = $document['firstname'] . " " . $document['lastname'];

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
		$rows = array();
		foreach ($cursor as $document) {
			array_push($rows, $document);
		}
		var_dump($rows);
		return $rows;
	}
	/* Public Methods
	-------------------------------*/
	public function render() {
		if ($_SERVER['HTTP_HOST'] == 'forum.openovate.com'){
			include('/assets/mongo.inc');
		    $this->_mongo = new Mongo($mongo);
			}
		else 
		    $this->_mongo = new MongoClient();		
		$this->_database  = $this->_mongo->eden_forum;

		// $this->deleteAllUsers();
		// var_dump($_POST);
		if(isset($_SESSION['uid'])){
			
			header("location: /");
		}

		if(isset($_POST['firstname'])){
			$this->createUser();
		}
		if(isset($_POST['loginemail'])){
			$this->checkUser($_POST['loginemail'],$_POST['loginpassword']);
		}
		$this->_body = array( 
			'users' => $this->selectUsers()
			);
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
