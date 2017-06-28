<?php
require '../includes/header.php';
if(!$user->checkAccess("vendor_edit")){
    redirect::to("login.php");
}
$db = DB::getInstance();
$vendor = $db->query_assoc("select * from vendors;");
$vendor = $vendor->results();
$is_present=false;
if(input::exists()){
    
    $submit_type=input::get('submit');
        if($submit_type==='get'){
            $vendor_id=input::get('Vendor-ID');
            $result=$db->get_assoc('vendors',array('vendor_id','=',$vendor_id));
            $result=$result->first();
            $is_present=true;
        }
        else if($submit_type==='update'){
            if($db->update_any('vendors','vendor_id',input::get('Vendor-ID'),array(
            'phone_number' => input::get('Phone'),
            'email' => input::get('Email'),
            'address' => input::get('Address'),
            'details' => input::get('Details'),
            'gstn' => input::get('GSTN'),
            ))){
            session::flash('vendor_edit_success','Vendor has been updated successfully');
            }
            $result=$db->get_assoc('vendors',array('vendor_id','=',input::get('Vendor-ID')));
            $result=$result->first();
            $is_present=true;
        }
}
?>
 <div class="right_col" role="main">
   <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
               <?php
                      if(session::exists('vendor_edit_success')){
                           echo "<div class='alert alert-success alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('vendor_edit_success') ."
                           </div>";
                        }
                        else if(session::exists('vendor_edit_failed')){
                           echo "<div class='alert alert-danger alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('vendor_edit_failed') ."
                           </div>";
                        }
                ?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Get Vendor</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="" method="post" id="Get-Vendor-Form" data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Choose Vendor Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" name="Vendor-ID" required>
                            <?php
                                for($x=0;$x<sizeof($vendor);$x++){
                                echo "<option value='".$vendor[$x]['vendor_id']."' >".$vendor[$x]['vendor_name']."</option>";
                                } 
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						  <div class="col-md-6">
						      <button type="submit" name="submit" value="get" class="btn btn-primary btn-block">Submit</button>    
						  </div>
                          
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
<?php
if($is_present){
?>
            
    <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit Vendor</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="" method="post" id="Vendor-Edit-Form" data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Vendor-Name">Vendor Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input type="hidden" class="form-control col-md-7 col-xs-12" value="<?php echo $result['vendor_id'];?>" name="Vendor-ID">
                          <input type="text" id="Vendor-Name" required="required" name="Vendor-Name"class="form-control col-md-7 col-xs-12" value="<?php echo $result['vendor_name'];?>" disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Phone">Phone<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="Phone" name="Phone" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $result['phone_number'];?>" pattern="[0-9]*" title="Enter 10 Digit phone Number">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Email">Email<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="Email" name="Email" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $result['email'];?>">
                        </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Address">Address</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="Address" class="form-control" name="Address" ><?php echo $result['address'];?></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Details">Details</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="Details" class="form-control" name="Details"><?php echo $result['details'];?></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="GSTN">GSTN<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="GSTN" name="GSTN" class="form-control col-md-7 col-xs-12" value="<?php echo $result['gstn'];?>">
                        </div>
                      </div>                                            
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <div class="col-md-3">
                              <button class="btn btn-danger btn-block" type="reset">Reset</button>    
                          </div>
						  <div class="col-md-3">
						      <button type="submit" name="submit" value="update" class="btn btn-primary btn-block">Submit</button>    
						  </div>
                          
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
<?php
}
?>
</div>
<?php
require '../includes/footer.php';
?>