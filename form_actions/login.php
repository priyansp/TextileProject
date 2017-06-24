<?php
require_once '../core/init.php';
if(input::exists()){
    $validate = new validate();
		$validation = $validate->check($_POST, array(
			'Username' => array(
				'required' => true,
			),
            'Password' => array(
				'required' => true,
			)
    ));
    if($validation->passed()){
            $user = new user();
			$remember = (input::get('remember') === 'on') ? true : false; 
			$login = $user->login(input::get('Username'),input::get('Password'),$remember); 
            if($login){
                if($user->data()->group==1){
                    redirect::to('../pages/dyes_home.php');
                }
                else if($user->data()->group==2){
                    redirect::to('../pages/dyes_status.php');
                }
            }
            else{
                session::flash('login_failed',"Oops!Username or Password Incorrect");    
                redirect::to('../pages/login.php');
            }
    }
    else{
        $validation->addFlash('login_failed');
        redirect::to('../pages/login.php');
    }
}
?>
