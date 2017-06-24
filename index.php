<?php 
require_once 'core/init.php';
//Including the classes manually since autoload is not working here
require_once 'classes/redirect.php';
require_once 'classes/DB.php';
require_once 'classes/session.php';
require_once 'classes/redirect.php';
require_once 'classes/user.php';
require_once 'classes/config.php';
$user=new user();
if($user->isLoggedIn()){
    if($user->data()->group==1){
        redirect::to("pages/dyes_home.php");
    }
    else if($user->data()->group==2){
        redirect::to("pages/dyes_status.php");
    }
}
else{
    redirect::to("pages/login.php");
}
//redirect::to("pages/dyes_home.php");
?>

        