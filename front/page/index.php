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
		var_dump(iterator_to_array($cursor));
		return $cursor;
	}
	public function deleteAll(){
		$topic = $this->_database->topics;
		$topic->remove();

	}
	public function createTopic($title, $content){
		$topic = $this->_database->topics;

		$document = array(
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
		// var_dump($_POST);
		if(isset($_POST['title'])){
			$this->createTopic($_POST['title'], $_POST['content']);

		}
		if(isset($_POST['topicid'])){
			$this->createReply($_POST['topicid'],$_POST['title'], $_POST['content']);

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
