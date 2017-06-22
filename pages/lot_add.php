<?php
require '../includes/header.php';
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
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Profit(%)<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="number" id="Profit" required="required" name="Profit" class="form-control col-md-7 col-xs-12" value="<?php echo $data_present?$results['profit']:0;?>">
                        </div>
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Total<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="Total-Price"  required="required" name="Total-Price" class="form-control col-md-7 col-xs-12" readonly value="<?php echo $data_present?$results['total_price']:0;?>">
                        </div>
                        <label class="control-label col-md-1 col-sm-3 col-xs-12">Per Kg<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="Per-Kg"  required="required" name="Per-Kg" class="form-control col-md-7 col-xs-12" readonly value="<?php echo $data_present?$results['per_kg_price']:0;?>">
                        </div>
                        <div class="form-group">
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
        product_select+="</select></div>";
        
        form_html="<div class='dynamic_form_content'>"+product_select+"<div class='input_qty col-md-2 col-sm-4 col-xs-12'><input name='Quantity-List[]' step='0.001' min='0' type='number' placeholder='Quantity Of' required='required' class='form-control col-md-7 col-xs-12 qty_number'></div><div class='col-md-2 col-sm-4 col-xs-12 maximum_qty'><input name='max_qty[]'  type='text' class='form-control col-md-7 col-xs-12' placeholder='Available Qty' readonly/></div><div class='col-md-2 col-sm-4 col-xs-12 rate_div'><input name='Rate-List[]' type='text' placeholder='Rate' required='required' class='form-control col-md-7 col-xs-12' readonly></div><div class='col-md-2 col-sm-4 col-xs-12 amount_div'><input name='Amount-List[]' type='text' placeholder='Amount' required='required' class='form-control col-md-7 col-xs-12' readonly></div><div class='col-md-1'><button type='button' class='btn btn-warning btn-block form_add'>Add</button></div><div class='col-md-1'><button type='button' class='btn btn-danger btn-block form_del'>Del</button></div><div class='form-group'></div></div>";
        
        var first_form_element="<div class='dynamic_form_content'>"+product_select+"<div class='input_qty col-md-2 col-sm-4 col-xs-12'><input name='Quantity-List[]' type='number' min='0' step='0.001' placeholder='Quantity Of' required='required' class='form-control col-md-7 col-xs-12 qty_number'></div><div class='col-md-2 col-sm-4 col-xs-12 maximum_qty'><input name='max_qty[]'  type='text' class='form-control col-md-7 col-xs-12' placeholder='Available Qty' readonly/></div><div class='col-md-2 col-sm-4 col-xs-12 rate_div'><input name='Rate-List[]' type='text' placeholder='Rate' required='required' class='form-control col-md-7 col-xs-12' readonly></div><div class='col-md-2 col-sm-4 col-xs-12 amount_div'><input name='Amount-List[]' type='text' placeholder='Amount' required='required' class='form-control col-md-7 col-xs-12' readonly></div><div class='col-md-2'><button type='button' class='btn btn-warning btn-block form_add'>Add</button></div><div class='form-group'></div></div>";
        
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
    var total_amount=Number(0);
    var per_kg=Number(0);
    
    $('#dynamic_form_container').on('click','.form_del',function(){
        var amount=$(this).parents('.dynamic_form_content').find('.amount_div input').val();
        total_amount-=amount;
        total_amount=Number(total_amount).toFixed(2);
        $("#Total-Price").val(total_amount);
        setPerKg()
        addProfit()
        $(this).parent().parent().remove();
    });
    
    
    
    function calculate_total_amount(current_element){
        //Getting inputs
        var parent=$(current_element).parents('.dynamic_form_content');
        var rate=$(parent).find('.rate_div input').val();
        var previous_amount=$(parent).find('.amount_div input').val();
        var quantity=$(parent).find('.input_qty input').val();
        
        if(!previous_amount){
            previous_amount=0;
        }
        if(!quantity){
            quantity=0;
        }
        if(!rate){
            rate=0;
        }
        else{
            rate=rate.substr(3);
        }
        
        var amount=parseFloat(quantity)*parseFloat(rate);
        
        previous_amount=Number(previous_amount).toFixed(2);
        amount=Number(amount).toFixed(2);
        
        var difference_amount=amount-previous_amount;
        total_amount=parseFloat(total_amount);
        total_amount+=difference_amount;
        total_amount=Number(total_amount).toFixed(2);
        //$("#Total-Price").val(total_amount);
        $(parent).find('.amount_div input').val(amount);
        
        setPerKg();
        addProfit();
    }
    
    $("#dynamic_form_container").on("change","select",function(){
            var parent=$(this).parents('.dynamic_form_content');
            var product_name=$(this).val();
            var current_this=$(this);
            if(product_name!='not_selected'){
                $.post('../rest_calls/get_quantity_by_name.php',{
                    product_name:product_name
                },function(data){
                    data=$.parseJSON(data);
                    quantity=parseInt(data.quantity);
                    rate="Rs."+data.rate;
                    $(parent).find('.maximum_qty input').val(quantity);
                    $(parent).find('.rate_div input').val(rate);
                    //Commenting the Max qty now and will be enabling once the stock is deducted from Lot page
                    //$(parent).find('.qty_number').attr('max',quantity);
                    //Making quantity to if the available quantity is zero
                    if(!quantity){
                        $(parent).find('.qty_number').attr('min',quantity);
                    }
                    var current_quantity=$(parent).find('.qty_number').val();
                    if(current_quantity>quantity){
                        $(parent).find('.qty_number').val(0);
                    }
                    calculate_total_amount(current_this);
                });
            }
	});
    function setPerKg(){
        var weight=$('#Weight').val();
        if(weight){   
            weight=parseInt(weight);
            var perKg=parseFloat(total_amount)/weight;
            perKg=parseFloat(perKg);
            perKg=Number(perKg).toFixed(2);
            per_kg=perKg;
            //$("#Per-Kg").val(perKg);
        }
        else{
            $("#Per-Kg").val(0);
        }
    }
    
    function addProfit(){
        
        var profit_percent=$("#Profit").val();
        profit_percent=parseInt(profit_percent);
        
        var totaL_with_profit=(total_amount*profit_percent)/100;
        var perKg_with_profit=(per_kg*profit_percent)/100;
        
        totaL_with_profit=totaL_with_profit+parseFloat(total_amount);
        perKg_with_profit=perKg_with_profit+parseFloat(per_kg);
        
        perKg_with_profit=Number(perKg_with_profit).toFixed(2);
        totaL_with_profit=Number(totaL_with_profit).toFixed(2);;
        
        $("#Per-Kg").val(perKg_with_profit);
        $("#Total-Price").val(totaL_with_profit);
    }
    
    $("#Weight").change(function(){
        setPerKg();
        addProfit();
    });
    
    $("#Profit").change(function(){
        addProfit();
    });
    
    $('#dynamic_form_container').on("input",".input_qty input",function(){
        calculate_total_amount($(this));
    });
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
        $(selector).find(".product_select").change();
        $(selector).find(".form_add").click();
    }
    $("#lot_duplicate_error a").click(function(){
        $(this).parent().hide();
    });
</script>