<?php //-->
class Post_Model extends Eden_Sql_Model {
    /* Constants
    -------------------------------*/
    /* Public Properties
    -------------------------------*/
    /* Protected Properties
    -------------------------------*/
    protected $_table = 'post';
     
    /* Private Properties
    -------------------------------*/
    /* Magic
    -------------------------------*/
    public function __construct() {
       
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
         
        $row = $this->_database->getRow($this->_table, $column, $value);
         
        if(is_null($row)) {
            return $this;
        }
         
        return $this->set($row);
    }
     public function getPosts(){
		$this->_database()->getRows();
	 }
    /**
     * Returns post author's information
     *
     * @return array
     */
    public function getList() {
        $userId = $this->getPostUser();
        if(!$userId) {
            return array();
        }
         
        return $this->_database->getRow('user', 'user_id', $userId);
    }
     
    /* Protected Methods
    -------------------------------*/
    /* Private Methods
    -------------------------------*/
}