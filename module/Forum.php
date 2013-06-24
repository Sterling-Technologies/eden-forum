<?php //-->
class Forum extends Eden_Class {
    /* Constants
    -------------------------------*/
    /* Public Properties
    -------------------------------*/
    /* Protected Properties
    -------------------------------*/
    protected $_mongo;
    protected $_collection;
    /* Private Properties
    -------------------------------*/
    /* Magic
    -------------------------------*/
    public function __construct() {
        if ($_SERVER['HTTP_HOST'] == 'forum.openovate.com'){
            include(front()->path('config').'/mongo.inc');
            $this->_mongo = new Mongo($mongo);
        }
        else {
            $this->_mongo = new MongoClient();  
        }
        $this->_collection  = $this->_mongo->eden_forum;
    }
     
    /* Public Methods
    -------------------------------*/
    /**
     * Return model
     *
     * @param scalar|null
     * @param string
     * @return this
     */
    public function load($value, $column = NULL) {
        //argument testing
        User_Error::i()
            ->argument(1, 'scalar', 'array') //argument 1 must be a scalar or array
            ->argument(2, 'string', 'null'); //argument 1 must be a string or null
         
        if(is_array($value)) {
            return $this->set($value);
        }
         
        if(is_null($column)) {
            $meta = $this->_getMeta();
            $column = $meta['primary'];
        }
         
        $row = $this->_collection->getRow($this->_table, $column, $value);
         
        if(is_null($row)) {
            return $this;
        }
         
        return $this->set($row);
    }
    /*
    *   Selects all the topics
    *   @return array
    */
    public function getAllTopics(){

        $topic  = $this->_collection->topics;
        $cursor = $topic->find()->sort( array('_id' => -1) );
        return iterator_to_array($cursor);
    }
    /*
        deletes the collection topics.
    */
    public function deleteAllTopics(){
        $topic = $this->_collection->topics;
        $topic->remove();

    }
    /*
        Creates a topic/thread
        @param string title the subject of the topic string
        @param string content the content of the topic string
        @return nothing
    */
    public function createTopic($title, $content){
        $topic = $this->_collection->topics;

        $document = array(
            "topic_title" => $title,
            "reply" => array(array(
                        "reply_title" => $title,
                        "reply_content" =>$content,
                        "reply_created" => date('Y-m-d h:i A'),
                        "reply_userid" => $_SESSION['uid'],
                        "reply_name" => $_SESSION['name'],
                        "reply_picture" => $_SESSION['user_picture']

                        )
                        )
            );
        $topic->insert($document);
    }
    /*
        Creates a reply
        @param number topicid the id of the current topic
        @param string title the subject of the topic string
        @param string content the content of the topic string
        @return nothing
    */
    public function createReply($topicid, $title, $content){
        $topic = $this->_collection->topics;
        $reply = array( "reply_title"   => $title,
                        "reply_content" =>$content,
                        "reply_created" => date('Y-m-d H:i A'),
                        "reply_userid"  => $_SESSION['uid'],
                        "reply_name"    => $_SESSION['name'],
                        "reply_picture" => $_SESSION['user_picture']
                        );
        $document = array(
            '$addToSet' => array(
                        "reply" => $reply
                ));

        $id = new MongoId($topicid);
        $topic->update(array("_id"=>$id),$document);
    }
    /*
        Fetches the topic with that id
        @param number topicid 
        @return array
    */
    public function selectTopic($topicid){
        $topic = $this->_collection->topics;
        $id = new MongoId($topicid);

        $cursor = $topic->find(array("_id"=>$id));

        return iterator_to_array($cursor);
    }
    /*
        Checks if the email is already taken
        @param string email
        @return boolean
    */    
    public function checkEmail($email){
        $users = $this->_collection->users;
        $cursor = $users->find(array(
            'user_email' => $email
            ));
        return !$cursor->count();
    }
    /*
        Uploads the browsed file.
        @return boolean
    */
    public function uploadAvatar(){

        if ((($_FILES["myFile"]["type"] == "image/gif")
        || ($_FILES["myFile"]["type"]   == "image/jpeg")
        || ($_FILES["myFile"]["type"]   == "image/jpg")
        || ($_FILES["myFile"]["type"]   == "image/pjpeg")
        || ($_FILES["myFile"]["type"]   == "image/x-png")
        && ($_FILES["myFile"]["type"] != "")
        || ($_FILES["myFile"]["type"]   == "image/png")))
        {
            move_uploaded_file($_FILES['myFile']['tmp_name'], 'assets/uploads/' . $_FILES['myFile']['name']);
            return true;
        }
        else{
            return false;
        }
    }
    /*
        Creates user
        @return array
    */
    public function createUser(){
        $users = $this->_collection->users;
        // $this->uploadAvatar();
        $filename = "";
        if(empty($_FILES['myFile']['name'])){
            $filename = "defPic3.png";
        }
        else{
            $filename = $_FILES['myFile']['name'];
        }
        
        $document = array(
            "user_firstname" => $_POST['firstname'],
            "user_lastname"  => $_POST['lastname'],
            "user_email"     => $_POST['email'],
            "user_password"  => $_POST['password'],
            "user_picture"   => $filename
            );
        $users->insert($document);
        return $document;
    }
     /*
        Check if theres a user with that email and password
        @param string email 
        @param string password 
        @return array
    */
    public function checkUser($email, $password){
        $users = $this->_collection->users;
        $cursor = $users->find(array(
            'user_email'     => $email ,
            'user_password'  => $password));

        foreach ($cursor as $user) {
            return $user;
        }
    }
    /*
        Returns the password of the given email. Returns null if no email matched.
        @param string password 
        @return array
    */
    public function getPassword($email){
        $users = $this->_collection->users;
        $cursor = $users->find(array('user_email'=> $email));
        foreach ($cursor as $user) {
            include(front()->path('config').'/smtp.inc');
            $smtp->setSubject('Lost password - Openovate Forums')
                ->setBody('Your password is: ' . $user['user_password'] . "<BR>Visit us again at <a  href = 'http://forum.openovate.com'> Openovate Forums </a>",true)
                ->addTo($email)
                ->send();
            return "Your password has been sent to your email.";
        }
        return "Invalid email.";
    }
    /*
        Selects all the users
        @return array
    */
    public function selectUsers(){
        $users = $this->_collection->users;
        $cursor = $users->find();

        return iterator_to_array($cursor);
    }
    /*
        Deletes all the users
        @return array
    */
    public function deleteAllUsers(){
        $users = $this->_collection->users;
        $users->remove();

    }
    /* Protected Methods
    -------------------------------*/
    /* Private Methods
    -------------------------------*/
}