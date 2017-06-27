<?php
require_once '../core/init.php';
if(input::exists()){
    $db = DB::getInstance();
    $user=new user();
    $vendor_id=input::get('Vendor');
    $category_id=input::get('Category');
    $product_id=input::get('Product');
    $date=input::get('Date');
    $query="";
    if($date==date("Y-m-d")){
        $query="select * from product";
        $join="join vendors on vendors.vendor_id=product.vendor_id join category on product.category_id=category.category_id";

        if($product_id!='selected'){
            $query.=" ${join} where product.product_id=${product_id};";
        }
        else if($vendor_id!='selected' && $category_id!='selected'){
            $query.=" ${join} where product.vendor_id=${vendor_id} and product.category_id=${category_id}";
        }
        else if($vendor_id!='selected'){
            $query.=" ${join} where product.vendor_id=${vendor_id}";
        }
        else if($category_id!='selected'){
            $query.=" ${join} where product.category_id=${category_id}";
        }
        $query.=" order by LOWER(product.product_name);";
    }
    else{
        $category="";
        if($category_id!='selected'){
            $category="where category.category_id=${category_id}";
        }
        $query="select product.product_name,product.rate,a.total_quantity as quantity,vendors.vendor_name,category.category_name,product.reorder_qty from (select dyes_history.* from dyes_history where dyes_history.history_id in (select max(dyes_history.history_id) from dyes_history where dyes_history.date<='${date}' group by dyes_history.product_id)) a right join product on product.product_id=a.product_id join category on product.category_id=category.category_id join vendors on vendors.vendor_id=product.vendor_id ${category} order by product.product_name";
    }
    $result=$db->query_assoc($query)->results();
//    print_r($result);

    //Generating the Table for the Search
    $table_body="";
    $total_cost="";
    for($i=0,$sno=1;$i<count($result);$i++,$sno++){
        $product_name=$result[$i]['product_name'];
        $vendor_name=$result[$i]['vendor_name'];
        $category_name=$result[$i]['category_name'];
        $quantity=$result[$i]['quantity']?$result[$i]['quantity']:0;
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
