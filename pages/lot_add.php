<?php
require '../includes/header.php';
if(!$user->checkAccess("lot_add")){
    redirect::to("login.php");
}
$db = DB::getInstance();
$product = $db->query_assoc("select product_id,product_name from product order by product_name;");
$product = $product->results();
$data_present=false;
$fix_lot=false;
if(input::exists()){
    $lot_no=input::get('lot_no');
    $type=input::get('type');
    $query="select * from lot_details where lot_no=${lot_no};";
    $query= $db->query_assoc($query);
    $results=$query->first();
    $data_present=true;
    if($type==1){
        $fix_lot=true;
    }
}
?>
<?php if($user->data()->group==2){  ?>
<style>
    .hide-div{
        display:none;
    }
</style>
<?php } ?>
<style>
    #lot_duplicate_error{
        display:none;
    }
    .dyes_product{
        background: rgba(163, 156, 220, 0.45) !important;
    }
    .chemical_product{
        background:rgba(241, 214, 26, 0.45) !important;
    }
</style>
 <div class="right_col" role="main">
    <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
               <?php
                      if(session::exists('lot_add_success')){
                           echo "<div class='alert alert-success alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('lot_add_success') ."
                           </div>";
                        }
                        else if(session::exists('lot_add_failed')){
                           echo "<div class='alert alert-danger alert-dismissable'>
                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                  ". session::flash('lot_add_failed') ."
                           </div>";
                        }
                ?>
                <div class='alert alert-danger alert-dismissable' id="lot_duplicate_error">
                    <a href='#' class='close' aria-label='close'>&times;</a>
                    Oops!The lot number is already present.Try Editing the lot
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Lot</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="../form_actions/lot_add.php" method="post" data-parsley-validate class="form-horizontal form-label-left">
                        <label class="control-label col-md-1 col-sm-3 col-xs-12" >Lot No.<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="number" id="Lot-No" required="required" name="Lot-No" class="form-control col-md-7 col-xs-12" value="<?php echo $fix_lot?$lot_no:"";?>" <?php echo $fix_lot?"readonly":"";?>>
                                <input type="hidden" id="type" required="required" name="type" class="form-control col-md-7                                 col-xs-12" value="<?php echo $data_present?$type:2;?>" />
                        </div>
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Weight<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="number" id="Weight" min="1" required="required" name="Weight" class="form-control col-md-7 col-xs-12" value="<?php echo $data_present?$results['weight']:"";?>">
                        </div>
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Date<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="date" id="Date" required="required" name="Date" class="form-control col-md-7 col-xs-12" value="<?php echo $data_present?$results['date']:"";?>">
                        </div>
                        
                        <div class="form-group">
                        </div>  
                        
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Count<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="Lot-No" required="required" name="Count" class="form-control col-md-7 col-xs-12" value="<?php echo $data_present?$results['count']:"";?>">
                        </div>
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Party<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="Party" required="required" name="Party" class="form-control col-md-7 col-xs-12" value="<?php echo $data_present?$results['party_name']:"";?>">
                        </div>
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Shade<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="Shade" required="required" name="Shade" class="form-control col-md-7 col-xs-12" value="<?php echo $data_present?$results['shade_name']:"";?>">
                        </div>
                        
                        <div class="form-group">
                        </div>
                         
                        <div class="hide-div ln_solid"></div>
                        
                        <div class="col-md-4 hide-div"> 
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Profit(%)<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="number" id="Profit" required="required" name="Profit" class="form-control col-md-12 col-xs-12" value="<?php echo $data_present?$results['profit']:0;?>">
                        </div>
                        </div>
                        
                        <div class="col-md-4 hide-div">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Total<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Total-Price"  required="required" name="Total-Price" class="form-control col-md-12 col-xs-12" readonly value="<?php echo $data_present?$results['total_price']:0;?>">
                        </div>
                        </div>
                        <div class="col-md-4 hide-div">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Per Kg<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Per-Kg"  required="required" name="Per-Kg" class="form-control col-md-12 col-xs-12" readonly value="<?php echo $data_present?$results['per_kg_price']:0;?>">
                        </div>
                        </div>
                        
                        <div class="hide-div form-group">
                        </div> 
                        
                        <div class="col-md-4 hide-div">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Overheads(Kg)<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="number" id="Overheads"  required="required" name="Overheads" class="form-control col-md-12 col-xs-12" value="<?php echo $data_present?$results['overheads_per_kg']:0;?>">
                         </div>
                        </div>
                        <div class="col-md-4 hide-div">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Dyes-Total<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Dyes-Total"  required="required" name="Dyes-Total" class="form-control col-md-12 col-xs-12" readonly value="<?php echo $data_present?$results['dyes_total']:0;?>">
                         </div>
                        </div>
                        <div class="col-md-4 hide-div">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Dyes-Per-Kg<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Dyes-Per-Kg"  required="required" name="Dyes-Per-Kg" class="form-control col-md-12 col-xs-12" readonly value="<?php echo $data_present?$results['dyes_per_kg']:0;?>">
                         </div>
                        </div>
                        
                        <div class="hide-div form-group">
                        </div>
                        <div class="col-md-4 hide-div">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Overheads<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Overheads-Total"  required="required" name="Overheads-Total" class="form-control col-md-12 col-xs-12" value="<?php echo $data_present?$results['overheads_total']:0;?>" readonly name="Overheads-Total">
                         </div>
                        </div>
                        <div class="col-md-4 hide-div">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Chem-Total<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Chemicals-Total"  required="required" name="Chemicals-Total" class="form-control col-md-12 col-xs-12" readonly value="<?php echo $data_present?$results['chemicals_total']:0;?>">
                         </div>
                        </div>
                        <div class="col-md-4 hide-div">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Chem-Per-Kg<span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <input type="text" id="Chem-Per-Kg"  required="required" name="Chemicals-Per-Kg" class="form-control col-md-12 col-xs-12" readonly value="<?php echo $data_present?$results['chemicals_per_kg']:0;?>">
                         </div>
                        </div> 
                        <div class="hide-div form-group">
                        </div>
                        <div class="x_title">
                            <h4>Dyes &amp; Chemicals(Consumption)</h4>
                            <div class="clearfix"></div>
                        </div>
                       <div id="dynamic_form_container">
                       
                       </div>
                       <div class="form-group">
                       </div>  
                      
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-6 col-xs-12">
						  <div class="col-md-offset-4 col-md-4">
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
    var product_select="<div class='col-md-2 col-sm-4 col-xs-12'>\n<select name='Product-List[]' class='form-control product_select'>\n<option value='not_selected' selected>Choose Product</option>\n";
    
    
$(document).ready(function(){
    
        var today = moment().format('YYYY-MM-DD');
        $("#lot_duplicate_error").hide();
        $("#Date").val(today);
        for(i in products){
            product_select+="<option value='"+products[i].product_name+"'>"+products[i].product_name+"</option>\n";
        }
        product_select+="</select></div>  <div class='category_div'><input name='Category-List[]' type='hidden' value='0'></div>";
        
        form_html="<div class='dynamic_form_content'>"+product_select+"<div class='input_qty col-md-2 col-sm-4 col-xs-12'><input name='Quantity-List[]' step='0.001' min='0' type='number' placeholder='Quantity Of' required='required' class='form-control col-md-7 col-xs-12 qty_number'></div><div class='hide-div col-md-2 col-sm-4 col-xs-12 maximum_qty'><input name='max_qty[]'  type='text' class='form-control col-md-7 col-xs-12' placeholder='Available Qty' readonly/></div><div class='hide-div col-md-2 col-sm-4 col-xs-12 rate_div'><input name='Rate-List[]' type='text' placeholder='Rate' required='required' class='form-control col-md-7 col-xs-12' readonly></div><div class='hide-div col-md-2 col-sm-4 col-xs-12 amount_div'><input name='Amount-List[]' type='text' placeholder='Amount' required='required' class='form-control col-md-7 col-xs-12' readonly></div><div class='col-md-1'><button type='button' class='btn btn-warning btn-block form_add'>Add</button></div><div class='col-md-1'><button type='button' class='btn btn-danger btn-block form_del'>Del</button></div><div class='form-group'></div></div>";
        
        var first_form_element="<div class='dynamic_form_content'>"+product_select+"<div class='input_qty col-md-2 col-sm-4 col-xs-12'><input name='Quantity-List[]' type='number' min='0' step='0.001' placeholder='Quantity Of' required='required' class='form-control col-md-7 col-xs-12 qty_number'></div><div class='hide-div col-md-2 col-sm-4 col-xs-12 maximum_qty'><input name='max_qty[]'  type='text' class='form-control col-md-7 col-xs-12' placeholder='Available Qty' readonly/></div><div class='hide-div col-md-2 col-sm-4 col-xs-12 rate_div'><input name='Rate-List[]' type='text' placeholder='Rate' required='required' class='form-control col-md-7 col-xs-12' readonly></div><div class='hide-div col-md-2 col-sm-4 col-xs-12 amount_div'><input name='Amount-List[]' type='text' placeholder='Amount' required='required' class='form-control col-md-7 col-xs-12' readonly></div><div class='col-md-2'><button type='button' class='btn btn-warning btn-block form_add'>Add</button></div><div class='form-group'></div></div>";
        
        $('#dynamic_form_container').append(first_form_element);    
    
        <?php
            if($data_present){?>
                var product_json=<?php echo $results['products'];?>;
                for(var i=0;i<product_json.length;i++){
                    setProductData(product_json[i],i);
                }
        <?php }?>
    
        
});
    
    $('#dynamic_form_container').on('click','.form_add',function(){
        $(this).parent().parent().parent().append(form_html);
    });
    
    $('#dynamic_form_container').on('click','.form_del',function(){
        $(this).parent().parent().remove();
        calculatePrice()
    });
    
    //Cost calculation Logic
    function calculatePrice(){
        var parent=$('#dynamic_form_container');
        
        var total=getNumber(0,2);
        var dyes_total=getNumber(0,2);
        var chemical_total=getNumber(0,2);
        
        var profit=$("#Profit").val();
        profit=parseInt(profit);
        
        var weight=$("#Weight").val();
        weight=parseFloat(weight);
        
        var overhead=$("#Overheads").val();
        overhead=parseFloat(overhead);
        
        $(parent).find('.dynamic_form_content').each(function(){
            var category=$(this).find('.category_div input').val();
            var rate=$(this).find('.rate_div input').val();
            var quantity=$(this).find('.input_qty input').val();
            rate=getNumber(rate,2);
            quantity=getNumber(quantity,3);
            var amount=getNumber(parseFloat(rate)*parseFloat(quantity),2);
            $(this).find('.amount_div input').val(getNumber(amount,2));
            
            if(parseInt(category)===1){
                dyes_total=getNumber(parseFloat(dyes_total)+parseFloat(amount),2);
            }
            else if(parseInt(category)===2){
                chemical_total=getNumber(parseFloat(chemical_total)+parseFloat(amount),2);
            }
            total=parseFloat(total)+parseFloat(amount);
            total=getNumber(total,2);
            
        });
        if(weight && overhead){
                var overhead_total=(parseFloat(overhead)*parseFloat(weight));
                overhead_total=getNumber(overhead_total,2);
                total=parseFloat(total)+parseFloat(overhead_total);
                $("#Overheads-Total").val(overhead_total);
        }
        if(profit){
            var total_profit=((parseFloat(total)*parseFloat(profit))/100);
            total=parseFloat(total)+parseFloat(total_profit);
        }
        if(weight){
            $("#Per-Kg").val(getNumber((parseFloat(total)/parseFloat(weight)),2));
            $("#Dyes-Per-Kg").val(getNumber((parseFloat(dyes_total)/parseFloat(weight)),2));
            $("#Chem-Per-Kg").val(getNumber((parseFloat(chemical_total)/parseFloat(weight)),2));
        }
        $("#Total-Price").val(getNumber(total,2));
        $("#Dyes-Total").val(dyes_total);
        $("#Chemicals-Total").val(chemical_total);
    }
    
    function getNumber(value,precison){
        if(!value){
            return 0;
        }
        return Number(parseFloat(value)).toFixed(precison);
    }
    
    $("#dynamic_form_container").on("change","select",function(){
            var parent=$(this).parents('.dynamic_form_content');
            var product_name=$(this).val();
            if(product_name!='not_selected'){
                $.post('../rest_calls/get_quantity_by_name.php',{
                    product_name:product_name
                },function(data){
                    data=$.parseJSON(data);
                    quantity=parseInt(data.quantity);
                    rate=parseFloat(data.rate);
                    $(parent).find('.maximum_qty input').val(quantity);
                    $(parent).find('.rate_div input').val(rate);
                    $(parent).find('.category_div input').val(data.category);
                    var select_tag=$(parent).find('.product_select');
                    if(data.category==1){
                        if($(select_tag).hasClass("chemical_product")){
                            $(select_tag).removeClass("chemical_product");
                        }
                        $(select_tag).addClass("dyes_product");
                    }
                    else if(data.category==2){
                        if($(select_tag).hasClass("dyes_product")){
                            $(select_tag).removeClass("dyes_product");
                        }
                        $(select_tag).addClass("chemical_product");
                    }
                    calculatePrice();
                });
            }
	});
    
    $("#Weight,#Overheads").change(function(){
        calculatePrice();
    });
    
    $("#Profit").change(function(){
        calculatePrice();
    });
    
    $('#dynamic_form_container').on("input",".input_qty input",function(){
        calculatePrice();
    });
    
    //Checking for Uniqness of Lot number
    var submit_state=false;
    
    $("#Lot-No").change(function(){
        submit_state=false;
        $("#lot_duplicate_error").hide();
    });
    
    $('form').submit(function(e){
        var type=$("#type").val();
        if(!submit_state && type!=1){
            e.preventDefault();
            var lotno=$("#Lot-No").val();
            $.post('../rest_calls/get_lot_details.php',{
                        lot_no:lotno
                    },function(data){
                        data=JSON.parse(data);
                        var status=data.status;
                        if(status=="200"){
                            $("#lot_duplicate_error").show();
                        }
                        else{
                            submit_state=true;
                            $('form').submit();
                        }
             });
        }
    });
    
    function setProductData(product,index){
        var selector=".dynamic_form_content:eq("+index+")";
        $(selector).find(".input_qty input").val(product.quantity);
        $(selector).find(".product_select").val(product.product_name);
        $(selector).find(".category_div input").val(product.category);
        $(selector).find(".rate_div input").val(product.rate);
        $(selector).find(".amount_div input").val(product.amount);
        <?php if(isset($type) && $type==2){  ?>
            $(selector).find(".product_select").change();
        <?php } ?>
        $(selector).find(".form_add").click();
    }
    $("#lot_duplicate_error a").click(function(){
        $(this).parent().hide();
    });
</script>