<?php
require_once '../core/init.php';
if(input::exists()){
    $db = DB::getInstance();
    $show_table=true;
    //getting Inputs
    $vendor_id=input::get('Vendor');
    $category_id=input::get('Category');
    $product_id=input::get('Product');
    $from_date=input::get('FromDate');
    $to_date=input::get('ToDate');
    
    $table="dyes_history";
    $join="join product on product.product_id=dyes_history.product_id join vendors on vendors.vendor_id=product.vendor_id join category on product.category_id=category.category_id";
    $query="select dyes_history.quantity,dyes_history.type,dyes_history.date,vendors.vendor_name,category.category_name,product.product_name,dyes_history.total_quantity from ${table} ${join}";
    
    $isset_product=false;
    $isset_vendor=false;
    $isset_category=false;
    
    //Creating Query and Setting flag for the Search Criteria
    if($product_id!='selected'){
        $query.=" and product.product_id=${product_id}";
        $isset_product=true;
    }
    else if($vendor_id!='selected' && $category_id!='selected'){
        $query.=" where product.vendor_id=${vendor_id} and product.category_id=${category_id}";
        $isset_category=true;
        $isset_vendor=true;
    }
    else if($vendor_id!='selected'){
        $query.=" where product.vendor_id=${vendor_id}";
        $isset_vendor=true;
    }
    else if($category_id!='selected'){
        $query.=" where product.category_id=${category_id}";
        $isset_category=true;
    }
    if($from_date){
        $query.=" and dyes_history.date>='${from_date}'";
    }
    if($to_date){
        $query.=" and dyes_history.date<='${to_date}'";
    }
    $query.=" order by dyes_history.product_id,dyes_history.date;";
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
    for($i=0,$sno=1;$i<count($result);$i++,$sno++){
        $product_name=$result[$i]['product_name'];
        $vendor_name=$result[$i]['vendor_name'];
        $category_name=$result[$i]['category_name'];
        $quantity=$result[$i]['type']==0?-$result[$i]['quantity']:$result[$i]['quantity'];
        $total_quantity=$result[$i]['total_quantity'];
        $date=$result[$i]['date'];
        $type=$result[$i]['type']==0?"Deducted":"Added";
        $table_body.="<tr><td>${sno}</td><td>${product_name}</td><td>${vendor_name}</td><td>${category_name}</td><td>${quantity}</td><td>${type}</td><td>${date}</td><td>${total_quantity}</td></tr>";
    }
    session::flash('table_body',$table_body);
    redirect::to('../pages/dyes_transaction_history.php');
}
?>
