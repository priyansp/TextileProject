<?php
require '../includes/header.php';
$db = DB::getInstance();

$categories = $db->query_assoc("select * from category;");
$categories = $categories->results();

$products = $db->query_assoc("select * from product;");
$products = $products->results();

$vendors = $db->query_assoc("select * from vendors;");
$vendors = $vendors->results();
?>
<div class="right_col" role="main">
    <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Dyes Transaction History(Choose Atleast Any One Value)</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="../form_actions/dyes_history.php" method="post" id="product-form" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <select class="form-control" name="Category" required>
                               <option value='selected' selected>Choose Category</option>
                            <?php
                                for($x=0;$x<sizeof($categories);$x++){
                                echo "<option value='".$categories[$x]['category_id']."' >".$categories[$x]['category_name']."</option>";
                                } 
                            ?>
                          </select>                    
                        </div>
                                        
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <select class="form-control" name="Product" required>
                               <option value='selected' selected>Choose Product</option>
                            <?php
                                for($x=0;$x<sizeof($products);$x++){
                                echo "<option value='".$products[$x]['product_id']."' >".$products[$x]['product_name']."</option>";
                                } 
                            ?>
                          </select>
                        </div>
                        
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <select class="form-control" name="Vendor" required>
                               <option value='selected' selected>Choose Vendor</option>
                            <?php
                                for($x=0;$x<sizeof($vendors);$x++){
                                echo "<option value='".$vendors[$x]['vendor_id']."' >".$vendors[$x]['vendor_name']."</option>";
                                } 
                            ?>
                          </select>
                        </div>
                        
                        <div class="form-group">
                            
                        </div>
                        
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="FromDate">From Date<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <input type="date" id="FromDate" name="FromDate" class="form-control col-md-7 col-xs-12">
                        </div>
                        
                        
                        
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="ToDate">To Date<span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <input type="date" id="ToDate" name="ToDate" class="form-control col-md-7 col-xs-12" title="To date should be greater than from Date" disabled>
                        </div>
                        
                        <div class="form-group">
                            
                        </div>
                        
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						  <div class="col-md-6">
						      <button type="submit" class="btn btn-primary btn-block">Submit</button>    
						  </div>
                          
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
    </div>
    <?php
    if(session::exists('table_body')){
    ?>
    <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Stock Details</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Product</th>
                          <th>Vendor</th>
                          <th>Category</th>
                          <th>Quantity</th>
                          <th>Type</th>
                          <th>Date</th>
                          <th>Total Stock</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            echo session::flash('table_body');
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
<script>
$(document).ready(function(){
    
    $("#FromDate").change(function(){
        var val=$(this).val();
        if(val){
            $('#ToDate').prop("disabled",false);
            $("#ToDate").attr('min',val);
        }
        else{
            $('#ToDate').prop("disabled",true);
            $('#ToDate').val('');
        }
    });
    $('form').submit(function(e){
        var status=true;
        $('select').each(function(){
            if($(this).val()!='selected'){
                status=false;
            }
        });
        if($('#FromDate').val()){
            status=false;
        }
        if(status){
            e.preventDefault();
            $('select').addClass('select_errored');
        }
    });    
});
</script>