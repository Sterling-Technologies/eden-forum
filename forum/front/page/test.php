<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Front_Page_Test extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'Eden';
	protected $_class = 'home';
	protected $_template = '/test.phtml';
	protected $_mongo;
	protected $_database;
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
<<<<<<< HEAD
	/*
		Creates a reply and append it on the current post
		@param topicid the current topic to reply int
		@param title the subject of the reply string
		@param content the content of the reply string
		@return nothing
	*/
=======
>>>>>>> ed139f12fd80cbca63c485f8a225c672c2374080
	public function createReply($topicid, $title, $content){
		$topic = $this->_database->topics;
		$reply = array(		"reply_title" => $title,
								"reply_content" =>$content,
								"reply_created" => date('Y-m-d H:i:s')
						);
		$document = array('$addToSet' => array("reply" => $reply));

		$id = new MongoId($topicid);
		$topic->update(array("_id"=>$id),$document);
	}
<<<<<<< HEAD
	/*
		Selects the topic details base on the id
		@param topicid the current topic int
		@return array
	*/
	public function selectTopic($topicid){
=======
	public function selectTopic($topicid, $start, $limit){
>>>>>>> ed139f12fd80cbca63c485f8a225c672c2374080
		$topic = $this->_database->topics;
		$id = new MongoId($topicid);

		$cursor = $topic->find(array("_id"=>$id));
		$rows = array();
		foreach ($cursor as $document) {
		   array_push($rows, $document);
		}
		return $rows;
	}
<<<<<<< HEAD
	//split the URI segments
	public function getUriSegments() {
	    return explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	}
	//select the part of URI
=======
	public function getUriSegments() {
	    return explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	}
	 
>>>>>>> ed139f12fd80cbca63c485f8a225c672c2374080
	public function getUriSegment($n) {
	    $segs = $this->getUriSegments();
	    return count($segs)>0&&count($segs)>=($n-1)?$segs[$n]:'';
	}
	/* Public Methods
	-------------------------------*/
	public function render() {
		$this->_mongo = new Mongo('mongodb://eden_forum:jVbOU1AcimS1@ds027708.mongolab.com:27708/eden_forum');
		$this->_database  = $this->_mongo->eden_forum;
		$id = $this->getUriSegment(2);
<<<<<<< HEAD
		if(isset($_POST['topicid'])){
			$this->createReply($_POST['topicid'],$_POST['replyTitle'], $_POST['replyContent']);
		}
		$this->_body = array( 'topics' => $this->selectTopic($id));
=======
		$start = 0; $limit=1;
		// if($this->getUriSegment(2)){
		// 	$start = $this->getUriSegment(3);
		// 	$limit = $this->getUriSegment(4);
		// }
		if(isset($_POST['topicid'])){
			$this->createReply($_POST['topicid'],$_POST['replyTitle'], $_POST['replyContent']);
		}
		$this->_body = array( 'topics' => $this->selectTopic($id,$start,$limit));
>>>>>>> ed139f12fd80cbca63c485f8a225c672c2374080
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
