<?php
require_once '../core/init.php';
if(input::exists()){
    $db=DB::getInstance();
    $lot_no=input::get('lot_no');
    $query="select * from lot_details where lot_no=${lot_no};";
    $query= $db->query_assoc($query);
    $row_count=$query->rcount();
    $response=array();
    if($row_count){    
        $result=$query->first();
        $response=$result;
        $response['status']="200";
    }
    else{
        $response['status']="404";
    }
    echo json_encode($response);
}
?>