<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Front_Page_Login extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'FORUM LOGIN';
	protected $_class = 'home';
	protected $_template = '/login.phtml';
	protected $_mongo;
	protected $_database;
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/




	public function saveUserDetails($document){
		$_SESSION['uid'] = $document['_id'];
        $_SESSION['name'] = $document['user_firstname'] . " " . $document['user_lastname'];
        $_SESSION['user_picture'] = $document['user_picture'];

        if(isset($_GET['redirect'])){
            header("location: /topic/".$_GET['redirect']);
        }
        else{
            header("location: /");
        }
	}

	/* Public Methods
	-------------------------------*/
	public function render() {
		$forum = front()->Forum();	
		$signerrors = "<div class='error_box1 alert alert error'></div>";
		$loginerrors = "<div class='error_box2 alert alert error'></div>";

		if(isset($_POST['email'])){
			if($forum->checkEmail($_POST['email'])){
				if(!empty($_FILES['myFile']['name'])){
					if($forum->uploadAvatar()){
						$this->saveUserDetails($forum->createUser());
					}	
					else{
						$signerrors = "<div class='error_box1 alert alert error'>File type not accepted.</div>";
					}
				}
				else{
					$this->saveUserDetails($forum->createUser());
				}
			}
			else{
				$signerrors = "<div class='error_box1 alert alert error'>Email already exists.</div>";
			}
		}
		if(isset($_POST['loginemail'])){
			if($document = $forum->checkUser($_POST['loginemail'],$_POST['loginpassword'])){
				$this->saveUserDetails($document);
			}
			else{
				$loginerrors = "<div class='error_box2 alert alert error'>Incorrect email or password.</div>";

			}
		}

		$this->_body = array( 
			'users' => $forum->selectUsers(),
			'signerrors' => $signerrors,
			'loginerrors' => $loginerrors
			);
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
