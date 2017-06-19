<?php
require_once '../core/init.php';
if(input::exists()){
    $db=DB::getInstance();
    $product_id=input::get('product_id');
    $query="select quantity from product where product_id=${product_id};";
    $query= $db->query_assoc($query);
    $row_count=$query->rcount();
    $response=array();
    if($row_count){
        $result=$query->first();
        $response['quantity']=$result['quantity'];
    }
    else{
        $response['quantity']=0;
    }
    echo json_encode($response);
}
?>