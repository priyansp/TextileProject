<?php
class hash{
	public static function make($string , $salt = ''){
		return hash('sha256',$string . $salt);
	}

	public static function salt($length){
		return join('', array_map(function($value) { return $value == 1 ? mt_rand(1, 9) : mt_rand(0, 9); }, range(1, $length)));
	}

	public static function unique(){
		return self::make(uniqid());
	}

}

?>