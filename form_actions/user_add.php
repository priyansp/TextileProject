<?php
require_once '../core/init.php';
if(input::exists()){
    $validate = new validate();
		$validation = $validate->check($_POST, array(
			'User-Name' => array(
				'required' => true,
				'unique' => 'user,user_name'
			),
            'Password' => array(
				'required' => true,
			),
            'Re-Password' => array(
				'required' => true,
                'match' =>'Password'
			),
            'Group' => array(
				'shouldnt_match' =>'not_selected',
			)
    ));
    if($validation->passed()){
        $db=DB::getInstance();
        $salt=hash::salt(32);
        $user=new user();
        try{
        $user->create(array(
        'user_name' => input::get('User-Name'),
        'password' => hash::make(input::get('Password'),$salt),
        'salt' => $salt,
        'group' => input::get('Group'),
        ));
        }
        catch(Exception $e){
				die($e->getMessage());
        }
        session::flash('user_add_success',"Success!User has been added successfully");
        redirect::to('../pages/user_add.php');
    }
    else{
        $validation->addFlash('user_add_failed');
        redirect::to('../pages/user_add.php');
    }
}
?>
