<?php
require_once '../core/init.php';
if(input::exists()){
    $db=DB::getInstance();
    $product_name=input::get('product_name');
    $query="select quantity,rate from product where product_name='${product_name}';";
    $query= $db->query_assoc($query);
    $row_count=$query->rcount();
    $response=array();
    if($row_count){
        $result=$query->first();
        $response['quantity']=$result['quantity'];
        $response['rate']=$result['rate'];
    }
    else{
        $response['quantity']=0;
    }
    echo json_encode($response);
}
?>