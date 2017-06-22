<?php
require '../includes/header.php';

$is_present=false;
if(input::exists()){
    $db = DB::getInstance();
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
            $quantity=$product_json[$i]['quantity'];
            $rate=$product_json[$i]['rate'];
            $amount=$product_json[$i]['amount'];
            $table_body.="<tr><td>${sno}</td><td>${product_name}</td><td>${quantity}</td><td>${rate}</td><td>${amount}</td></tr>";
        }
    }
    else{
        session::flash("lot_view_failed","Oops! The lot number has not been entried yet");
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
                    <h2>Lot Details</h2>
                    <div class="col-md-offset-9 col-md-2">
                        <button class="btn btn-warning" id="print_button">Print</button>
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
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Profit(%)<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="number" value="0" id="Profit" required="required" name="Profit" class="form-control col-md-7 col-xs-12" value="<?php echo $result['profit'];?>" readonly>
                        </div>
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Total<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="Total-Price"  required="required" name="Total-Price" class="form-control col-md-7 col-xs-12" value="<?php echo $result['total_price'];?>" readonly>
                        </div>
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Per Kg<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="Per-Kg"  required="required" name="Per-Kg" class="form-control col-md-7 col-xs-12" value="<?php echo $result['per_kg_price'];?>" readonly>
                        </div>
                        <div class="form-group">
                        </div> 
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
                                  <th>Quantity</th>
                                  <th>Price</th>
                                  <th>Amount</th>
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
            <?php } ?>
</div>
<?php
require '../includes/footer.php';
?>
<script>
    $("#print_button").click(function(){
        window.print();
        /*var text=$("#print_div").html();
        var printWindow=window.open('','','width=900,height=650');
        printWindow.document.write(text);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();*/
    });
</script>