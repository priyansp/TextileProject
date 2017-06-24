<?php
require '../includes/header.php';
if(!$user->checkAccess("user_add")){
    redirect::to("login.php");
}
?>
 <div class="right_col" role="main">
    <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                   <?php
                      if(session::exists('user_add_success')){
                           echo "<div class='alert alert-success alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('user_add_success') ."
                           </div>";
                        }
                        else if(session::exists('user_add_failed')){
                           echo "<div class='alert alert-danger alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('user_add_failed') ."
                           </div>";
                        }
                ?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add User</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="../form_actions/user_add.php" method="post" id="User-Form" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="User-Name">UserName<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="User-Name" name="User-Name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Password">Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="Password" name="Password" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Re-Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="Re-Password" name="Re-Password" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Group">Group</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="Group" class="form-control" name="Group" required>
                               <option value='not_selected' selected>Choose Group</option>
                               <option value='1'>Admin</option>
                               <option value='2'>Supervisor</option>
                            </select>
                          </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-6 col-xs-12">
						  <div class="col-md-4 col-md-offset-4">
						      <button type="submit" class="btn btn-primary btn-block">Submit</button>    
						  </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
</div>
<?php
require '../includes/footer.php';
?>