<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Front_Page_Index extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'Eden';
	protected $_class = 'home';
	protected $_template = '/index.phtml';
	protected $_mongo;
	protected $_database;
<<<<<<< HEAD
<<<<<<< HEAD
	protected $_con = "mongodb://eden_forum:jVbOU1AcimS1@ds027708.mongolab.com:27708/eden_forum";
=======
>>>>>>> 92af35983647b8e1e9603e1e94944f7e280c6f0f
=======
>>>>>>> 1a01c6686036a6369d543699fbd584515adc4b4d
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 1a01c6686036a6369d543699fbd584515adc4b4d
	/*
		Selects all the topics
		@return array
	*/
	public function selectAllTopics(){
		$topic = $this->_database->topics;
		$cursor = $topic->find()->sort( array('_id' => -1) );
		return $cursor;
	}
	/*
		deletes the collection topics.
	*/
<<<<<<< HEAD
=======
	public function selectAllTopics(){
		$topic = $this->_database->topics;
		$cursor = $topic->find()->sort( array('_id' => -1) );
		var_dump(iterator_to_array($cursor));
		return $cursor;
	}
>>>>>>> 92af35983647b8e1e9603e1e94944f7e280c6f0f
=======
>>>>>>> 1a01c6686036a6369d543699fbd584515adc4b4d
	public function deleteAll(){
		$topic = $this->_database->topics;
		$topic->remove();

	}
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 1a01c6686036a6369d543699fbd584515adc4b4d
	/*
		Creates a topic/thread
		@param title the subject of the topic string
		@param content the content of the topic string
		@return nothing
	*/
<<<<<<< HEAD
=======
>>>>>>> 92af35983647b8e1e9603e1e94944f7e280c6f0f
=======
>>>>>>> 1a01c6686036a6369d543699fbd584515adc4b4d
	public function createTopic($title, $content){
		$topic = $this->_database->topics;

		$document = array(
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 1a01c6686036a6369d543699fbd584515adc4b4d
			"topic_title" => $title,
			"reply" => array(array(
						"reply_title" => $title,
						"reply_content" =>$content,
<<<<<<< HEAD
						"reply_created" => date('Y-m-d h:i A')
=======
						"reply_created" => date('Y-m-d h:i A'),
						"reply_userid" => $_SESSION['uid'],
						"reply_name" => $_SESSION['name']
>>>>>>> 1a01c6686036a6369d543699fbd584515adc4b4d
						)
						)
			);
		$topic->insert($document);
	}
<<<<<<< HEAD

=======
>>>>>>> 1a01c6686036a6369d543699fbd584515adc4b4d
	/* Public Methods
	-------------------------------*/
	public function render() {
		if ($_SERVER['HTTP_HOST'] == 'forum.openovate.com'){
<<<<<<< HEAD
			include('/assets/mongo.inc');
=======
			define('DOCROOT', realpath(dirname(__FILE__)).'/');
			include(DOCROOT . 'mongo.inc');
>>>>>>> 1a01c6686036a6369d543699fbd584515adc4b4d
		    $this->_mongo = new Mongo($mongo);
		}
		else 
		    $this->_mongo = new MongoClient();	

		if(isset($_GET['logout'])){
			session_destroy();
			header("location: /login");
		}
<<<<<<< HEAD
		  	
		$this->_database  = $this->_mongo->eden_forum;
		// $this->deleteAll();
=======
			"title" => $title,
			"posts" => array(array(
						"title" => $title,
						"content" =>$content,
						"created" => date('Y-m-d H:i:s')
						)
						)
			);

		$topic->insert($document);

			// var_dump($topic);
	}
	public function createReply($topicid, $title, $content){
		$topic = $this->_database->topics;
		$reply = array(
								"title" => $title,
								"content" =>$content,
								"created" => date('Y-m-d H:i:s')
						);
		$document = array('$push' => 
			array("posts" => $reply));

		$topic->update(array("_id"=>$topicid),$document);
		
	}
	/* Public Methods
	-------------------------------*/
	public function render() {
		$this->_mongo = new MongoClient();
		$this->_database  = $this->_mongo->forum;
>>>>>>> 92af35983647b8e1e9603e1e94944f7e280c6f0f
=======
		$this->_database  = $this->_mongo->eden_forum;
		// $this->deleteAll();
		// $this->deleteAll();
>>>>>>> 1a01c6686036a6369d543699fbd584515adc4b4d
		// var_dump($_POST);
		if(isset($_POST['title'])){
			$this->createTopic($_POST['title'], $_POST['content']);

		}
		if(isset($_POST['topicid'])){
<<<<<<< HEAD
<<<<<<< HEAD
			$this->createReply($_POST['topicid'],$_POST['replyTitle'], $_POST['replyContent']);
=======
			$this->createReply($_POST['topicid'],$_POST['title'], $_POST['content']);
>>>>>>> 92af35983647b8e1e9603e1e94944f7e280c6f0f
=======
			$this->createReply($_POST['topicid'],$_POST['replyTitle'], $_POST['replyContent']);
>>>>>>> 1a01c6686036a6369d543699fbd584515adc4b4d

		}
// 		if
		$this->_body = array( 
			'topics' => $this->selectAllTopics()
			);
				return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
