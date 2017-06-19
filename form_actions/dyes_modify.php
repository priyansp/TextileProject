<?php
require_once '../core/init.php';
if(input::exists()){
    $validate = new validate();
		$validation = $validate->check($_POST, array(
			'Date' => array(
				'required' => true,
			)
    ));
    if($validation->passed()){
        $db=DB::getInstance();
        $type=input::get('Type');
        $date=input::get('Date');
        $product_list=input::get('Product-List');
        $quantity_list=input::get('Quantity-List');
        if($type){
            //Adding Stock 
            for($iterator=0;$iterator<count($product_list);$iterator++){
                $query="select * from product where product_id=${product_list[$iterator]};";
                $is_present = $db->query_assoc($query);                
                $present_row=$is_present->first();
                $updated_quantity=$present_row['quantity']+$quantity_list[$iterator];
                if($db->update_any('product','product_id',$present_row['product_id'],array(
                'quantity' => $updated_quantity,
                ))){
                    //Adding a row in the history table
                    if($db->insert('dyes_history',array(
                    'product_id' => $present_row['product_id'],
                    'quantity' => $quantity_list[$iterator],
                    'total_quantity' => $updated_quantity,
                    'type' =>$type,
                    'date' =>$date,
                    ))){
                    }
                }   
            }
        }
        else{
            for($iterator=0;$iterator<count($product_list);$iterator++){
                
                $query="select * from product where product_id=${product_list[$iterator]};";
                
                $is_present = $db->query_assoc($query);
                    if($quantity_list[$iterator]){
                        $present_row=$is_present->first();
                        if($present_row['quantity']>=$quantity_list[$iterator]){
                            $updated_quantity=$present_row['quantity']-$quantity_list[$iterator];
                            if($db->update_any('product','product_id',$present_row['product_id'],array(
                            'quantity' => $updated_quantity,
                            ))){
                                if($db->insert('dyes_history',array(
                                'product_id' => $present_row['product_id'],
                                'quantity' => $quantity_list[$iterator],
                                'total_quantity' => $updated_quantity,
                                'type' =>$type,
                                'date' =>$date,
                                ))){
                                }
                            }
                        }
                    }
            }
        }
        session::flash("dyes_modify_success","Success!Stock has been updated successfully");
        redirect::to('../pages/dyes_modify.php');
    }
    else{
        $validation->addFlash('dyes_modify_failed');
        redirect::to('../pages/dyes_modify.php');
    }
}
?>