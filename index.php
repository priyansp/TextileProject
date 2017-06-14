<?php 
require 'includes/header.php';

if($user->isLoggedIn()){
//echo "hiiiiiiiiii";
echo $user->data()->otp;
if($user->data()->otp == 0)	{
	//redirect::to('login.php');
}
else{
	echo "enteringggg";
	if($user->data()->user_type == 'consignee'){
		redirect::to('consignee_home.php');
		}else if($user->data()->user_type == 'admin'){
		redirect::to('home.php');
		}else if($user->data()->user_type == 'marketing'){
			echo "entereddd";
		redirect::to('mark_home.php');
		}
}
}
else{
	redirect::to('home_general.php');
}
require_once 'includes/footer.php';
?>

        