<?php
require '../includes/header.php';
if(!$user->checkAccess("product_edit")){
    redirect::to("login.php");
}
$db = DB::getInstance();
$products = $db->query_assoc("select * from product order by LOWER(product_name);");
$products = $products->results();
$category = $db->query_assoc("select * from category order by LOWER(category_name);");
$category = $category->results();
$is_present=false;
if(input::exists()){
    
    $submit_type=input::get('submit');
        if($submit_type==='get'){
            $product_id=input::get('Product-ID');
            $result=$db->get_assoc('product',array('product_id','=',$product_id));
            $result=$result->first();
            $is_present=true;
        }
        else if($submit_type==='update'){
            if($db->update_any('product','product_id',input::get('Product-ID'),array(
            'reorder_qty' => input::get('Reorder_Qty'),
            'category_id' => input::get('Category-ID'),
            'rate' => input::get('Rate'),
            ))){
            session::flash('product_edit_success','Product has been updated successfully');
            }
            $result=$db->get_assoc('product',array('product_id','=',input::get('Product-ID')));
            $result=$result->first();
            $is_present=true;
        }
}
?>
 <div class="right_col" role="main">
   <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
               <?php
                      if(session::exists('product_edit_success')){
                           echo "<div class='alert alert-success alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('product_edit_success') ."
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
                    <h2>Get Product Info</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="" method="post" data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Choose Product Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" name="Product-ID" required>
                            <?php
                                for($x=0;$x<sizeof($products);$x++){
                                echo "<option value='".$products[$x]['product_id']."' >".$products[$x]['product_name']."</option>";
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
                    <h2>Edit Product</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="" method="post"  data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <input type="hidden" class="form-control col-md-7 col-xs-12" value="<?php echo $result['product_id'];?>" name="Product-ID">
                          <input type="text" id="Product-Name" required="required" name="Product-Name"class="form-control col-md-7 col-xs-12" value="<?php echo $result['product_name'];?>" disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Phone">Re-Ordering Quantity<span  class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" name="Reorder_Qty" class="form-control col-md-7 col-xs-12" value="<?php echo $result['reorder_qty'];?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Phone">Rate
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" name="Rate" step="0.01" class="form-control col-md-7 col-xs-12" value="<?php echo $result['rate'];?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" name="Category-ID" required>
                            <?php
                                for($x=0;$x<sizeof($category);$x++){
                                    if($category[$x]['category_id']==$result['category_id']){
                                        echo "<option value='".$category[$x]['category_id']."' selected>".$category[$x]['category_name']."</option>";    
                                    }
                                    else{
                                        echo "<option value='".$category[$x]['category_id']."' >".$category[$x]['category_name']."</option>";    
                                    }  
                                } 
                            ?>
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