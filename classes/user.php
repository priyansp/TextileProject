<?php
 class user{
 	private $_db,
 			$_data,
 			$_sessionName,
 			$_cookieName,
 			$_isLoggedIn;
 

 	public function __construct($user = null){
 		$this->_db = DB::getInstance();

 		$this->_sessionName = config::get('session/session_name');
 		$this->_cookieName = config::get('remember/cookie_name');
 		if(!$user){
 			if(session::exists($this->_sessionName)){
 				$user = session::get($this->_sessionName);
 				if($this->find($user)){
 					$this->_isLoggedIn = true;
 				}else{
 					//
 				}
 			}
 		}else{
 			$this->find($user);
 		}

 	}

	
	
	public function consignee_id_gen($username){
	if($this->_db->insert('consignee_gen', array('consignee_name' => $username))){
		$consignee_id = $this->_db->query("select id from consignee_gen order by id desc limit 1;");
		print_r($consignee_id);
		$consignee_id = $consignee_id->first();
		return $consignee_id->id;
	}
	
	}
	
	
 	public function hasPermission($key){
 		$group = $this->_db->get('groups',array('id','=',$this->data()->group));
 		if($group->count()){
 		$permissions = json_decode($group->first()->permissions,true);
 		if(isset($permissions[$key])){
 		if($permissions[$key] == true){
 			return true;
 			}	
 		}
 		
 		}
 		return false;
 	}
	
	
 	
	
 	public function update($fields = array(), $id = null){
 		if(!$id && $this->isLoggedIn()){
 			$id = $this->data()->id;
 		}

 		if(!$this->_db->update('user',$id,$fields)){
 			throw new Exception("there was a problem while updating.");
 		}else{
			return true;
		}
		
 	}
	
	
		
 	public function create($fields = array()){
 		if(!$this->_db->insert('user',$fields)){
 			throw new Exception("There was a problem in creating an account!");
 		}
 	}
	
	public function create_table($table,$fields = array()){
 		if(!$this->_db->insert($table,$fields)){
 			throw new Exception("There was a problem in creating an table!");
 		}
 	}
	

 	public function find($user = null){
 		if($user){
 			$field ='user_name';
 			$data = $this->_db->get('user',array($field, '=' ,$user ));
 			if($data->count()){
 				$this->_data = $data->first();
 				return true;
 			}
 		}
 		return false; 
 	}
	
	public function find_response($user = null){
 		if($user){
 			$field = (is_numeric($user)) ? 'id' : 'username';
 			$data = $this->_db->get('users',array($field, '=' ,$user ));
 			if($data->count()){
 				$this->_data = $data->first();
 				return $data->first();
 			}
 		}
 		return false; 
 	}
	
	
 	public function login($username = null,$password = null,$remember = false){
 		if(!$username && !$password && $this->exists()){
 			session::put($this->_sessionName,$this->data()->id);
 		}else{
	 		$user = $this->find($username);
	 		if($user){
	 			if($this->data()->password === hash::make($password,$this->data()->salt)){
	 				session::put($this->_sessionName,$this->data()->user_name);
	 				return true;
	 			}	
	 		}
	 	}
 		return false;
 	}

     public function login_response($username = null,$password = null){
	 		$user = $this->find($username);
	 		if($user){
	 			if($this->data()->password === hash::make($password,$this->data()->salt)){
	 				return $this->data()->id;
	 			}	
	 		}
 		return false;
 	}

	
	
 	public function exists(){
 		return (!empty($this->_data)) ?true : false;
 	}
     
 	public function logout(){
 		session::delete($this->_sessionName);
 	}
 	public function data(){
 		return $this->_data;
 	}
 	public function isLoggedIn(){
 		return $this->_isLoggedIn;
 	}
    public function checkAccess($pageName){
        if($this->data()->group==2){
            $supervisor_access=array("dyes_status","lot_add","lot_view","user_password_change","dyes_modify");
            if(in_array($pageName,$supervisor_access)){
                return true;
            }
            return false;
        }
        return true;
    }

 }


?>