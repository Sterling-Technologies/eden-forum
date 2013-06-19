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
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
<<<<<<< HEAD
	/*
		Selects all the topics
		@return array
	*/
=======
>>>>>>> ed139f12fd80cbca63c485f8a225c672c2374080
	public function selectAllTopics(){
		$topic = $this->_database->topics;
		$cursor = $topic->find()->sort( array('_id' => -1) );
		$rows = array();
		foreach ($cursor as $document) {
		   array_push($rows, $document);
		}
		return $rows;
	}
<<<<<<< HEAD
	/*
		Creates deletes the collection topics.
	*/
=======
>>>>>>> ed139f12fd80cbca63c485f8a225c672c2374080
	public function deleteAll(){
		$topic = $this->_database->topics;
		$topic->remove();

	}
<<<<<<< HEAD
	/*
		Creates a topic/thread
		@param title the subject of the topic string
		@param content the content of the topic string
		@return nothing
	*/
=======
>>>>>>> ed139f12fd80cbca63c485f8a225c672c2374080
	public function createTopic($title, $content){
		$topic = $this->_database->topics;

		$document = array(
			"topic_title" => $title,
			"reply" => array(array(
						"reply_title" => $title,
						"reply_content" =>$content,
						"reply_created" => date('Y-m-d h:i:s')
						)
						)
			);

		$topic->insert($document);
<<<<<<< HEAD
=======

			// var_dump($topic);
>>>>>>> ed139f12fd80cbca63c485f8a225c672c2374080
	}

	/* Public Methods
	-------------------------------*/
	public function render() {
		$this->_mongo = new Mongo('mongodb://eden_forum:jVbOU1AcimS1@ds027708.mongolab.com:27708/eden_forum');
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
