<?php
require_once '../core/init.php';
if(input::exists()){
    $db = DB::getInstance();
    $user=new user();
    $vendor_id=input::get('Vendor');
    $category_id=input::get('Category');
    $product_id=input::get('Product');
    $query="select * from product";
    $join="join vendors on vendors.vendor_id=product.vendor_id join category on product.category_id=category.category_id";
    
    $isset_product=false;
    $isset_vendor=false;
    $isset_category=false;
    //Creating Query and Setting flag for the Search Criteria
    if($product_id!='selected'){
        $query.=" ${join} where product.product_id=${product_id};";
        $isset_product=true;
    }
    else if($vendor_id!='selected' && $category_id!='selected'){
        $query.=" ${join} where product.vendor_id=${vendor_id} and product.category_id=${category_id};";
        $isset_category=true;
        $isset_vendor=true;
    }
    else if($vendor_id!='selected'){
        $query.=" ${join} where product.vendor_id=${vendor_id};";
        $isset_vendor=true;
    }
    else if($category_id!='selected'){
        $query.=" ${join} where product.category_id=${category_id};";
        $isset_category=true;
    }
    $result=$db->query_assoc($query)->results();
    //Creating the Search Criteria
    $search_criteria="";
    if(count($result)){
        $search_criteria="(";
        if($isset_product){
            $name=$result[0]['product_name'];
            $search_criteria.="Product-Name:${name}";
        }
        if($isset_vendor){
            $name=$result[0]['vendor_name'];
            $search_criteria.="Vendor-Name:${name},";
        }
        if($isset_category){
            $name=$result[0]['category_name'];
            $search_criteria.="Category-Name:${name}";
        }
        $search_criteria.=")";
    }
    
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
    session::flash('dyes_status_table_body',$table_body);
    session::flash('dyes_status_total_amount',$total_cost);
    redirect::to('../pages/dyes_status.php');
}
?>
