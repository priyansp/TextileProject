<?php
require '../includes/header.php';
if(!$user->checkAccess("lot_view")){
    redirect::to("login.php");
}
$is_present=false;
$db = DB::getInstance();
if(input::exists()){
    $lot_no=input::get("Lot-No");
    $query="select * from lot_details where lot_no=${lot_no};";
    $query_result = $db->query_assoc($query);
    $rows=$query_result->rcount();
    if($rows){
        $is_present=true;
        $result=$query_result->first();
        $product_json=$result['products'];
        $product_json=json_decode($product_json,true);
        $table_body="";
        for($i=0,$sno=1;$i<count($product_json);$i++,$sno++){
            $product_name=$product_json[$i]['product_name'];
            $category_name=$product_json[$i]['category']==1?"Dyes":"Chemicals";
            $quantity=$product_json[$i]['quantity'];
            $rate=$product_json[$i]['rate'];
            $amount=$product_json[$i]['amount'];
            $table_body.="<tr><td>${sno}</td><td>${product_name}</td><td>${category_name}</td><td>${quantity}</td>";
            if($user->data()->group==1){
                $table_body.="<td>${rate}</td><td>${amount}</td>";
            }
            $table_body.="</tr>";
        }
    }
    else{
        session::flash("lot_view_failed","Oops! The lot number has not been entried yet");
        redirect::to('lot_view.php');
    }
}
else{
$query="select * from lot_details order by lot_id desc;";
$query_result = $db->query_assoc($query)->results();
$table_body="";
    for($i=0,$sno=1;$i<count($query_result);$i++,$sno++){
        $lot_no=$query_result[$i]['lot_no'];
        $weight=$query_result[$i]['weight'];
        $date=$query_result[$i]['date'];
        $party=$query_result[$i]['party_name'];
        $shade=$query_result[$i]['shade_name'];
        $table_body.="<tr><td>${sno}</td><td>${lot_no}</td><td>${party}</td><td>${shade}</td><td>${weight}</td><td>${date}</td>";
        $table_body.="</tr>";
    }
}

?>
<div class="right_col" role="main">
   <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                   <?php
                        if(session::exists('lot_view_failed')){
                           echo "<div class='alert alert-danger alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('lot_view_failed') ."
                           </div>";
                        }
                    ?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Get Lot Details</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="" method="post" id="Get-Vendor-Form" data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Lot No</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" name="Lot-No" required="required" class="form-control col-md-7 col-xs-12"/>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-6 col-xs-12">
						  <div class="col-md-4 col-md-offset-4">
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
              <div class="col-md-12 col-sm-12 col-xs-12" id="print_div">
                <div class="x_panel">
                  <div class="x_title">
                   <div class="col-md-6">
                    <h2>Lot Details</h2>
                   </div>
                   <div class="col-md-6">
                       <div class="col-md-3 col-md-offset-6">
                            <form action="lot_add.php" method="post">
                                <input type="hidden" name="lot_no" value="<?php echo $result['lot_no'];?>"/>
                                <input type="hidden" name="type" value="1"/>
                                <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block">Edit</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form action="lot_add.php" method="post">
                                <input type="hidden" name="lot_no" value="<?php echo $result['lot_no'];?>"/>
                                <input type="hidden" name="type" value="2"/>
                                <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">Copy</button>
                                </div>
                            </form>
                        </div>
                   </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                       <form class="form-horizontal form-label-left">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12" >Lot No.<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="number" id="Lot-No" required="required" name="Lot-No" class="form-control col-md-7 col-xs-12" value="<?php echo $result['lot_no'];?>" readonly>
                        </div>
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Weight<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="number" id="Weight" min="1" required="required" name="Weight" class="form-control col-md-7 col-xs-12" value="<?php echo $result['weight'];?>" readonly>
                        </div>
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Date<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="date" id="Date" required="required" name="Date" class="form-control col-md-7 col-xs-12" value="<?php echo $result['date'];?>" readonly>
                        </div>
                        <div class="form-group">
                        </div> 
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Count<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="Lot-No" required="required" name="Count" class="form-control col-md-7 col-xs-12" value="<?php echo $result['count'];?>" readonly>
                        </div>
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Party<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="Party" required="required" name="Party" class="form-control col-md-7 col-xs-12" value="<?php echo $result['party_name'];?>" readonly>
                        </div>
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Shade<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="Shade" required="required" name="Shade" class="form-control col-md-7 col-xs-12" value="<?php echo $result['shade_name'];?>" readonly>
                        </div>
                        <div class="form-group">
                        </div>
                        <?php if($user->data()->group==1) { ?>
                        <div class="ln_solid"></div>
                        <div class="col-md-4">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Profit(%)<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="number" id="Profit" required="required" name="Profit" class="form-control col-md-7 col-xs-12" value="<?php echo $result['profit'];?>" readonly>
                        </div>
                        </div>
                        <div class="col-md-4">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Total<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Total-Price"  required="required" name="Total-Price" class="form-control col-md-7 col-xs-12" value="<?php echo $result['total_price'];?>" readonly>
                        </div>
                        </div>
                        <div class="col-md-4">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Per Kg<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Per-Kg"  required="required" name="Per-Kg" class="form-control col-md-7 col-xs-12" value="<?php echo $result['per_kg_price'];?>" readonly>
                        </div>
                        </div>  
                        <div class="form-group">
                        </div>

                        <div class="col-md-4 ">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Overheads(Kg)<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="number" id="Overheads"  required="required" name="Overheads" class="form-control col-md-12 col-xs-12" value="<?php echo $result['overheads_per_kg'];?>" readonly>
                         </div>
                        </div>
                        <div class="col-md-4 ">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Dyes-Total<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Dyes-Total"  required="required" name="Dyes-Total" class="form-control col-md-12 col-xs-12" readonly value="<?php echo $result['dyes_total'];?>">
                         </div>
                        </div>
                        <div class="col-md-4 ">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Dyes-Per-Kg<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Dyes-Per-Kg"  required="required" name="Dyes-Per-Kg" class="form-control col-md-12 col-xs-12" readonly value="<?php echo $result['dyes_per_kg'];?>">
                         </div>
                        </div>
                        
                        <div class=" form-group">
                        </div>
                        <div class="col-md-4">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Overheads<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Overheads-Total"  required="required" name="Overheads-Total" class="form-control col-md-12 col-xs-12" value="<?php echo $result['overheads_total'];?>" readonly name="Overheads-Total">
                         </div>
                        </div>
                        <div class="col-md-4">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Chem-Total<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Chemicals-Total"  required="required" name="Chemicals-Total" class="form-control col-md-12 col-xs-12" readonly value="<?php echo $result['chemicals_total']?>">
                         </div>
                        </div>
                        <div class="col-md-4">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Chem-Per-Kg<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Chem-Per-Kg"  required="required" name="Chemicals-Per-Kg" class="form-control col-md-12 col-xs-12" readonly value="<?php echo $result['chemicals_per_kg'];?>">
                         </div>
                        </div> 
                        <div class="hide-div form-group">
                        </div> 
                        <?php } ?>
                        </form>
                        <div class="x_title">
                            <h4>Dyes &amp; Chemicals(Consumption)</h4>
                            <div class="clearfix"></div>
                        </div>
                        <table id="datatable" class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                  <th>S.No</th>
                                  <th>Product Name</th>
                                  <th>Category</th>
                                  <th>Quantity</th>
                                  <?php if($user->data()->group==1){ ?>
                                  <th>Price</th>
                                  <th>Amount</th>
                                  <?php } ?>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php echo $table_body; ?>
                              </tbody>
                        </table>
                  </div>
                </div>
              </div>
            </div>
            <?php } else { ?>
    <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                   <div class="col-md-6">
                        <h2>All Lots</h2>   
                   </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" id="table_div">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Lot No</th>
                          <th>Party</th>
                          <th>Shade</th>
                          <th>Weight</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            echo $table_body;
                          ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
    </div>
    <?php } ?>
</div>
<?php
require '../includes/footer.php';
?>