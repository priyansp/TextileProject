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
					$this->addError("{$item} is required");
				}else if(!empty($value)){
					switch($rule){
					case 'min':
						if(strlen($value) < $rule_value){
							$this->addError("{$item} must be minimum of {$rule_value}");
						}
					break;
					case 'max':
						if(strlen($value) > $rule_value){
							$this->addError("{$item} must be maximum of {$rule_value}");
						}
					break;
					case 'match':
						if($value != $source[$rule_value]){
							$this->addError("{$item} does not match {$rule_value}");
						}
					break;
					case 'unique':
						$check = $this->_db->get($rule_value,array($item,'=',$value));
						if($check->count()){
							$this->addError("{$item} already exists!");
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


	private function addError($error){
		$this->_error[] = $error;
	}

	public function error(){
		return $this->_error;
	}

	public function passed(){
		return $this->_passes;
	}

}