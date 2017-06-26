<?php
require '../includes/header.php';
if(!$user->checkAccess("dyes_modify")){
    redirect::to("login.php");
}
$db = DB::getInstance();
$product = $db->query_assoc("select product_id,product_name from product order by product_name;");
$product = $product->results();
?>
 <div class="right_col" role="main">
    <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
               <?php
                      if(session::exists('dyes_modify_success')){
                           echo "<div class='alert alert-success alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('dyes_modify_success') ."
                           </div>";
                        }
                        else if(session::exists('dyes_modify_failed')){
                           echo "<div class='alert alert-danger alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('dyes_modify_failed') ."
                           </div>";
                        }
                ?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Modify Dyes Stock</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" action="../form_actions/dyes_modify.php" method="post" data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Type</label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <label class="btn">
                              <input type="radio" name="Type" value=1 checked="checked">Add
                            </label>
                            <label class="btn">
                              <input type="radio" name="Type" value=0> Deduct
                            </label>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Date">Date<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="date" id="Date" required="required" name="Date" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                       <div id="dynamic_form_container">
                       
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
</div>
<?php
require '../includes/footer.php';
?>
<script>
    var products=<?php echo json_encode($product);?>;
    var form_html="";
    var product_select="<div class='col-md-3 col-sm-4 col-xs-12'>\n<select name='Product-List[]' class='form-control product_select'>\n<option value='not_selected' selected>Choose Product</option>\n";
    
    
    $(document).ready(function(){
        var today = moment().format('YYYY-MM-DD');
        $("#Date").val(today);
        for(i in products){
            product_select+="<option value='"+products[i].product_id+"'>"+products[i].product_name+"</option>\n";
        }
        product_select+="</select></div>";
        
        form_html="<div class='dynamic_form_content'>"+product_select+"<div class='col-md-3 col-sm-4 col-xs-12'><input name='Quantity-List[]' step='0.001' type='number' placeholder='Quantity Of' min='0.001' id='first-name' required='required' class='form-control col-md-7 col-xs-12 qty_number'></div><div class='col-md-2 col-sm-4 col-xs-12 max_qty'><input name='max_qty[]' type='text' class='form-control col-md-7 col-xs-12' value='0' readonly/></div><div class='col-md-1'><button type='button' class='btn btn-warning btn-block form_add'>Add</button></div><div class='col-md-1'><button type='button' class='btn btn-danger btn-block form_del'>Del</button></div><div class='form-group'></div></div>";
        
        var first_form_element="<div class='dynamic_form_content'>"+product_select+"<div class='col-md-3 col-sm-4 col-xs-12'><input name='Quantity-List[]' type='number' placeholder='Quantity Of' min='0.001' step='0.001' required='required' class='form-control col-md-7 col-xs-12 qty_number'></div><div class='col-md-2 col-sm-4 col-xs-12 max_qty'><input name='max_qty[]'  type='text' class='form-control col-md-7 col-xs-12' value='0' readonly/></div><div class='col-md-2'><button type='button' class='btn btn-warning btn-block form_add'>Add</button></div><div class='form-group'></div></div>";
        
        $('#dynamic_form_container').append(first_form_element);    
    });
    
    $('#dynamic_form_container').on('click','.form_add',function(){
        $(this).parent().parent().parent().append(form_html);
        
        //To display the max_qty box even after clicking the deduct button
        if($('input[type="radio"]:checked').val()==0){
            $(this).parents('form').find('.max_qty').css({"display": "block"});
        }
    });
    
    $('#dynamic_form_container').on('click','.form_del',function(){
        $(this).parent().parent().remove();
    });
    
    $('input[type="radio"]').change(function(){
        if($(this).val()==0){
            $(this).parents('form').find('.max_qty').css({"display": "block"});
            $(this).parents('form').find('select').change();
        }
        else{
            $(this).parents('form').find('.max_qty').css({"display": "none"});
            $(this).parents('form').find('.qty_number').removeAttr('max');
            $(this).parents('form').find('.qty_number').attr('min',1);
            $(this).parents('form').find('.qty_number').val(1);
        }
    
    });
    
    $("#dynamic_form_container").on("change","select",function(){
        if($('input[type="radio"]:checked').val()==0){
            var parent=$(this).parents('.dynamic_form_content');
            var product_id=$(this).val();
            
            if(product_id!='not_selected'){
                $.post('../rest_calls/get_quantity.php',{
                    product_id:product_id
                },function(data){
                    data=$.parseJSON(data);
                    quantity=parseFloat(data.quantity);
                    
                    $(parent).find('.max_qty input').val(quantity);
                    $(parent).find('.qty_number').attr('max',quantity);
                    if(!quantity){
                        $(parent).find('.qty_number').attr('min',quantity);
                    }
                    var current_quantity=$(parent).find('.qty_number').val();
                    if(current_quantity>quantity){
                        $(parent).find('.qty_number').val(quantity);
                    }
                });
            }
        }
	});
    
</script>