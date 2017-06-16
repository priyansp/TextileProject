<?php
class validate{
	private $_passes = false,
	$_error = array(),
	$_db = null;

	public function __construct(){
		$this->_db = DB::getInstance();
	}

	public function check($source,$items = array()){
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				$value = $source[$item];
				if($rule === 'required' && empty($value)){
					$this->addError($item,"{$item} is required");
				}else if(!empty($value)){
					switch($rule){
					case 'min':
						if(strlen($value) < $rule_value){
							$this->addError($item,"{$item} must be minimum of {$rule_value}");
						}
					break;
					case 'max':
						if(strlen($value) > $rule_value){
							$this->addError($item,"{$item} must be maximum of {$rule_value}");
						}
					break;
					case 'match':
						if($value != $source[$rule_value]){
							$this->addError($item,"{$item} does not match {$rule_value}");
						}
					break;
                    case 'shouldnt_match':
						if($value === $rule_value){
							$this->addError($item,"Choose a Value for {$item} ");
						}
					break;
					case 'unique':
                        $exploded_values=explode(",",$rule_value);
						$check = $this->_db->get($exploded_values[0],array($exploded_values[1],'=',$value));
						if($check->count()){
							$this->addError($item,"{$item} already exists!");
						}
					break;
					}
				}
			}
		}
		if(empty($this->_error)){
			$this->_passes = true;
		}

		return $this;
	}


	private function addError($key,$error){
		$this->_error[$key] = $error;
	}

	public function error(){
		return $this->_error;
	}

	public function passed(){
		return $this->_passes;
	}
    
    public function addFlash($flash_key){
        $error_string="<ul class='validation_error'>";
        foreach ($this->_error as $key=>$value){
            $error_string=$error_string . "<li>${value}</br></li>";
        }
        $error_string.="</ul>";
        session::flash($flash_key,$error_string);
    }

}