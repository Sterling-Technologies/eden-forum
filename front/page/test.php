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
		$forum = front()->Forum();	

		$id = $this->getUriSegment(2);
		if(isset($_POST['topicid'])){
			$forum->createReply($_POST['topicid'],$_POST['replyTitle'], $_POST['replyContent']);
		}
		$this->_body = array( 'topics' => $forum->selectTopic($id), 'users' => $forum->selectUsers());
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
