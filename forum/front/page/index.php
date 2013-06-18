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
	public function selectAllTopics(){
		$topic = $this->_database->topics;
		$cursor = $topic->find()->sort( array('_id' => -1) );
		$rows = array();
		foreach ($cursor as $document) {
		   array_push($rows, $document);
		}
		return $rows;
	}
	public function deleteAll(){
		$topic = $this->_database->topics;
		$topic->remove();

	}
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

			// var_dump($topic);
	}

	/* Public Methods
	-------------------------------*/
	public function render() {
		$this->_mongo = new MongoClient();
		$this->_database  = $this->_mongo->forum;
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
