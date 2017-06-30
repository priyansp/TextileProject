<?php
require '../includes/header.php';
if(!$user->checkAccess("ledger_entry")){
    redirect::to("login.php");
}
$db = DB::getInstance();
$vendors = $db->query_assoc("select * from vendors where type=2 order by LOWER(vendor_name);;");
$vendors = $vendors->results();
?>
 <div class="right_col" role="main">
    <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                   <?php
                      if(session::exists('ledger_entry_add_success')){
                           echo "<div class='alert alert-success alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('ledger_entry_add_success') ."
                           </div>";
                        }
                        else if(session::exists('ledger_entry_add_failed')){
                           echo "<div class='alert alert-danger alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('ledger_entry_add_failed') ."
                           </div>";
                        }
                ?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Sale Entry</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="../form_actions/ledger_add_entry.php" method="post" id="Ledger-Entry-Form" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Vendor-Name">Vendor Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="category" class="form-control" name="Vendor" required>
                               <option value='not_selected' selected>Choose Vendor</option>
                            <?php
                                for($x=0;$x<sizeof($vendors);$x++){
                                echo "<option value='".$vendors[$x]['vendor_id']."' >".$vendors[$x]['vendor_name']."</option>";
                                } 
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Reference">Reference<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="Phone" name="Reference" required="required" class="form-control col-md-7 col-xs-12" placeholder="Bill No/Payment Mode">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Amount">Amount<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" step="0.01" id="Amount" name="Amount" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Amount">Entry for Date<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="date" id="Date" name="Date" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Entry Type</label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <label class="btn">
                              <input type="radio" name="Entry-Type" value="4" checked="checked">Credit
                            </label>
                            <label class="btn">
                              <input type="radio" name="Entry-Type" value="3" >Debit
                            </label>
                        </div>
                      </div>                                            
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-6 col-xs-12 ">
                          <div class="col-md-3 col-md-offset-3">
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