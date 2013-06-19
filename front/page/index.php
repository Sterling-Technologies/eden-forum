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
	protected $_con = "mongodb://eden_forum:jVbOU1AcimS1@ds027708.mongolab.com:27708/eden_forum";
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
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
	public function deleteAll(){
		$topic = $this->_database->topics;
		$topic->remove();

	}
	/*
		Creates a topic/thread
		@param title the subject of the topic string
		@param content the content of the topic string
		@return nothing
	*/
	public function createTopic($title, $content){
		$topic = $this->_database->topics;

		$document = array(
			"topic_title" => $title,
			"reply" => array(array(
						"reply_title" => $title,
						"reply_content" =>$content,
						"reply_created" => date('Y-m-d h:i A')
						)
						)
			);
		$topic->insert($document);
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

		if(isset($_GET['logout'])){
			session_destroy();
			header("location: /login");
		}
		  	
		$this->_database  = $this->_mongo->eden_forum;
		// $this->deleteAll();
		// var_dump($_POST);
		if(isset($_POST['title'])){
			$this->createTopic($_POST['title'], $_POST['content']);

		}
		if(isset($_POST['topicid'])){
			$this->createReply($_POST['topicid'],$_POST['replyTitle'], $_POST['replyContent']);

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
