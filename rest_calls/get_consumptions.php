<?php
require_once '../core/init.php';
if(input::exists()){
    $db=DB::getInstance();
    $date=input::get('Date');
    $type=input::get('Type');
    $query="select sum(dyes_history.quantity) as qty,product.product_name from dyes_history join product on dyes_history.product_id=product.product_id where dyes_history.date='${date}' and dyes_history.type=${type}  group by dyes_history.product_id order by qty desc;";
    $query= $db->query_assoc($query);
    $row_count=$query->rcount();
    $response=array();
    if($row_count){
        $response=$query->results();
    }
    else{
        $response['quantity']=0;
    }
    echo json_encode($response);
}
?>