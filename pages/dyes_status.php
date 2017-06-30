<?php
require '../includes/header.php';
if(!$user->checkAccess("dyes_status")){
    redirect::to("login.php");
}
$db = DB::getInstance();

$categories = $db->query_assoc("select * from category order by LOWER(category_name);");
$categories = $categories->results();

$products = $db->query_assoc("select * from product order by LOWER(product_name);");
$products = $products->results();

$vendors = $db->query_assoc("select * from vendors where type=1 order by LOWER(vendor_name);");
$vendors = $vendors->results();
$query="select * from product";
$join="join vendors on vendors.vendor_id=product.vendor_id join category on product.category_id=category.category_id";
$query.=" ${join} order by LOWER(product.product_name);";
$result=$db->query_assoc($query)->results();

//Generating the Table for the Search
$table_body="";
$total_cost="";
for($i=0,$sno=1;$i<count($result);$i++,$sno++){
    $product_name=$result[$i]['product_name'];
    $vendor_name=$result[$i]['vendor_name'];
    $category_name=$result[$i]['category_name'];
    $quantity=$result[$i]['quantity'];
    $reorder_quantity=$result[$i]['reorder_qty'];
    $rate=$result[$i]['rate'];
    $amount=$result[$i]['rate']*$result[$i]['quantity'];
    $total_cost+=$amount;
    $table_body.="<tr ";
    if($quantity<=$reorder_quantity){
        $table_body.="class='make_red'";
    }
    $table_body.="><td>${sno}</td><td>${product_name}</td><td>${vendor_name}</td><td>${category_name}</td><td>${reorder_quantity}</td><td>${quantity}</td>";
    if($user->data()->group==1){
        $table_body.="<td>${rate}</td><td>${amount}</td>";
    }
    $table_body.="</tr>";
}
?>
<div class="right_col" role="main">
    <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Dyes Stock Status(Choose Atleast Any One Value)</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form action="../form_actions/dyes_status.php" method="post" id="product-form" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <select class="form-control" name="Category" required>
                               <option value='selected' selected>Choose Category</option>
                            <?php
                                for($x=0;$x<sizeof($categories);$x++){
                                echo "<option value='".$categories[$x]['category_id']."' >".$categories[$x]['category_name']."</option>";
                                } 
                            ?>
                          </select>                    
                        </div>
                                        
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <select class="form-control" name="Product" id="Product" required>
                               <option value='selected' selected>Choose Product</option>
                            <?php
                                for($x=0;$x<sizeof($products);$x++){
                                echo "<option value='".$products[$x]['product_id']."' >".$products[$x]['product_name']."</option>";
                                } 
                            ?>
                          </select>
                        </div>
                        
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <select class="form-control" name="Vendor" id="Vendor" required>
                               <option value='selected' selected>Choose Vendor</option>
                            <?php
                                for($x=0;$x<sizeof($vendors);$x++){
                                echo "<option value='".$vendors[$x]['vendor_id']."' >".$vendors[$x]['vendor_name']."</option>";
                                } 
                            ?>
                          </select>
                        </div>
                        
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <input type="date" id="Date" name="Date" class="form-control col-md-7 col-xs-12">
                        </div>
                        
                        <div class="form-group">
                            
                        </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-6 col-xs-12">
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
    <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                   <div class="col-md-6">
                        <h2>Stock Details</h2>   
                   </div>
                   <?php
                    if($user->data()->group==1){?>
                    <div class="col-md-6">
                        <div class="col-md-offset-8 col-md-4">
                            <button class="btn btn-warning btn-block" id="download_button">Download</button>
                            <a href="" id="download_link" style="display:none">Download Link</a>    
                        </div>    
                    </div>
                    <?php } ?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" id="table_div">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Product</th>
                          <th>Vendor</th>
                          <th>Category</th>
                          <th>Reorder Qty</th>
                          <th>Quantity</th>
                          <?php 
                            if($user->data()->group==1){?>
                          <th>Rate</th>
                          <th>Amount</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            if(session::exists('dyes_status_table_body')){
                            echo session::flash('dyes_status_table_body');
                            }else{
                                echo $table_body;
                            }
                            if(session::exists('dyes_status_total_amount')){
                                $total_cost=session::flash('dyes_status_total_amount');
                            }
                          ?>
                      </tbody>
                    </table>
                    <?php
                    if($user->data()->group==1){?>
                    <div class="form-group">
                        <label style="margin-top:10px"class="control-label col-md-offset-9 col-md-1 col-sm-3 col-xs-12" for="Vendor-Name">TotalCost
                        </label>
                        <div class="col-md-2 col-sm-3 col-xs-12">
                          <input type="text" value="<?php echo $total_cost; ?>" id="Total-Cost" name="Total-Cost" class="form-control col-md-7 col-xs-12" disabled>
                        </div>
                    </div>
                    <?php }?>
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
    
    var today = moment().format('YYYY-MM-DD');
    $('#Date').val(today);
    $('form').submit(function(e){
        var select=$(this).find('select');
        var status=true;
        $(select).each(function(){
            if($(this).val()!='selected'){
                status=false;
            }
        });
        if($("#Date").val()!=today && $("#Date").val()!=""){
            status=false;
        }
        if(status){
            e.preventDefault();
            $(select).addClass('select_errored');
        }
    });
    
    $("#Date").change(function(){
        if($("#Date").val()==today){
            $("#Product").prop("disabled",false);
            $("#Vendor").prop("disabled",false);
        }
        else{
            $("#Product").prop("disabled",true);
            $("#Vendor").prop("disabled",true);
        }
    });
    
    $('body').on("click","#download_button",function(){
        var data= $("#datatable").dataTable()._('tr', {"filter": "applied"});
        var table = $('#datatable').DataTable();
        var headers=table.columns().header();
        var csv=makeCSV(data,headers);
        window.URL = window.URL || window.webkiURL;
        var blob = new Blob([csv]);
        var filename="dyes_status"+moment().format('YYYY-MM-DD')+".csv";
        var blobURL = window.URL.createObjectURL(blob);
        $('#download_link').attr("download",filename).attr("href",blobURL);
        $('#download_link')[0].click();
    });
    var timeout=null;
    $('body').on("input","#table_div input[type=search]",function(){
        clearTimeout(timeout);
        timeout=setTimeout(function(){
            var data= $("#datatable").dataTable()._('tr', {"filter": "applied"});
            var amount=0;
            for(var i=0;i<data.length;i++) {
                amount+=parseInt(data[i][7]);
            }
            $("#Total-Cost").val(amount);
        },500);
    });
});

function makeCSV(data,header){
    var CSV="";
    var seperator=",";
    var HEADER="";
    var FOOTER="";
    for(var i=0;i<header.length;i++){
        HEADER+=header[i].innerHTML+seperator;
        if((header.length-i)>2){
            FOOTER+=",";
        }
    }
    var total_cost=$("#Total-Cost").val();
    FOOTER+="Total-Cost,";
    FOOTER+=total_cost;
    for(var i=0;i<data.length;i++) {
        CSV+=i+1;
        for(var j=1;j<data[i].length;j++){
            CSV+=seperator+data[i][j];
        }
        CSV+="\n";
    }
    HEADER+="\n";
    return HEADER+CSV+FOOTER;
}

</script>