<?php
require '../includes/header.php';
if(!$user->checkAccess("vendor_add")){
    redirect::to("login.php");
}
?>
 <div class="right_col" role="main">
    <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                   <?php
                      if(session::exists('vendor_add_success')){
                           echo "<div class='alert alert-success alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('vendor_add_success') ."
                           </div>";
                        }
                        else if(session::exists('vendor_add_failed')){
                           echo "<div class='alert alert-danger alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('vendor_add_failed') ."
                           </div>";
                        }
                ?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Vendor</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="../form_actions/vendor_add.php" method="post" id="Vendor-Form" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Vendor-Name">Vendor Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="Vendor-Name" name="Vendor-Name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Phone">Phone<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="Phone" name="Phone" required="required" class="form-control col-md-7 col-xs-12" pattern="[0-9]*">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Email">Email<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="Email" name="Email" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Address">Address</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="Address" class="form-control" name="Address"></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Details">Details</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="Details" class="form-control" name="Details"></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="GSTN">GSTN<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="GSTN" name="GSTN" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="GSTN">Type<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" name="Type" required>
                               <option value='not_selected' selected>Choose Vendor Type</option>
                               <option value='1'>Purchase</option>
                               <option value='2'>Sales</option>
                          </select>
                        </div>
                      </div>                                            
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <div class="col-md-3">
                              <button class="btn btn-danger btn-block" type="reset">Reset</button>    
                          </div>
						  <div class="col-md-3">
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