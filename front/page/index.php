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
	/* Public Methods
	-------------------------------*/
	public function render() {
		$forum = front()->Forum();	

		if(isset($_GET['logout'])){
			session_destroy();
			header("location: /login");
		}
		
		if(isset($_POST['title'])){
			$forum->createTopic($_POST['title'], $_POST['content']);

		}
		if(isset($_POST['topicid'])){
			$forum->createReply($_POST['topicid'],$_POST['replyTitle'], $_POST['replyContent']);

		}
// 		if
		$this->_body = array( 
			'topics' => $forum->getAllTopics()
			);
				return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
