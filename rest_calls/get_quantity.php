<?php
require_once '../core/init.php';
if(input::exists()){
    $db=DB::getInstance();
    $vendor_id=input::get('vendor_id');
    $product_id=input::get('product_id');
    $query="select quantity from dyes_stock where vendor_id = ${vendor_id} and product_id=${product_id};";
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