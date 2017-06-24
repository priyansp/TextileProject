<?php
require_once '../core/init.php';
if(input::exists()){
    $validate = new validate();
		$validation = $validate->check($_POST, array(
			'Current-Password' => array(
				'required' => true,
			),
            'Password' => array(
				'required' => true,
			),
            'Re-Password' => array(
				'required' => true,
                'match' =>'Password'
			),
    ));
    if($validation->passed()){
        $db=DB::getInstance();
        $user=new user();
        $username=$user->data()->user_name;
        $login = $user->login($username,input::get('Current-Password'));
        if($login){
            $salt=hash::salt(32);
            $password=hash::make(input::get('Password'),$salt);
            if($db->update_any('user','user_id',$user->data()->user_id,array(
            'salt'=>$salt,
            'password'=>hash::make(input::get('Password'),$salt),
            ))){
                session::flash('user_password_change_success','Password has been updated successfully');
                redirect::to('../pages/user_password_change.php');    
            }
            else{
                echo "fucked";
            }
        }
        else{
            session::flash('user_password_change_failed',"Oops!Current Password is not correct");
            redirect::to('../pages/user_password_change.php');    
        }
        
    }
    else{
        $validation->addFlash('user_password_change_failed');
        redirect::to('../pages/user_password_change.php');
    }
}
?>
