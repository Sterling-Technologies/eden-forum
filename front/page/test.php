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
	/*
		Creates a reply and append it on the current post
		@param topicid the current topic to reply int
		@param title the subject of the reply string
		@param content the content of the reply string
		@return nothing
	*/
	public function createReply($topicid, $title, $content){
		$topic = $this->_database->topics;
		$reply = array(		"reply_title" => $title,
								"reply_content" =>$content,
								"reply_created" => date('Y-m-d H:i A'),
								"reply_userid" => $_SESSION['uid'],
								"reply_name" => $_SESSION['name'],
								"reply_picture" => $_SESSION['user_picture']
						);
		$document = array('$addToSet' => array("reply" => $reply));

		$id = new MongoId($topicid);
		$topic->update(array("_id"=>$id),$document);
	}
	/*
		Selects the topic details base on the id
		@param topicid the current topic int
		@return array
	*/
	public function selectTopic($topicid){
		$topic = $this->_database->topics;
		$id = new MongoId($topicid);

		$cursor = $topic->find(array("_id"=>$id));

		return $cursor;
	}
	public function getUsers(){
		$users = $this->_database->users;
		$cursor = $users->find();
		return $cursor;

	}
	//split the URI segments
	public function getUriSegments() {
	    return explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	}
	//select the part of URI
	public function getUriSegment($n) {
	    $segs = $this->getUriSegments();
	    return count($segs)>0&&count($segs)>=($n-1)?$segs[$n]:'';
	}
	/* Public Methods
	-------------------------------*/
	public function render() {
		if ($_SERVER['HTTP_HOST'] == 'forum.openovate.com'){
			define('DOCROOT', realpath(dirname(__FILE__)).'/');
			include(DOCROOT . 'mongo.inc');
			}
		else 
		    $this->_mongo = new MongoClient();

		$this->_database  = $this->_mongo->eden_forum;
		$id = $this->getUriSegment(2);
		if(isset($_POST['topicid'])){
			$this->createReply($_POST['topicid'],$_POST['replyTitle'], $_POST['replyContent']);
		}
		$this->_body = array( 'topics' => $this->selectTopic($id), 'users' => $this->getUsers());
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
