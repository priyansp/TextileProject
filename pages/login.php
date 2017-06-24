<?php
require_once '../core/init.php';
$user=new user();
if($user->isLoggedIn()){
    if($user->data()->group==1){
        redirect::to("dyes_home.php");
    }
    else if($user->data()->group==2){
        redirect::to("dyes_status.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Thirumala Colours | </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>
  
<body class="login">
    <div>
      <div class="login_wrapper">
       
        <div class="animate form login_form">
          <section class="login_content">
            <?php
             if(session::exists('login_failed')){
                           echo "<h4 style='color:rgb(177, 53, 53)'>
                                  ". session::flash('login_failed') ."
                           </h4>";
            }?>
            <form action="../form_actions/login.php" method="post" autocomplete="false">
              <h1>Login</h1>
              <div>
                <input type="text" class="form-control" name="Username" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" name="Password" class="form-control" placeholder="Password" required="" autocomplete="new-password"/>
              </div>
              <div class="col-md-4 col-md-offset-4">
                  <button type="submit" class="btn btn-primary btn-block">Login</button>    
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1>Thirumala Colour Processors</h1>
                  <h4>Kadayampatti</h4>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
</body>



<?php
//require '../includes/footer.php';
?>