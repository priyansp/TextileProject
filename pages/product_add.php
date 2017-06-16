<?php
require '../includes/header.php';
$db = DB::getInstance();
$categories = $db->query_assoc("select * from category;");
$categories = $categories->results();
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
                    <h2>Add Product</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="../form_actions/product_add.php" method="post" id="product-form" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product-name">Product Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="product-name" name="Product-Name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Choose Category</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="category" class="form-control" name="Category" required>
                               <option value='not_selected' selected>Choose Category</option>
                            <?php
                                for($x=0;$x<sizeof($categories);$x++){
                                echo "<option value='".$categories[$x]['category_id']."' >".$categories[$x]['category_name']."</option>";
                                } 
                            ?>
                          </select>
                          <ul class="select_list_error parsley-errors-list"><li>Choose a value</li></ul>
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