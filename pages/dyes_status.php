<?php
require '../includes/header.php';
$db = DB::getInstance();

$categories = $db->query_assoc("select * from category;");
$categories = $categories->results();

$products = $db->query_assoc("select * from product;");
$products = $products->results();

$vendors = $db->query_assoc("select * from vendors;");
$vendors = $vendors->results();

$query="select * from product";
$join="join vendors on vendors.vendor_id=product.vendor_id join category on product.category_id=category.category_id";
$query.=" ${join} order by LOWER(product.product_name);";
$result=$db->query_assoc($query)->results();

//Generating the Table for the Search
$table_body="";
for($i=0,$sno=1;$i<count($result);$i++,$sno++){
    $product_name=$result[$i]['product_name'];
    $vendor_name=$result[$i]['vendor_name'];
    $category_name=$result[$i]['category_name'];
    $quantity=$result[$i]['quantity'];
    $reorder_quantity=$result[$i]['reorder_qty'];
    $table_body.="<tr ";
    if($quantity<=$reorder_quantity){
        $table_body.="class='make_red'";
    }
    $table_body.="><td>${sno}</td><td>${product_name}</td><td>${vendor_name}</td><td>${category_name}</td><td>${quantity}</td><td>${reorder_quantity}</td></tr>";
}
?>
<div class="right_col" role="main">
    <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
               
               <?php
                  if(session::exists('product_add_failed')){
                       echo "<div class='alert alert-danger alert-dismissable'>
                              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                              ". session::flash('product_add_failed') ."
                       </div>";
                    }
                    else if(session::exists('product_add_success')){
                       echo "<div class='alert alert-success alert-dismissable'>
                              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                              ". session::flash('product_add_success') ."
                       </div>";
                    }
                ?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Dyes Stock Status(Choose Atleast Any One Value)</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="../form_actions/dyes_status.php" method="post" id="product-form" data-parsley-validate class="form-horizontal form-label-left">

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
                          <th>Reorder Qty</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            if(session::exists('dyes_status_table_body')){
                            echo session::flash('dyes_status_table_body');
                            }else{
                                echo $table_body;
                            }
                          ?>
                      </tbody>


                    </table>
                  </div>
                </div>
              </div>
    </div>
</div>
<?php
require '../includes/footer.php';
?>
<script>
$(document).ready(function(){
    $('form').submit(function(e){
        var select=$(this).find('select');
        var status=true;
        $(select).each(function(){
            if($(this).val()!='selected'){
                status=false;
            }
        });
        if(status){
            e.preventDefault();
            $(select).addClass('select_errored');
        }
    });    
});
</script>