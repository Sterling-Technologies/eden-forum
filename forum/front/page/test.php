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
	public function selectTopic($topicid, $start, $limit){
		$topic = $this->_database->topics;
		$id = new MongoId($topicid);

		$cursor = $topic->find(array("_id"=>$id));
		$rows = array();
		foreach ($cursor as $document) {
		   array_push($rows, $document);
		}
		return $rows;
	}
	public function getUriSegments() {
	    return explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	}
	 
	public function getUriSegment($n) {
	    $segs = $this->getUriSegments();
	    return count($segs)>0&&count($segs)>=($n-1)?$segs[$n]:'';
	}
	/* Public Methods
	-------------------------------*/
	public function render() {
		$this->_mongo = new MongoClient();
		$this->_database  = $this->_mongo->forum;
		$id = $this->getUriSegment(2);
		$start = 0; $limit=1;
		// if($this->getUriSegment(2)){
		// 	$start = $this->getUriSegment(3);
		// 	$limit = $this->getUriSegment(4);
		// }
		if(isset($_POST['topicid'])){
			$this->createReply($_POST['topicid'],$_POST['replyTitle'], $_POST['replyContent']);
		}
		$this->_body = array( 'topics' => $this->selectTopic($id,$start,$limit));
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
